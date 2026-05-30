<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogKeuangan;
use App\Models\PhotoLog;
use App\Models\SopTemplate;
use App\Models\LahanSopActivity;
use App\Models\Lahan;
use App\Models\RencanaAnggaran; 
use App\Models\MasterPeriode;   
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SOPController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data lahan riil milik petani yang login (bisa null)
        $lahan = Lahan::where('user_id', $user->id)->first();
        
        // 🛑 JANGAN REDIRECT! Biarkan dashboard tetap tampil meskipun belum punya lahan.
        // Nanti di view dashboard, jika $lahan null, akan tampil pesan untuk daftar lahan.
        
        $currentHst = 1;
        $jenisPadi = 'Belum ada lahan';
        $varietas = '-';
        $tasksHariIni = collect();
        $checkedTasks = [];
        $logKeuangan = collect();
        $photoLogs = collect();
        $anggaranAktif = null;

        if ($lahan) {
            // Hitung HST dinamis
            $hstAwal = (int) ($lahan->hst ?? 1);
            $tanggalDaftar = Carbon::parse($lahan->created_at ?? now());
            $hariIni = Carbon::now();
            $hariBerjalan = (int) $tanggalDaftar->diffInDays($hariIni, false);
            if ($hariBerjalan < 0) $hariBerjalan = 0;
            $currentHst = $hstAwal + $hariBerjalan;
            if ($currentHst > 150) $currentHst = 150;
            $lahan->update(['hst' => $currentHst]);

            $jenisPadi = $lahan->sawah_type ?? 'Sawah Irigasi';
            $varietas = $lahan->commodity ?? 'Inpara';

            $kataKunciVarietas = explode(' ', trim($varietas))[0];
            $tasksHariIni = SopTemplate::where('variety', 'ILIKE', '%' . $kataKunciVarietas . '%')
                ->where('hst', $currentHst)
                ->get();

            if ($tasksHariIni->isEmpty()) {
                $tasksHariIni = collect([
                    (object)[
                        'id' => 991 + $currentHst,
                        'task_title' => "Pemeliharaan Rutin Varietas " . $varietas,
                        'task_description' => "Pantau genangan air, lakukan monitoring drainase, cek kesehatan daun pada umur " . $currentHst . " HST.",
                        'phase' => "Vegetatif"
                    ]
                ]);
            }

            $checkedTasks = LahanSopActivity::where('lahan_id', $lahan->id)
                ->where('current_hst', $currentHst)
                ->where('is_completed', true)
                ->pluck('sop_template_id')->toArray();

            $lahanId = $lahan->id;
            $periodeActive = MasterPeriode::where('lahan_id', $lahanId)->where('status', 'Aktif')->first();
            $periodeId = $periodeActive->id ?? 1;

            $logKeuangan = LogKeuangan::where('periode_id', $periodeId)->orderBy('tanggal_input', 'desc')->get();
            $anggaranAktif = RencanaAnggaran::where('lahan_id', $lahanId)->first();
            $photoLogs = PhotoLog::where('lahan_id', $lahan->id)->orderBy('created_at', 'desc')->get();
        }

        return view('dashboard', compact(
            'lahan', 
            'currentHst', 
            'jenisPadi', 
            'varietas', 
            'tasksHariIni', 
            'checkedTasks', 
            'logKeuangan', 
            'photoLogs',
            'anggaranAktif' 
        ));
    }
    
    public function storeKeuangan(Request $request)
    {
        $user = Auth::user();
        $lahan = Lahan::where('user_id', $user->id)->first();
        
        if (!$lahan) {
            return response()->json(['status' => 'error', 'message' => 'Belum ada lahan terdaftar'], 400);
        }
    
        $lahanId = $lahan->id;
        $periodeActive = MasterPeriode::where('lahan_id', $lahanId)->where('status', 'Aktif')->first();
        $periodeId = $periodeActive->id ?? 1;
    
        $nominal = $request->nominal;
        if ($request->kategori_biaya === 'Buruh') {
            $nominal = $request->jumlah_buruh * $request->upah_per_orang; 
        }
    
        $log = LogKeuangan::create([
            'periode_id'     => $periodeId, 
            'kategori_biaya' => $request->kategori_biaya, 
            'nominal'        => (int) ($nominal ?? 0), 
            'jumlah_buruh'   => $request->jumlah_buruh ?? 0, 
            'upah_per_orang' => $request->upah_per_orang ?? 0, 
            'keterangan'     => $request->keterangan, 
            'tanggal_input'  => Carbon::now() 
        ]);
    
        return response()->json([
            'status'     => 'success', 
            'nominal'    => $log->nominal, 
            'kategori'   => $log->kategori_biaya, 
            'keterangan' => $log->keterangan ?? 'Tanpa keterangan' 
        ]);
    }
}