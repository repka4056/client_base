<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\GeocodeService;

class ClientController extends Controller
{
    public function index(Request $request)
{
    $query = Client::query();

    if ($request->filled('cauta')) {
        $query->where(function($q) use ($request) {
            $q->where('nume', 'like', "%{$request->cauta}%")
              ->orWhere('prenume', 'like', "%{$request->cauta}%")
              ->orWhere('regiune', 'like', "%{$request->cauta}%");
        });
    }

    $clients = $query->get();

    return view('clients.index', compact('clients'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nume' => 'required|string|max:100',
            'prenume' => 'required|string|max:100',
            'adresa' => 'required|string',
            'regiune' => 'required|string',
            'numar_casa' => 'required|string'
        ]);

        $client = new Client($request->all());

        $adresaCompletă = "{$client->adresa} {$client->numar_casa}, {$client->regiune}";
        $coords = GeocodeService::getCoordinates($adresaCompletă);

        if ($coords) {
            $client->latitudine = $coords['lat'];
            $client->longitudine = $coords['lon'];
        }

        $client->save();

        return redirect()->route('clients.index');
    }

    public function export()
    {
        $clients = Client::all();
        $csv = "Nume,Prenume,Adresă,Regiune,Număr Casă,Latitudine,Longitudine\n";

        foreach ($clients as $c) {
            $csv .= "{$c->nume},{$c->prenume},{$c->adresa},{$c->regiune},{$c->numar_casa},{$c->latitudine},{$c->longitudine}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=\"clienti.csv\"');
    }
    public function edit(Client $client)
{
    return view('clients.edit', compact('client'));
}

public function update(Request $request, Client $client)
{
    $request->validate([
        'nume' => 'required',
        'prenume' => 'required',
        'adresa' => 'required',
        'regiune' => 'required',
        'numar_casa' => 'required'
    ]);

    $client->update($request->all());

    // poți recalcula coordonatele aici, dacă vrei
    return redirect()->route('clients.index')->with('success', 'Client actualizat!');
}

public function destroy(Client $client)
{
    $client->delete();
    return redirect()->route('clients.index')->with('success', 'Client șters!');
}
}
