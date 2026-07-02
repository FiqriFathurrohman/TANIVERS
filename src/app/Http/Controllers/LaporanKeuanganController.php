<?php

namespace App\Http\Controllers;

use App\Models\ExecutionExpense;
use App\Models\HarvestReport;
use App\Models\PreProductionPlan;
use App\Services\FinancialAnalyticsService; // <-- Import Service baru untuk kalkulator ROI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $plans = PreProductionPlan::with(['lahan', 'commodity', 'commodityType'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $selectedPlan = null;

        if ($request->filled('plan_id')) {
            $selectedPlan = $plans->firstWhere('id', (int) $request->query('plan_id'));
        }

        if (! $selectedPlan) {
            $selectedPlan = $plans->first();
        }

        $expenseReports = collect();
        $harvestReports = collect();

        $budget = 0;
        $totalExpense = 0;
        $totalIncome = 0;
        $remainingBudget = 0;
        $netProfit = 0;
        $expenseByCategory = collect();
        $recommendations = [];

        if ($selectedPlan) {
            $budget = (float) ($selectedPlan->budget ?? 0);

            $expenseReports = ExecutionExpense::with(['items'])
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->latest()
                ->get();

            $harvestReports = HarvestReport::query()
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->latest()
                ->get();

            $totalExpense = (float) $expenseReports->sum('total_amount');
            $totalIncome = (float) $harvestReports->sum('total_income');
            $remainingBudget = $budget - $totalExpense;
            $netProfit = $totalIncome - $totalExpense;

            $expenseByCategory = $expenseReports
                ->flatMap(fn ($expense) => $expense->items)
                ->groupBy('category')
                ->map(function ($items, $category) {
                    return [
                        'category' => $category,
                        'label' => ucwords(str_replace('_', ' ', $category)),
                        'total' => (float) $items->sum('amount'),
                        'count' => $items->count(),
                    ];
                })
                ->sortByDesc('total')
                ->values();

            if ($budget > 0 && $totalExpense > $budget) {
                $recommendations[] = 'Pengeluaran sudah melebihi anggaran awal. Perlu evaluasi biaya untuk kebutuhan berikutnya.';
            } elseif ($budget > 0 && $totalExpense >= ($budget * 0.8)) {
                $recommendations[] = 'Pengeluaran sudah mendekati anggaran awal. Gunakan sisa anggaran untuk kebutuhan paling prioritas.';
            } elseif ($budget > 0) {
                $recommendations[] = 'Pengeluaran masih berada di bawah anggaran awal. Kondisi anggaran masih cukup aman.';
            }

            if ($expenseByCategory->isNotEmpty()) {
                $highestCategory = $expenseByCategory->first();
                $recommendations[] = 'Pengeluaran terbesar ada pada kategori ' . $highestCategory['label'] . '. Bagian ini bisa menjadi fokus evaluasi biaya.';
            }

            if ($totalIncome > 0 && $netProfit > 0) {
                $recommendations[] = 'Pendapatan panen lebih besar dari pengeluaran. Masa tanam ini menghasilkan keuntungan.';
            } elseif ($totalIncome > 0 && $netProfit < 0) {
                $recommendations[] = 'Pendapatan panen belum menutup seluruh pengeluaran. Perlu evaluasi biaya produksi dan harga jual.';
            } elseif ($totalIncome <= 0) {
                $recommendations[] = 'Data hasil panen belum diinput. Laba/rugi akan lebih akurat setelah pendapatan panen dicatat.';
            }
        }

        return view('laporan-keuangan.index', compact(
            'plans',
            'selectedPlan',
            'expenseReports',
            'harvestReports',
            'budget',
            'totalExpense',
            'totalIncome',
            'remainingBudget',
            'netProfit',
            'expenseByCategory',
            'recommendations'
        ));
    }

    public function storeHarvest(Request $request) 
    { 
        if (! Auth::check()) { 
            return redirect()->route('login'); 
        } 

        $validated = $request->validate([ 
            'pre_production_plan_id' => 'required|exists:pre_production_plans,id', 
            'harvest_date' => 'required|date', 
            'quantity' => 'required|numeric|min:0.01', 
            'unit' => 'required|string|max:50', 
            'price_per_unit' => 'required|numeric|min:1', 
            'notes' => 'nullable|string|max:1000', 
        ]); 

        $plan = PreProductionPlan::where('id', $validated['pre_production_plan_id']) 
            ->where('user_id', Auth::id()) 
            ->firstOrFail(); 

        // ==========================================
        // GEMBOK 3: VALIDASI HARI PANEN
        // ==========================================
        // Aturan asli: Panen minimal H-7 dari total durasi
        $batasPanen = $plan->duration_days - 7; 

        // [TIPS PRESENTASI DOSEN]: 
        // Kalau pas presentasi lu mau bypass biar bisa langsung panen di hari ke-1,
        // cukup tambahkan tanda // di depan fungsi if di bawah ini.
        if ((int) $plan->current_day < $batasPanen) {
            return back()->withErrors([
                'harvest_error' => "Akses Ditolak! Tanaman belum siap panen. Saat ini baru hari ke-{$plan->current_day} dari total masa tanam {$plan->duration_days} hari."
            ])->withInput();
        }
        // ==========================================

        $quantity = (float) $validated['quantity']; 
        $pricePerUnit = (float) $validated['price_per_unit']; 
        $totalIncome = $quantity * $pricePerUnit; 

        // 1. Simpan Data Panen
        HarvestReport::create([ 
            'user_id' => Auth::id(), 
            'pre_production_plan_id' => $plan->id, 
            'harvest_date' => $validated['harvest_date'], 
            'quantity' => $quantity, 
            'unit' => $validated['unit'], 
            'price_per_unit' => $pricePerUnit, 
            'total_income' => $totalIncome, 
            'notes' => $validated['notes'] ?? null, 
        ]); 

        // 2. BUKA GEMBOK LAHAN (Penting Banget!)
        // Nonaktifkan plan ini agar lahan bisa digunakan kembali untuk perancangan baru
        $plan->update([ 
            'is_active' => false 
        ]); 

        return redirect() 
            ->route('laporan-keuangan.index', ['plan_id' => $plan->id]) 
            ->with('success', 'Data hasil panen berhasil disimpan. Lahan sekarang siap untuk ditanami kembali!'); 
    }

    // --- API BARU UNTUK KALKULATOR ANALITIK FINANSIAL ---
    public function getFinancialAnalysis(Request $request, FinancialAnalyticsService $financialService)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
        ]);

        // Cari rencana tanam terakhir yang aktif di lahan tersebut
        $plan = PreProductionPlan::where('lahan_id', $request->lahan_id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$plan) {
            return response()->json(['message' => 'Belum ada data rencana tanam yang aktif untuk lahan ini.'], 404);
        }

        // Eksekusi kalkulasi ROI & BEP melalui Service
        $analytics = $financialService->calculateROI($plan);

        return response()->json($analytics);
    }
}