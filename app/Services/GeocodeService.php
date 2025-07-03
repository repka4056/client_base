<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodeService
{
    public static function getCoordinates($adresaCompletă)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'LaravelClientMap'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $adresaCompletă,
            'format' => 'json',
            'limit' => 1
        ]);

        if ($response->successful() && count($response->json()) > 0) {
            $data = $response->json()[0];
            return [
                'lat' => $data['lat'],
                'lon' => $data['lon'],
            ];
        }

        return null;
    }
}
