<?php 
namespace App\Http\Controllers; 

use App\Models\PreProductionPlan; 
use App\Models\HarvestReport; 
use App\Models\ExecutionExpense; 
use App\Models\ExecutionPestReport; 
use App\Models\User; // <-- Tambahan import User Model
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 

class ProfileController extends Controller 
{ 
    public function index() 
    { 
        if (!Auth::check()) { 
            return redirect()->route('login'); 
        } 

        $user = Auth::user(); 

        // Tarik HANYA perancangan yang sudah selesai (is_active = false) 
        $historyPlans = PreProductionPlan::with(['lahan', 'commodity', 'commodityType']) 
            ->where('user_id', $user->id) 
            ->where('is_active', false) 
            ->orderBy('updated_at', 'desc') // Urutkan dari panen terbaru 
            ->get(); 

        // Kita injek/masukkan seluruh data riwayat ke masing-masing plan 
        foreach ($historyPlans as $plan) { 
            // 1. Ambil Data Panen 
            $plan->harvest = HarvestReport::where('pre_production_plan_id', $plan->id)->first(); 
            
            // 2. Ambil Semua Pengeluaran 
            $plan->expenses = ExecutionExpense::with('items') 
                ->where('pre_production_plan_id', $plan->id) 
                ->orderBy('day_number', 'asc') 
                ->get(); 
            $plan->total_expense = $plan->expenses->sum('total_amount'); 
            
            // 3. Ambil Semua Laporan Hama & Penyakit 
            $plan->pestReports = ExecutionPestReport::with(['pest', 'disease']) 
                ->where('pre_production_plan_id', $plan->id) 
                ->orderBy('day_number', 'asc') 
                ->get(); 
        } 

        return view('profile.index', compact('user', 'historyPlans')); 
    } 

    public function updatePhoto(Request $request) 
    { 
        // 1. Validasi Foto
        $request->validate([ 
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB 
        ]); 

        // 2. Ambil user dari database secara eksplisit (Bypass Mass Assignment)
        $user = User::find(Auth::id()); 

        if ($request->hasFile('photo')) { 
            // Kalau sebelumnya udah punya foto, hapus foto lamanya biar server nggak kepenuhan 
            if ($user->photo && Storage::disk('public')->exists($user->photo)) { 
                Storage::disk('public')->delete($user->photo); 
            } 

            // Simpan foto baru ke folder storage/app/public/profile_photos 
            $path = $request->file('photo')->store('profile_photos', 'public'); 

            // 3. Update nama file di database pakai properti langsung (Dijamin Tembus!)
            $user->photo = $path; 
            $user->save(); 
        } 

        return back()->with('success', 'Foto profil berhasil diperbarui!'); 
    } 
}