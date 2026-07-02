<?php

namespace App\Http\Controllers;

use App\Models\HarvestReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 1. Ambil data lahan buat dropdown satelit di UI lu
        $lahans = \App\Models\Lahan::where('user_id', Auth::id())->get();

        // 2. Ambil data untuk Grafik Hukum Alam (10 Panen Terakhir)
        $harvests = \App\Models\HarvestReport::with(['preProductionPlan.lahan', 'preProductionPlan.commodity'])
            ->where('user_id', Auth::id())
            ->orderBy('harvest_date', 'asc') // Wajib asc biar runutan waktunya logis dari lama ke baru
            ->take(10)
            ->get();

        $labels = [];
        $actualYield = [];
        $expectedEfficiency = [];

        // Array pelacak (tracker) independen per lahan
        $trackerLahan = [];

        foreach ($harvests as $harvest) {
            $plan = $harvest->preProductionPlan;
            $commodity = $plan->commodity;
            $lahanId = $plan->lahan_id;

            $commodityName = $commodity->name ?? 'Unknown';
            $lahanName = $plan->lahan->nama_lahan ?? 'Lahan';

            // 1. Cek apakah lahan ini belum pernah ditanam sebelumnya dalam loop ini
            if (!isset($trackerLahan[$lahanId])) {
                // Lahan baru terdeteksi, set hitungan rotasi jadi 1
                $trackerLahan[$lahanId] = [
                    'consecutive_count' => 1,
                    'last_commodity' => $commodity->id
                ];
            } else {
                // 2. Lahan sudah ada riwayat. Cek komoditasnya!
                if ($trackerLahan[$lahanId]['last_commodity'] === $commodity->id) {
                    // Petani ngeyel nanam komoditas yang sama (tidak ada rotasi), tambah hitungan beruntun!
                    $trackerLahan[$lahanId]['consecutive_count']++;
                } else {
                    // Petani pintar melakukan rotasi tanaman (komoditas beda), reset hitungan kesuburan ke 1!
                    $trackerLahan[$lahanId]['consecutive_count'] = 1;
                    $trackerLahan[$lahanId]['last_commodity'] = $commodity->id;
                }
            }

            // Ambil hitungan beruntun untuk lahan spesifik ini
            $currentConsecutive = $trackerLahan[$lahanId]['consecutive_count'];

            // Hitung Drop Rate berdasarkan jenis tanaman (rentan atau tidak)
            $isVulnerable = in_array(strtolower($commodityName), ['cabai', 'tomat', 'terong', 'kentang', 'bawang']);
            $dropRate = $isVulnerable ? 35 : 15;

            // Kalkulasi kesuburan (Maksimal 100%, Minimal 10%)
            $efficiency = max(10, 100 - (($currentConsecutive - 1) * $dropRate));

            // 3. Masukkan data ke array untuk dikirim ke JS Chart
            $labels[] = $commodityName . ' (' . $lahanName . ')';
            $actualYield[] = $harvest->quantity;
            $expectedEfficiency[] = $efficiency;
        }

        // Return ke view dashboard
        return view('dashboard', compact('lahans', 'labels', 'actualYield', 'expectedEfficiency'));
    }
}