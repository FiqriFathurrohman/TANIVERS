<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    private string $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    public function provinces()
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . '/provinces.json');

            if ($response->failed()) {
                return response()->json([
                    'message' => 'Gagal mengambil data provinsi.'
                ], 500);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server gagal mengambil data provinsi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cities($provinceId)
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . "/regencies/{$provinceId}.json");

            if ($response->failed()) {
                return response()->json([
                    'message' => 'Gagal mengambil data kota/kabupaten.'
                ], 500);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server gagal mengambil data kota/kabupaten.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function districts($cityId)
    {
        try {
            $response = Http::timeout(15)->get($this->baseUrl . "/districts/{$cityId}.json");

            if ($response->failed()) {
                return response()->json([
                    'message' => 'Gagal mengambil data kecamatan.'
                ], 500);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server gagal mengambil data kecamatan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}