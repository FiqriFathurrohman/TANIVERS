<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\SoilType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanController extends Controller
{
    public function create()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $soilTypes = SoilType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $lahans = Lahan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('createlahan', compact('soilTypes', 'lahans'));
    }

    public function store(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'soil_type_id' => 'required|exists:soil_types,id',
            'jenis_tanah' => 'required|string|max:255',
            'koordinat_lahan' => 'required|json',
            'luas_meter_persegi' => 'required|numeric|min:1',
            'weather_latitude' => 'required|numeric',
            'weather_longitude' => 'required|numeric',
        ]);

        $lahan = Lahan::create([
            'user_id' => Auth::id(),
            'soil_type_id' => $validated['soil_type_id'],
            'nama_lahan' => $validated['nama_lahan'],
            'jenis_tanah' => $validated['jenis_tanah'],
            'koordinat_lahan' => json_decode($validated['koordinat_lahan'], true),
            'luas_meter_persegi' => $validated['luas_meter_persegi'],
            'weather_latitude' => $validated['weather_latitude'],
            'weather_longitude' => $validated['weather_longitude'],
        ]);

        return redirect()
            ->route('pre-production.create', ['lahan_id' => $lahan->id])
            ->with('success', 'Data lahan berhasil disimpan. Silakan lanjutkan ke tahap Pra Production & Perancangan.');
    }
}