<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogKeuangan;
use App\Models\LogPanen;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // 🎯 Contoh simulasi ID Periode aktif milik Alfin (sesuaikan dengan session/auth sawah lu)
        $periodeId = 1; 
        $targetPanen = 6000; // Target default Tera Tani (6.000 KG)

        // 1. Hitung akumulasi modal pengeluaran dari awal tanam
        $totalModal = LogKeuangan::where('periode_id', $periodeId)
            ->where('kategori_biaya', 'pengeluaran')
            ->sum('nominal');

        // 2. Tarik data Yield Log & Sales Ledger akhir panen jika sudah di-input
        $panen = LogPanen::where('periode_id', $periodeId)->first();
        
        $beratPanen = $panen ? $panen->berat_panen : 0;
        $hargaPerKg = $panen ? $panen->harga_per_kg : 0;
        $totalPendapatan = $panen ? $panen->total_pendapatan : 0;

        // 3. Hitung Financial Insights Otomatis [Laba/Rugi, Modal/KG, & Efisiensi]
        $labaRugiBersih = $totalPendapatan - $totalModal;
        $modalPerKg = $beratPanen > 0 ? ($totalModal / $beratPanen) : 0;
        $efficiencyScore = $beratPanen > 0 ? min(round(($beratPanen / $targetPanen) * 100), 100) : 0;

        // 4. Tarik mutasi riwayat ringkasan keuangan untuk ditaruh di tabel kanan
        $riwayatKeuangan = LogKeuangan::where('periode_id', $periodeId)
            ->orderBy('tanggal_input', 'desc')
            ->get();

        return view('pages.laporan', compact(
            'totalModal', 'beratPanen', 'hargaPerKg', 'totalPendapatan',
            'labaRugiBersih', 'modalPerKg', 'efficiencyScore', 'targetPanen', 'riwayatKeuangan'
        ));
    }

    // 🎯 SIMPAN INPUT YIELD LOG & SALES LEDGER DARI FORM
    public function storePanen(Request $request)
    {
        $periodeId = 1; 
        
        $berat = $request->input('berat_panen', 0);
        $harga = $request->input('harga_per_kg', 0);
        $total = $berat * $harga;

        LogPanen::updateOrCreate(
            ['periode_id' => $periodeId],
            [
                'berat_panen' => $berat,
                'harga_per_kg' => $harga,
                'total_pendapatan' => $total
            ]
        );

        return redirect()->back()->with('success', 'Data panen berhasil disinkronisasi!');
    }

    // 🎯 SIMPAN MUTASI KEUANGAN BARU
    public function storeTransaksi(Request $request)
    {
        LogKeuangan::create([
            'periode_id' => 1,
            'kategori_biaya' => $request->fin_tipe,
            'keterangan' => $request->fin_nama,
            'nominal' => $request->fin_jumlah,
            'tanggal_input' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }
}