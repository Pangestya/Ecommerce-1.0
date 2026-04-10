<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    private string $baseUrl = 'https://rajaongkir.komerce.id/api/v1/destination';
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    private function request(string $endpoint)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'Accept' => 'application/json'
        ])->get($this->baseUrl . $endpoint);

        if ($response->failed()) {
            return response()->json([
                'error' => true,
                'status' => $response->status(),
                'raw' => $response->body()
            ], 500);
        }

        return response()->json($response->json()['data'] ?? []);
    }

    // ================= PROVINCE =================
    public function getProvinces()
    {
        return $this->request('/province');
    }

    // ================= CITY =================
    public function getCities($provinceId)
    {
        return $this->request("/city/$provinceId");
    }

    // ================= DISTRICT =================
    public function getDistricts($cityId)
    {
        return $this->request("/district/$cityId");
    }

    public function getVillages($districtId)
    {
        return $this->request("/sub-district/$districtId");
    }


}
