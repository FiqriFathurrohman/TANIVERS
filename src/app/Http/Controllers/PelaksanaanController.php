<?php

namespace App\Http\Controllers;

use App\Models\ExecutionPestReport;
use App\Models\ExecutionTaskCheck;
use App\Models\Pest;
use App\Models\PlantingGuideTask;
use App\Models\PreProductionPlan;
use App\Models\Disease;
use App\Models\ExecutionExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $plans = PreProductionPlan::with([
                'lahan',
                'commodity',
                'commodityType',
                'plantingGuide.phases.tasks',
            ])
            ->where('user_id', Auth::id())
            ->where('is_active', true)
            ->latest()
            ->get();

        $selectedPlan = null;

        if ($request->filled('plan_id')) {
            $selectedPlan = $plans->firstWhere('id', (int) $request->query('plan_id'));
        }

        if (! $selectedPlan) {
            $selectedPlan = $plans->first();
        }

        $currentPhase = null;
        $todayTasks = collect();
        $checkedTaskIds = collect();

        if ($selectedPlan && $selectedPlan->plantingGuide) {
            $currentDay = (int) $selectedPlan->current_day;

            $currentPhase = $selectedPlan->plantingGuide->phases
                ->first(function ($phase) use ($currentDay) {
                    return $currentDay >= (int) $phase->start_day
                        && $currentDay <= (int) $phase->end_day;
                });

            if ($currentPhase) {
                $todayTasks = $currentPhase->tasks
                    ->filter(function ($task) use ($currentDay) {
                        return $this->shouldTaskAppear($task, $currentDay);
                    })
                    ->values();

                $checkedTaskIds = ExecutionTaskCheck::where('user_id', Auth::id())
                    ->where('pre_production_plan_id', $selectedPlan->id)
                    ->where('day_number', $currentDay)
                    ->where('is_done', true)
                    ->pluck('planting_guide_task_id');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Data Hama dari Admin
        |--------------------------------------------------------------------------
        | Data ini dipakai di halaman Pelaksanaan.
        | User memilih hama, lalu rekomendasi penanganan diambil dari data admin.
        */
        $pests = Pest::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
    
        $diseases = Disease::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Riwayat Laporan Hama User
        |--------------------------------------------------------------------------
        | Diambil berdasarkan Pra Production / Lahan yang sedang dipilih.
        */
        $pestReports = collect();

        if ($selectedPlan) {
            $pestReports = ExecutionPestReport::with(['pest', 'disease'])
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->latest()
                ->get();
            }
        
            $expenseReports = collect();
            $expenseTotal = 0;
            
            if ($selectedPlan) {
                $expenseReports = ExecutionExpense::with('items')
                    ->where('user_id', Auth::id())
                    ->where('pre_production_plan_id', $selectedPlan->id)
                    ->latest()
                    ->get();
            
                $expenseTotal = $expenseReports->sum('total_amount');
            }

            return view('pelaksanaan.index', compact(
                'plans',
                'selectedPlan',
                'currentPhase',
                'todayTasks',
                'checkedTaskIds',
                'pests',
                'diseases',
                'pestReports',
                'expenseReports',
                'expenseTotal'
            ));
    }

    public function storeDailyReport(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'pre_production_plan_id' => 'required|exists:pre_production_plans,id',
            'day_number' => 'required|integer|min:1',

            'tasks' => 'nullable|array',

            'report_type' => 'nullable|in:hama,penyakit',
            'pest_id' => 'nullable|exists:pests,id',
            'disease_id' => 'nullable|exists:diseases,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pest_notes' => 'nullable|string|max:1000',

            'expense_date' => 'nullable|date',
            'expense_notes' => 'nullable|string|max:1000',
            'items' => 'nullable|array',
            'items.*.category' => 'nullable|string|max:100',
            'items.*.item_name' => 'nullable|string|max:255',
            'items.*.amount' => 'nullable|numeric|min:1',
            'items.*.description' => 'nullable|string|max:1000',
        ]);

        $plan = PreProductionPlan::with('plantingGuide')
            ->where('id', $validated['pre_production_plan_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $dayNumber = (int) $validated['day_number'];

        if ($dayNumber > (int) $plan->duration_days) {
            return back()->withErrors([
                'day_number' => "Hari tanam tidak boleh melebihi total masa tanam {$plan->duration_days} hari.",
            ]);
        }

        // 1. Simpan checklist harian
        if ($plan->plantingGuide) {
            $checkedTaskIds = collect(array_keys($request->input('tasks', [])))
                ->map(fn ($id) => (int) $id);

            $todayTasks = PlantingGuideTask::query()
                ->whereHas('phase', function ($query) use ($plan) {
                    $query->where('planting_guide_id', $plan->plantingGuide->id);
                })
                ->where('start_day', '<=', $dayNumber)
                ->where('end_day', '>=', $dayNumber)
                ->orderBy('start_day')
                ->get();

            foreach ($todayTasks as $task) {
                $isDone = $checkedTaskIds->contains((int) $task->id);

                ExecutionTaskCheck::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'pre_production_plan_id' => $plan->id,
                        'planting_guide_task_id' => $task->id,
                        'day_number' => $dayNumber,
                    ],
                    [
                        'is_done' => $isDone,
                        'checked_at' => $isDone ? now() : null,
                    ]
                );
            }
        }

        // 2. Simpan laporan hama/penyakit hanya kalau formnya diisi
        $hasPestReport = $request->filled('pest_id')
            || $request->filled('disease_id')
            || $request->hasFile('photo')
            || $request->filled('pest_notes');

        if ($hasPestReport) {
            $reportType = $validated['report_type'] ?? 'hama';

            if ($reportType === 'hama' && ! $request->filled('pest_id')) {
                return back()->withErrors([
                    'pest_id' => 'Pilih hama terlebih dahulu sebelum menyimpan laporan hama.',
                ])->withInput();
            }

            if ($reportType === 'penyakit' && ! $request->filled('disease_id')) {
                return back()->withErrors([
                    'disease_id' => 'Pilih penyakit terlebih dahulu sebelum menyimpan laporan penyakit.',
                ])->withInput();
            }

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $folder = $reportType === 'penyakit'
                    ? 'penyakit-reports'
                    : 'hama-reports';

                $photoPath = $request->file('photo')->store($folder, 'public');
            }

            ExecutionPestReport::create([
                'user_id' => Auth::id(),
                'pre_production_plan_id' => $plan->id,
                'report_type' => $reportType,
                'pest_id' => $reportType === 'hama' ? ($validated['pest_id'] ?? null) : null,
                'disease_id' => $reportType === 'penyakit' ? ($validated['disease_id'] ?? null) : null,
                'day_number' => $dayNumber,
                'photo_path' => $photoPath,
                'notes' => $validated['pest_notes'] ?? null,
            ]);
        }

        // 3. Simpan pengeluaran hanya kalau ada nominal yang diisi
        $expenseItems = collect($request->input('items', []))
            ->filter(fn ($item) => isset($item['amount']) && (float) $item['amount'] > 0)
            ->values();

        if ($expenseItems->isNotEmpty()) {
            foreach ($expenseItems as $index => $item) {
                if (empty($item['category'])) {
                    return back()->withErrors([
                        "items.$index.category" => 'Jenis pengeluaran wajib dipilih jika nominal diisi.',
                    ])->withInput();
                }
            }

            $totalAmount = $expenseItems->sum(fn ($item) => (float) $item['amount']);

            $expense = ExecutionExpense::create([
                'user_id' => Auth::id(),
                'pre_production_plan_id' => $plan->id,
                'expense_date' => $validated['expense_date'] ?? now()->toDateString(),
                'day_number' => $dayNumber,
                'total_amount' => $totalAmount,
                'notes' => $validated['expense_notes'] ?? null,
            ]);

            foreach ($expenseItems as $item) {
                $expense->items()->create([
                    'category' => $item['category'],
                    'item_name' => $item['item_name'] ?? null,
                    'amount' => $item['amount'],
                    'description' => $item['description'] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('pelaksanaan.index', ['plan_id' => $plan->id])
            ->with('success', 'Laporan pelaksanaan berhasil disimpan.');
    }

    public function updateDay(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'pre_production_plan_id' => 'required|exists:pre_production_plans,id',
            'current_day' => 'required|integer|min:1',
        ]);

        $plan = PreProductionPlan::where('id', $validated['pre_production_plan_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ((int) $validated['current_day'] > (int) $plan->duration_days) {
            return back()
                ->withErrors([
                    'current_day' => "Hari tanam tidak boleh melebihi total masa tanam {$plan->duration_days} hari.",
                ]);
        }

        $plan->update([
            'current_day' => (int) $validated['current_day'],
        ]);

        return redirect()
            ->route('pelaksanaan.index', ['plan_id' => $plan->id])
            ->with('success', "Hari tanam berhasil diubah ke hari ke-{$validated['current_day']}.");
    }

    public function updateChecklist(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'pre_production_plan_id' => 'required|exists:pre_production_plans,id',
            'day_number' => 'required|integer|min:1',
            'tasks' => 'nullable|array',
        ]);

        $plan = PreProductionPlan::with(['plantingGuide.phases.tasks'])
            ->where('id', $validated['pre_production_plan_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $currentDay = (int) $validated['day_number'];

        if ($currentDay > (int) $plan->duration_days) {
            return back()
                ->withErrors([
                    'day_number' => "Hari tanam tidak boleh melebihi total masa tanam {$plan->duration_days} hari.",
                ]);
        }

        $currentPhase = $plan->plantingGuide?->phases
            ->first(function ($phase) use ($currentDay) {
                return $currentDay >= (int) $phase->start_day
                    && $currentDay <= (int) $phase->end_day;
            });

        if (! $currentPhase) {
            return back()
                ->withErrors([
                    'day_number' => 'Fase untuk hari tanam ini tidak ditemukan.',
                ]);
        }

        $availableTasks = $currentPhase->tasks
            ->filter(function ($task) use ($currentDay) {
                return $this->shouldTaskAppear($task, $currentDay);
            })
            ->values();

        $checkedTaskIds = collect(array_keys($request->input('tasks', [])))
            ->map(fn ($id) => (int) $id)
            ->toArray();

        foreach ($availableTasks as $task) {
            $isDone = in_array((int) $task->id, $checkedTaskIds, true);

            ExecutionTaskCheck::updateOrCreate(
                [
                    'pre_production_plan_id' => $plan->id,
                    'planting_guide_task_id' => $task->id,
                    'day_number' => $currentDay,
                ],
                [
                    'user_id' => Auth::id(),
                    'is_done' => $isDone,
                    'checked_at' => $isDone ? now() : null,
                ]
            );
        }

        return redirect()
            ->route('pelaksanaan.index', ['plan_id' => $plan->id])
            ->with('success', 'Checklist pelaksanaan berhasil diperbarui.');
    }

    public function storeExpense(Request $request)
    {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $validated = $request->validate([
        'pre_production_plan_id' => 'required|exists:pre_production_plans,id',
        'day_number' => 'required|integer|min:1',
        'expense_date' => 'required|date',
        'notes' => 'nullable|string|max:1000',

        'items' => 'required|array|min:1',
        'items.*.category' => 'required|string|max:100',
        'items.*.item_name' => 'nullable|string|max:255',
        'items.*.amount' => 'required|numeric|min:1',
        'items.*.description' => 'nullable|string|max:1000',
    ]);

    $plan = PreProductionPlan::where('id', $validated['pre_production_plan_id'])
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $dayNumber = (int) $validated['day_number'];

    if ($dayNumber > (int) $plan->duration_days) {
        return back()->withErrors([
            'day_number' => "Hari tanam tidak boleh melebihi total masa tanam {$plan->duration_days} hari.",
        ]);
    }

    $items = collect($validated['items'])
        ->filter(fn ($item) => isset($item['amount']) && (float) $item['amount'] > 0)
        ->values();

    if ($items->isEmpty()) {
        return back()->withErrors([
            'items' => 'Minimal harus ada 1 pengeluaran yang nominalnya diisi.',
        ]);
    }

    $totalAmount = $items->sum(fn ($item) => (float) $item['amount']);

    $expense = ExecutionExpense::create([
        'user_id' => Auth::id(),
        'pre_production_plan_id' => $plan->id,
        'expense_date' => $validated['expense_date'],
        'day_number' => $dayNumber,
        'total_amount' => $totalAmount,
        'notes' => $validated['notes'] ?? null,
    ]);

    foreach ($items as $item) {
        $expense->items()->create([
            'category' => $item['category'],
            'item_name' => $item['item_name'] ?? null,
            'amount' => $item['amount'],
            'description' => $item['description'] ?? null,
        ]);
    }

    return redirect()
        ->route('pelaksanaan.index', ['plan_id' => $plan->id])
        ->with('success', 'Pengeluaran harian berhasil disimpan.');
    }

    public function storePestReport(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'pre_production_plan_id' => 'required|exists:pre_production_plans,id',
            'report_type' => 'required|in:hama,penyakit',
            'pest_id' => 'nullable|required_if:report_type,hama|exists:pests,id',
            'disease_id' => 'nullable|required_if:report_type,penyakit|exists:diseases,id',
            'day_number' => 'required|integer|min:1',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        $plan = PreProductionPlan::where('id', $validated['pre_production_plan_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $dayNumber = (int) $validated['day_number'];

        if ($dayNumber > (int) $plan->duration_days) {
            return back()->withErrors([
                'day_number' => "Hari tanam tidak boleh melebihi total masa tanam {$plan->duration_days} hari.",
            ]);
        }

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $folder = $validated['report_type'] === 'penyakit'
                ? 'penyakit-reports'
                : 'hama-reports';

            $photoPath = $request->file('photo')->store($folder, 'public');
        }

        ExecutionPestReport::create([
            'user_id' => Auth::id(),
            'pre_production_plan_id' => $plan->id,
            'report_type' => $validated['report_type'],
            'pest_id' => $validated['report_type'] === 'hama' ? $validated['pest_id'] : null,
            'disease_id' => $validated['report_type'] === 'penyakit' ? $validated['disease_id'] : null,
            'day_number' => $dayNumber,
            'photo_path' => $photoPath,
            'notes' => $validated['notes'] ?? null,
        ]);

        $message = $validated['report_type'] === 'penyakit'
            ? 'Laporan penyakit berhasil dikirim.'
            : 'Laporan hama berhasil dikirim.';

        return redirect()
            ->route('pelaksanaan.index', ['plan_id' => $plan->id])
            ->with('success', $message);
    }                                                                                                           

    private function shouldTaskAppear(PlantingGuideTask $task, int $day): bool
    {
        $startDay = (int) $task->start_day;
        $endDay = (int) $task->end_day;

        if ($day < $startDay || $day > $endDay) {
            return false;
        }

        if ($task->repeat_type === 'once') {
            return $day === $startDay;
        }

        if ($task->repeat_type === 'interval') {
            $interval = (int) ($task->repeat_interval_days ?: 1);

            return (($day - $startDay) % $interval) === 0;
        }

        return true;
    }
}