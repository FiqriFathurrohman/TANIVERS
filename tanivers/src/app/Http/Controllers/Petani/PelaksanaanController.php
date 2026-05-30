<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogKeuangan;
use App\Models\PhotoLog;
use App\Models\SopTemplate;
use App\Models\LahanSopActivity;
use App\Models\Lahan;
use App\Models\MasterPeriode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PelaksanaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lahan = Lahan::where('user_id', $user->id)->first();

        if (!$lahan) {
            return redirect()->to('/dashboard')->with('error', 'Silakan daftarkan lahan terlebih dahulu.');
        }

        $jenisPadi = $lahan->sawah_type ?? 'Sawah Irigasi';
        $varietas = $lahan->commodity ?? 'Ciherang';

        // Hitung HST dinamis
        $hstAwal = (int)($lahan->hst ?? 1);
        $tanggalDaftar = Carbon::parse($lahan->created_at ?? now());
        $hariBerjalan = max(0, (int)$tanggalDaftar->diffInDays(now(), false));
        $currentHst = min($hstAwal + $hariBerjalan, 150);
        $lahan->update(['hst' => $currentHst]);

        $kataKunciVarietas = explode(' ', trim($varietas))[0];
        $tasksHariIni = SopTemplate::where('variety', 'ILIKE', '%' . $kataKunciVarietas . '%')
            ->where('hst', $currentHst)
            ->get();

        // 🔥 FALLBACK TASK: id = null (tidak valid), is_fallback = true
        if ($tasksHariIni->isEmpty()) {
            $fallbackTask = new \stdClass();
            $fallbackTask->id = null;
            $fallbackTask->is_fallback = true;
            $fallbackTask->phase = "Budidaya";
            $fallbackTask->task_title = "Pemeliharaan Rutin Varietas " . $varietas;
            $fallbackTask->task_description = "Pantau kondisi tanaman pada umur " . $currentHst . " HST.";
            $tasksHariIni = collect([$fallbackTask]);
        } else {
            foreach ($tasksHariIni as $task) {
                $task->is_fallback = false;
            }
        }

        $checkedTasks = LahanSopActivity::where('lahan_id', $lahan->id)
            ->where('current_hst', $currentHst)
            ->where('is_completed', true)
            ->pluck('sop_template_id')
            ->toArray();

        // Periode aktif (buat jika belum ada)
        $periode = MasterPeriode::where('lahan_id', $lahan->id)
            ->where('status', 'Aktif')
            ->first();
        if (!$periode) {
            $periode = MasterPeriode::create([
                'lahan_id' => $lahan->id,
                'nama_musim' => 'Musim Tanam ' . date('Y'),
                'tahun' => date('Y'),
                'status' => 'Aktif'
            ]);
        }
        $periodeId = $periode->id_periode;

        $logKeuangan = LogKeuangan::where('periode_id', $periodeId)
            ->orderBy('tanggal_input', 'desc')
            ->get();

        $photoLogs = PhotoLog::where('lahan_id', $lahan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPengeluaranReal = $logKeuangan->sum('nominal');
        $modalAwal = $lahan->biaya_regis ?? 0;
        $sisaAnggaran = $modalAwal - $totalPengeluaranReal;
        $hargaPerKg = 6500;
        $estimasiHasilPanenKg = 5500 * ($lahan->land_area ?? 1.2);
        $pendapatanKotor = $estimasiHasilPanenKg * $hargaPerKg;
        $labaRugiBersih = $pendapatanKotor - $totalPengeluaranReal;

        return view('pages.pelaksanaan', compact(
            'lahan', 'currentHst', 'jenisPadi', 'varietas', 'tasksHariIni', 'checkedTasks',
            'logKeuangan', 'photoLogs', 'modalAwal', 'totalPengeluaranReal', 'sisaAnggaran',
            'hargaPerKg', 'estimasiHasilPanenKg', 'pendapatanKotor', 'labaRugiBersih'
        ));
    }

    public function storeKeuangan(Request $request)
    {
        try {
            $user = Auth::user();
            $lahan = Lahan::where('user_id', $user->id)->first();
            if (!$lahan) {
                return response()->json(['status' => 'error', 'message' => 'Lahan tidak ditemukan'], 404);
            }

            $periode = MasterPeriode::where('lahan_id', $lahan->id)
                ->where('status', 'Aktif')
                ->first();
            if (!$periode) {
                $periode = MasterPeriode::create([
                    'lahan_id' => $lahan->id,
                    'nama_musim' => 'Musim Tanam ' . date('Y'),
                    'tahun' => date('Y'),
                    'status' => 'Aktif'
                ]);
            }
            $periodeId = $periode->id_periode;

            $validated = $request->validate([
                'kategori_biaya' => 'required|string',
                'nominal' => 'nullable|numeric',
                'jumlah_buruh' => 'nullable|integer',
                'upah_per_orang' => 'nullable|integer',
                'keterangan' => 'nullable|string',
            ]);

            $nominal = $validated['nominal'] ?? 0;
            if ($validated['kategori_biaya'] === 'Buruh') {
                $jumlah = $validated['jumlah_buruh'] ?? 0;
                $upah = $validated['upah_per_orang'] ?? 0;
                $nominal = $jumlah * $upah;
            }

            $log = LogKeuangan::create([
                'periode_id' => $periodeId,
                'kategori_biaya' => $validated['kategori_biaya'],
                'nominal' => $nominal,
                'jumlah_buruh' => $validated['jumlah_buruh'] ?? 0,
                'upah_per_orang' => $validated['upah_per_orang'] ?? 0,
                'keterangan' => $validated['keterangan'] ?? '',
                'tanggal_input' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'nominal' => $log->nominal,
                'kategori' => $log->kategori_biaya,
                'keterangan' => $log->keterangan,
            ]);
        } catch (\Exception $e) {
            Log::error('storeKeuangan error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function storePhoto(Request $request)
    {
        try {
            $request->validate([
                'foto_tanaman' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'keterangan_foto' => 'nullable|string',
            ]);

            $user = Auth::user();
            $lahan = Lahan::where('user_id', $user->id)->first();
            if (!$lahan) {
                return response()->json(['success' => false, 'message' => 'Lahan tidak ditemukan'], 404);
            }

            $hst = $lahan->hst ?? 0;
            $fase = 'Vegetatif';
            if ($hst > 45 && $hst <= 85) $fase = 'Generatif';
            if ($hst > 85) $fase = 'Pematangan (Panen)';

            if ($request->hasFile('foto_tanaman')) {
                $file = $request->file('foto_tanaman');
                $filename = 'log_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/photo_logs'), $filename);
                $path = 'uploads/photo_logs/' . $filename;

                PhotoLog::create([
                    'lahan_id' => $lahan->id,
                    'current_hst' => $hst,
                    'fase_tanaman' => $fase,
                    'file_path' => $path,
                    'keterangan' => $request->keterangan_foto,
                ]);

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleSop(Request $request)
    {
        try {
            $user = Auth::user();
            $lahan = Lahan::where('user_id', $user->id)->first();
            if (!$lahan) {
                return response()->json(['success' => false, 'message' => 'Lahan tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'sop_template_id' => 'required|integer|min:1|exists:sop_templates,id',
                'hst' => 'required|integer|min:0',
                'completed' => 'required|boolean',
            ]);

            LahanSopActivity::updateOrCreate(
                [
                    'lahan_id' => $lahan->id,
                    'sop_template_id' => $validated['sop_template_id'],
                    'current_hst' => $validated['hst'],
                ],
                [
                    'is_completed' => $validated['completed'],
                    'completed_at' => $validated['completed'] ? now() : null,
                ]
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('toggleSop error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}