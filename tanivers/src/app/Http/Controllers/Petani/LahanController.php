<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LahanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            // Cek apakah user sudah memiliki lahan (batasi hanya satu lahan)
            $existingLahan = Lahan::where('user_id', $user->id)->exists();
            if ($existingLahan) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Anda sudah memiliki lahan terdaftar. Selesaikan panen terlebih dahulu.'
                ], 400);
            }

            // Validasi input
            $validated = $request->validate([
                'nama_lahan'    => 'required|string|max:255',
                'land_area'     => 'required|numeric|min:0.1',
                'commodity'     => 'required|string',
                'tanggal_tanam' => 'required|date',
                'method'        => 'required|string',
                'sawah_type'    => 'required|string|in:irigasi_teknis,padi_genjah,spesifik_lahan,padi_hibrida',
                'gps_coords'    => 'nullable|string',
                'alamat_rumah'  => 'nullable|string',   // tidak disimpan ke lahan
                'biaya'         => 'nullable|numeric',  // akan dipetakan ke biaya_regis
            ]);

            // Hitung HST awal
            $tanggalTanam = Carbon::parse($request->tanggal_tanam);
            $hstFinal = max(0, Carbon::now()->diffInDays($tanggalTanam, false));

            // Simpan lahan
            $lahan = Lahan::create([
                'user_id'       => $user->id,
                'nama_lahan'    => $request->nama_lahan,
                'gps_coords'    => $request->gps_coords ?? '',
                'sawah_type'    => $request->sawah_type,
                'land_area'     => $request->land_area,
                'commodity'     => $request->commodity,
                'tanggal_tanam' => $request->tanggal_tanam,
                'method'        => $request->method,
                'hst'           => $hstFinal,
                'biaya_regis'   => $request->biaya ?? 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => "Lahan {$lahan->nama_lahan} berhasil didaftarkan! Kalender SOP telah digenerate.",
                'hst'     => $hstFinal,
                'data'    => $lahan
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Pendaftaran lahan error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getActiveLahan()
    {
        try {
            $lahan = Lahan::where('user_id', Auth::id())->first();
            return response()->json($lahan);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }
}