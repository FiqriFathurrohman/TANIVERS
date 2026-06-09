<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanController extends Controller
{
    public function create()
    {
        $commodities = Commodity::where('is_active', true)
            ->orderBy('name')
            ->get();

        $lahans = Lahan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('createlahan', compact('commodities', 'lahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'commodity_id' => 'required|exists:commodities,id',
            'komoditas' => 'required|string|max:255',
            'koordinat_lahan' => 'required|string',
            'luas_meter_persegi' => 'required|numeric|min:1',
            'weather_latitude' => 'required|numeric',
            'weather_longitude' => 'required|numeric',
        ]);

        Lahan::create([
            'user_id' => Auth::id(),
            'commodity_id' => $request->commodity_id,
            'nama_lahan' => $request->nama_lahan,
            'komoditas' => $request->komoditas,
            'koordinat_lahan' => json_decode($request->koordinat_lahan, true),
            'luas_meter_persegi' => $request->luas_meter_persegi,
            'weather_latitude' => $request->weather_latitude,
            'weather_longitude' => $request->weather_longitude,
        ]);

        return redirect()
            ->route('lahan.create')
            ->with('success', 'Data lahan berhasil disimpan.');
    }
}