<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityType;
use App\Models\Lahan;
use App\Models\PlantingGuide;
use App\Models\PreProductionPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreProductionController extends Controller
{
    public function create(Request $request)
    {
        if (! Auth::check()) {
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
        if (! Auth::check()) {
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

        if (! $plantingGuide) {
            return back()
                ->withInput()
                ->withErrors([
                    'commodity_type_id' => 'Panduan masa tanam untuk jenis komoditas ini belum dibuat di admin.',
                ]);
        }

        $durationDays = (int) $plantingGuide->duration_days;

        $currentDay = $validated['planting_status'] === 'new'
            ? 1
            : (int) ($validated['current_day'] ?? 1);

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
            'is_active' => true,
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

        if (! $guide) {
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
}