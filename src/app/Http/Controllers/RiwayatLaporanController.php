<?php

namespace App\Http\Controllers;

use App\Models\ExecutionExpense;
use App\Models\ExecutionPestReport;
use App\Models\ExecutionTaskCheck;
use App\Models\PreProductionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatLaporanController extends Controller
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

        $taskChecks = collect();
        $pestReports = collect();
        $expenseReports = collect();
        $expenseTotal = 0;

        if ($selectedPlan) {
            $taskChecks = ExecutionTaskCheck::with(['plantingGuideTask'])
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->orderByDesc('day_number')
                ->orderByDesc('created_at')
                ->get()
                ->groupBy('day_number');

            $pestReports = ExecutionPestReport::with(['pest', 'disease'])
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->latest()
                ->get();

            $expenseReports = ExecutionExpense::with(['items'])
                ->where('user_id', Auth::id())
                ->where('pre_production_plan_id', $selectedPlan->id)
                ->latest()
                ->get();

            $expenseTotal = $expenseReports->sum('total_amount');
        }

        return view('riwayat-laporan.index', compact(
            'plans',
            'selectedPlan',
            'taskChecks',
            'pestReports',
            'expenseReports',
            'expenseTotal'
        ));
    }
}