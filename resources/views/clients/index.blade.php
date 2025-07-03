<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Clienți pe Hartă</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <style>
        #harta {
            height: 500px;
            width: 100%;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">🗺️ Clienți pe Hartă</h1>
        <div>
            <a href="{{ route('clients.create') }}" class="btn btn-primary me-2">➕ Adaugă client</a>
            <a href="{{ route('clients.export') }}" class="btn btn-outline-secondary">📥 Exportă CSV</a>
        </div>
    </div>
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="cauta" class="form-control" placeholder="Caută după nume, prenume sau regiune" value="{{ request('cauta') }}">
        <button type="submit" class="btn btn-outline-secondary">🔍 Caută</button>
    </div>
</form>
    <div id="harta" class="rounded border"></div>

    <h2 class="h5 mt-4">📋 Lista clienților</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nume</th>
                    <th>Prenume</th>
                    <th>Adresă</th>
                    <th>Regiune</th>
                    <th>Număr casă</th>
                    <th>Latitudine</th>
                    <th>Longitudine</th>
                    <th>Hartă</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->nume }}</td>
                        <td>{{ $client->prenume }}</td>
                        <td>{{ $client->adresa }}</td>
                        <td>{{ $client->regiune }}</td>
                        <td>{{ $client->numar_casa }}</td>
                        <td>{{ $client->latitudine }}</td>
                        <td>{{ $client->longitudine }}</td>
                        <td>
                            @if($client->latitudine && $client->longitudine)
                                <button class="btn btn-sm btn-outline-primary"
                                        onclick="centerOnClient({{ $client->latitudine }}, {{ $client->longitudine }}, '{{ $client->nume }} {{ $client->prenume }}')">
                                    🧭 Vezi pe hartă
                                </button>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">✏️</a>

    <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Ești sigur?')">🗑️</button>
    </form>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    let map;
    let popupActiv = null;

    document.addEventListener("DOMContentLoaded", function () {
        map = L.map('harta').setView([47.0, 28.8], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        @foreach($clients as $client)
            @if ($client->latitudine && $client->longitudine)
                L.marker([{{ $client->latitudine }}, {{ $client->longitudine }}])
                    .addTo(map)
                    .bindPopup(`<strong>{{ $client->nume }} {{ $client->prenume }}</strong><br>{{ $client->adresa }} nr. {{ $client->numar_casa }}, {{ $client->regiune }}`);
            @endif
        @endforeach
    });

    function centerOnClient(lat, lon, label) {
        map.setView([lat, lon], 15);
        if (popupActiv) {
            popupActiv.remove();
        }
        popupActiv = L.popup()
            .setLatLng([lat, lon])
            .setContent(`<strong>${label}</strong>`)
            .openOn(map);
    }
</script>

</body>
</html>
