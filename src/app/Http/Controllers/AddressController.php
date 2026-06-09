<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::latest()->get();

        return view('alamat.index', compact('addresses'));
    }

    public function create()
    {
        return view('alamat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',

            'province_id' => 'required|string',
            'province_name' => 'required|string',

            'city_id' => 'required|string',
            'city_name' => 'required|string',

            'district_id' => 'required|string',
            'district_name' => 'required|string',

            'alamat_lengkap' => 'nullable|string',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'province_id.required' => 'Provinsi wajib dipilih.',
            'city_id.required' => 'Kota/Kabupaten wajib dipilih.',
            'district_id.required' => 'Kecamatan wajib dipilih.',
        ]);

        Address::create([
            'nama' => $request->nama,

            'province_id' => $request->province_id,
            'province_name' => $request->province_name,

            'city_id' => $request->city_id,
            'city_name' => $request->city_name,

            'district_id' => $request->district_id,
            'district_name' => $request->district_name,

            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return redirect()
            ->route('alamat.index')
            ->with('success', 'Data alamat berhasil disimpan.');
    }
}