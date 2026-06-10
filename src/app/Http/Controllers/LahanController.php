<?php

namespace App\Http\Controllers;

use App\Models\SoilType;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanController extends Controller
{
    public function create()
    {
        // Ambil data Jenis Tanah (SoilType) yang aktif dari Admin
        $soilTypes = SoilType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $lahans = Lahan::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Passing variabel ke view
        return view('createlahan', compact('soilTypes', 'lahans'));
    }

    public function store(Request $request)
    {
        // Validasi disesuaikan menjadi jenis_tanah
        $request->validate([
            'nama_lahan'         => 'required|string|max:255',
            'soil_type_id'       => 'required|exists:soil_types,id',
            'jenis_tanah'        => 'required|string|max:255',
            'koordinat_lahan'    => 'required|string',
            'luas_meter_persegi' => 'required|numeric|min:1',
            'weather_latitude'   => 'required|numeric',
            'weather_longitude'  => 'required|numeric',
        ]);

        // Simpan data
        Lahan::create([
            'user_id'            => Auth::id(),
            'nama_lahan'         => $request->nama_lahan,
            'soil_type_id'       => $request->soil_type_id,
            'jenis_tanah'        => $request->jenis_tanah,
            'koordinat_lahan'    => json_decode($request->koordinat_lahan, true),
            'luas_meter_persegi' => $request->luas_meter_persegi,
            'weather_latitude'   => $request->weather_latitude,
            'weather_longitude'  => $request->weather_longitude,
        ]);

        return redirect()
            ->route('lahan.create')
            ->with('success', 'Data lahan berhasil disimpan.');
    }
}