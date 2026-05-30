<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\RencanaAnggaran;
use App\Models\LogKeuangan;
use App\Models\MasterPeriode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RencanaController extends Controller
{
    public function index()
    {
        return redirect()->to('/dashboard');
    }

    public function storeBudget(Request $request)
    {
        try {
            $user = Auth::user();
            $lahan = Lahan::where('user_id', $user->id)->first();

            if (!$lahan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lahan tidak ditemukan. Silakan daftarkan lahan terlebih dahulu.'
                ], 404);
            }

            $lahanId = $lahan->id;

            // Cari periode aktif, jika tidak ada, buat default atau skip log keuangan
            $periodeActive = MasterPeriode::where('lahan_id', $lahanId)
                ->where('status', 'Aktif')
                ->first();

            $periodeId = $periodeActive->id ?? null;

            // Hitung target output (7 ton per hektar)
            $luasHektar = $lahan->land_area ?? 1.0;
            $targetKg = round($luasHektar * 7 * 1000);
            if ($targetKg <= 0) $targetKg = 6000;

            // Simpan atau update anggaran
            $anggaran = RencanaAnggaran::updateOrCreate(
                ['lahan_id' => $lahanId],
                [
                    'estimasi_benih'   => $request->estimasi_benih ?? 0,
                    'estimasi_pupuk'   => $request->estimasi_pupuk ?? 0,
                    'estimasi_traktor' => $request->estimasi_traktor ?? 0,
                    'estimasi_upah'    => $request->estimasi_upah ?? 0,
                    'target_output_gkp' => $targetKg
                ]
            );

            $totalBudget = $anggaran->estimasi_benih 
                         + $anggaran->estimasi_pupuk 
                         + $anggaran->estimasi_traktor 
                         + $anggaran->estimasi_upah;

            // Simpan ke log keuangan hanya jika periodeId ada dan totalBudget > 0
            if ($periodeId && $totalBudget > 0) {
                LogKeuangan::updateOrCreate(
                    [
                        'periode_id' => $periodeId,
                        'keterangan' => 'Alokasi Pagu Anggaran Rencana Tanam (Awal)'
                    ],
                    [
                        'kategori_biaya' => 'pengeluaran',
                        'nominal'        => $totalBudget,
                        'tanggal_input'  => now()->toDateString()
                    ]
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pagu anggaran rencana Tera Tani berhasil dikunci!',
                'total_budget' => $totalBudget
            ]);

        } catch (\Exception $e) {
            Log::error('Error storeBudget: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}