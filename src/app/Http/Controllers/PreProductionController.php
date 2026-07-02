<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityType;
use App\Models\Lahan;
use App\Models\PlantingGuide;
use App\Models\PreProductionPlan;
use App\Models\HarvestReport; // Ditambahkan untuk fitur Rotasi Tanaman
use App\Services\SmartAdvisorService;
use App\Services\EarlyWarningService;
use App\Services\YieldPredictionService;
use App\Services\SmartTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreProductionController extends Controller
{
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $lahans = Lahan::where('user_id', Auth::id())
            ->latest()
            ->get();

        $commodities = Commodity::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedLahanId = $request->query('lahan_id');

        return view('preproduction.create', compact(
            'lahans',
            'commodities',
            'selectedLahanId'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
            'commodity_id' => 'required|exists:commodities,id',
            'commodity_type_id' => 'required|exists:commodity_types,id',
            'planting_status' => 'required|in:new,already_planted',
            'current_day' => 'nullable|integer|min:1',
            'budget' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // --- GEMBOK 1: CEK STATUS LAHAN (1 LAHAN 1 TANAMAN AKTIF) ---
        // Ngecek apakah lahan ini masih punya perancangan yang statusnya aktif (is_active = true)
        $lahanAktif = \App\Models\PreProductionPlan::where('lahan_id', $validated['lahan_id'])
            ->where('is_active', true)
            ->first();

        if ($lahanAktif) {
            // Kalau ada yang aktif, tendang balik dan kasih pesan error!
            return back()
                ->withInput()
                ->withErrors([
                    'lahan_id' => 'Gagal! Lahan ini sedang digunakan dan belum dipanen. Harap selesaikan siklus tanam sebelumnya atau nonaktifkan status tanamnya.'
                ]);
        }
        // --- END GEMBOK 1 ---

        $lahan = Lahan::where('id', $validated['lahan_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $commodityType = CommodityType::where('id', $validated['commodity_type_id'])
            ->where('commodity_id', $validated['commodity_id'])
            ->firstOrFail();

        $plantingGuide = PlantingGuide::with(['phases.tasks'])
            ->where('commodity_type_id', $commodityType->id)
            ->where('is_active', true)
            ->first();

        if (!$plantingGuide) {
            return back()
                ->withInput()
                ->withErrors([
                    'commodity_type_id' => 'Panduan masa tanam untuk jenis komoditas ini belum dibuat di admin.',
                ]);
        }

        $durationDays = (int) $plantingGuide->duration_days;
        $currentDay = $validated['planting_status'] === 'new' ? 1 : (int) ($validated['current_day'] ?? 1);

        if ($currentDay > $durationDays) {
            return back()
                ->withInput()
                ->withErrors([
                    'current_day' => "Hari tanam tidak boleh melebihi total masa tanam {$durationDays} hari.",
                ]);
        }

        $currentPhase = $plantingGuide->phases
            ->where('start_day', '<=', $currentDay)
            ->where('end_day', '>=', $currentDay)
            ->first();

        PreProductionPlan::create([
            'user_id' => Auth::id(),
            'lahan_id' => $lahan->id,
            'commodity_id' => $validated['commodity_id'],
            'commodity_type_id' => $commodityType->id,
            'planting_guide_id' => $plantingGuide->id,
            'planting_status' => $validated['planting_status'],
            'duration_days' => $durationDays,
            'current_day' => $currentDay,
            'budget' => $validated['budget'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => true, // Ini yang jadi patokan Gembok 1 kita tadi
        ]);

        $phaseName = $currentPhase?->name ?? 'Fase tidak ditemukan';

        return redirect()
            ->route('pre-production.create')
            ->with('success', "Pra production berhasil disimpan. Saat ini tanaman berada pada hari ke-{$currentDay}, fase: {$phaseName}.");
    }
    public function commodityTypes(int $commodityId): JsonResponse
    {
        $types = CommodityType::where('commodity_id', $commodityId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($types);
    }

    public function plantingGuide(int $commodityTypeId): JsonResponse
    {
        $guide = PlantingGuide::with(['phases.tasks'])
            ->where('commodity_type_id', $commodityTypeId)
            ->where('is_active', true)
            ->first();

        if (!$guide) {
            return response()->json([
                'message' => 'Panduan masa tanam belum tersedia.',
            ], 404);
        }

        return response()->json([
            'id' => $guide->id,
            'duration_days' => $guide->duration_days,
            'phases' => $guide->phases->map(function ($phase) {
                return [
                    'id' => $phase->id,
                    'name' => $phase->name,
                    'description' => $phase->description,
                    'start_day' => $phase->start_day,
                    'end_day' => $phase->end_day,
                    'tasks' => $phase->tasks->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'description' => $task->description,
                            'start_day' => $task->start_day,
                            'end_day' => $task->end_day,
                            'repeat_type' => $task->repeat_type,
                            'repeat_interval_days' => $task->repeat_interval_days,
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    // --- API: Cek Rotasi Tanaman (Sistem Peringatan Kesuburan) ---
   // --- API: Cek Rotasi Tanaman (Sistem Peringatan Kesuburan + Hama & Penyakit) ---
   public function checkCropRotation(Request $request): JsonResponse
   {
       $request->validate([
           'lahan_id' => 'required|exists:lahans,id',
           'commodity_id' => 'required|exists:commodities,id',
           'commodity_type_id' => 'nullable|exists:commodity_types,id',
       ]);

       $lahanId = $request->lahan_id;
       $commodityId = $request->commodity_id;
       $commodityTypeId = $request->commodity_type_id;

       $commodity = \App\Models\Commodity::with('recommendedRotations')->find($commodityId);
       $maxPlanting = $commodity->max_consecutive_planting ?? 1;

       $history = \App\Models\HarvestReport::whereHas('preProductionPlan', function($query) use ($lahanId) {
           $query->where('lahan_id', $lahanId);
       })
       ->orderBy('created_at', 'desc')
       ->take($maxPlanting)
       ->get();

       $consecutiveCount = 0;
       
       foreach ($history as $report) {
           if ($report->preProductionPlan->commodity_id == $commodityId) {
               $consecutiveCount++;
           } else {
               break;
           }
       }

       if ($consecutiveCount >= $maxPlanting) {
           $recommendationText = $commodity->recovery_recommendation ?? 'Disarankan untuk merotasi dengan komoditas jenis lain.';

           if ($commodity->recommendedRotations && $commodity->recommendedRotations->count() > 0) {
               $recomNames = $commodity->recommendedRotations->pluck('name')->toArray();
               $recommendationText = 'Sangat disarankan merotasi lahan ini dengan: ' . implode(', ', $recomNames) . '.';
               
               $firstReason = $commodity->recommendedRotations->first()->pivot->reason;
               if ($firstReason) {
                   $recommendationText .= ' (Alasan: ' . $firstReason . ')';
               }
           }

           $threats = [];
           if ($commodityTypeId) {
               $pests = \App\Models\Hama::whereHas('commodityTypes', function($q) use ($commodityTypeId) {
                   $q->where('commodity_types.id', $commodityTypeId);
               })->where('is_active', true)->pluck('name')->toArray();

               $diseases = \App\Models\Disease::whereHas('commodityTypes', function($q) use ($commodityTypeId) {
                   $q->where('commodity_types.id', $commodityTypeId);
               })->where('is_active', true)->pluck('name')->toArray();

               if (count($pests) > 0) $threats[] = 'Hama (' . implode(', ', $pests) . ')';
               if (count($diseases) > 0) $threats[] = 'Penyakit (' . implode(', ', $diseases) . ')';
           }

           $threatMessage = count($threats) > 0 
               ? 'Lahan berisiko sangat tinggi memicu ledakan ' . implode(' dan ', $threats) . ' jika dipaksakan.'
               : 'Lahan berisiko kehilangan unsur hara spesifik dan rentan siklus hama endemik.';

           // --- ALGORITMA PERSENTASE "HUKUM ALAM" DINAMIS ---
           $overLimit = ($consecutiveCount - $maxPlanting) + 1; // Hitung tingkat "Ngeyel"
           $commodityName = strtolower($commodity->name);
           
           // Deteksi tanaman rentan (Bisa lu tambah lagi nanti)
           $vulnerableCrops = ['cabai', 'tomat', 'terong', 'kentang', 'bawang'];
           $isVulnerable = false;
           foreach ($vulnerableCrops as $crop) {
               if (str_contains($commodityName, $crop)) {
                   $isVulnerable = true;
                   break;
               }
           }

           // Hitung persentase efisiensi lahan
           if ($isVulnerable) {
               $efficiency = max(10, 100 - ($overLimit * 35)); // Cabai drop 35% tiap ngeyel
           } else {
               $efficiency = max(10, 100 - ($overLimit * 15)); // Padi drop 15% tiap ngeyel
           }

           // Tentukan status UI untuk frontend
           $severityLevel = 'warning';
           $fertilityTitle = 'Hara Mulai Berkurang';
           $fertilityDesc = 'Unsur hara makro menyusut. Tanaman rentan terhadap cuaca dan potensi hasil panen menurun.';

           if ($efficiency <= 65 && $efficiency > 45) {
               $severityLevel = 'danger';
               $fertilityTitle = 'Tanah Jenuh / Kritis';
               $fertilityDesc = 'Kondisi tanah kritis. Risiko penyakit tular tanah sangat tinggi. Tambah dosis pupuk masif jika dilanjutkan.';
           } elseif ($efficiency <= 45) {
               $severityLevel = 'fatal';
               $fertilityTitle = 'Kerusakan Unsur Hara';
               $fertilityDesc = 'Kondisi tanah sangat kritis! Patogen menumpuk, produksi panen diprediksi anjlok ekstrim. Rotasi mutlak diperlukan!';
           }

           return response()->json([
               'status' => 'warning',
               'is_risky' => true,
               'warning_message' => $threatMessage,
               'recommendation' => $recommendationText,
               'consecutive_count' => $consecutiveCount,
               // Data baru dikirim ke frontend:
               'efficiency' => $efficiency,
               'severity_level' => $severityLevel,
               'fertility_title' => $fertilityTitle,
               'fertility_desc' => $fertilityDesc
           ]);
       }

       return response()->json([
           'status' => 'safe',
           'is_risky' => false
       ]);
   }

    // --- API 1: Smart Advisor (Tindakan Harian) ---
    public function getSmartAdvice(Request $request, SmartAdvisorService $advisorService)
    {
        $request->validate([
            'plan_id' => 'required',
            'temp' => 'required',
            'code' => 'required',
            'humidity' => 'required',
            'wind_speed' => 'required',
        ]);

        $plan = PreProductionPlan::with(['commodityType', 'plantingGuide.phases'])
            ->where('lahan_id', $request->plan_id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$plan) {
            return response()->json([
                'status' => 'normal',
                'phase_name' => 'Belum Mulai',
                'current_day' => 0,
                'advice' => 'Lahan ini belum memiliki data Rencana Tanam aktif. Silakan masuk ke menu Pra Production.'
            ]);
        }

        $analysis = $advisorService->generateAdvice($plan, $request->only(['temp', 'code', 'humidity', 'wind_speed']));
        return response()->json($analysis);
    }

    // --- API 2: Early Warning System (Peringatan Dini) ---
    public function getEarlyWarning(Request $request, EarlyWarningService $warningService)
    {
        $request->validate([
            'plan_id' => 'required',
            'forecast' => 'required|array',
            'forecast.temperature_2m_max' => 'required|array',
            'forecast.relative_humidity_2m_max' => 'required|array',
            'forecast.weathercode' => 'required|array',
        ]);

        $plan = PreProductionPlan::with(['commodityType'])
            ->where('lahan_id', $request->plan_id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lahan belum memiliki rencana tanam aktif untuk dianalisis.'
            ], 404);
        }

        $analysis = $warningService->analyzeRisk($plan, $request->forecast);
        return response()->json($analysis);
    }

    // --- API 4: Yield Prediction (Estimasi Panen) ---
    public function getYieldPrediction(Request $request, YieldPredictionService $yieldService)
    {
        $request->validate([
            'plan_id' => 'required',
        ]);

        // Load plan beserta relasi lahan (untuk ngambil luas) dan komoditas
        $plan = PreProductionPlan::with(['lahan', 'commodityType'])
            ->where('lahan_id', $request->plan_id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lahan belum memiliki rencana tanam aktif.'
            ], 404);
        }

        $prediction = $yieldService->predict($plan);
        return response()->json($prediction);
    }

    // --- API: Smart Task Generator (Asisten Jadwal Harian) ---
    public function getSmartTasks(Request $request, SmartTaskService $taskService)
    {
        $request->validate([
            'plan_id' => 'required|exists:pre_production_plans,id',
        ]);

        $plan = PreProductionPlan::where('id', $request->plan_id)
            ->where('user_id', Auth::id())
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rencana tanam tidak ditemukan atau tidak aktif.'
            ], 404);
        }

        $tasks = $taskService->generateDailyTasks($plan);
        return response()->json($tasks);
    }
}