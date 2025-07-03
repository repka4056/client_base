<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adaugă Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">➕ Adaugă un Client Nou</h5>
                </div>
                <div class="card-body">

                    {{-- Afișare erori --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('clients.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nume" class="form-label">Nume</label>
                            <input type="text" class="form-control" id="nume" name="nume" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenume" class="form-label">Prenume</label>
                            <input type="text" class="form-control" id="prenume" name="prenume" required>
                        </div>

                        <div class="mb-3">
                            <label for="adresa" class="form-label">Adresă</label>
                            <input type="text" class="form-control" id="adresa" name="adresa" required>
                        </div>

                        <div class="mb-3">
                            <label for="regiune" class="form-label">Regiune</label>
                            <input type="text" class="form-control" id="regiune" name="regiune" required>
                        </div>

                        <div class="mb-3">
                            <label for="numar_casa" class="form-label">Număr casă</label>
                            <input type="text" class="form-control" id="numar_casa" name="numar_casa" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">💾 Salvează Client</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('clients.index') }}" class="btn btn-link">← Înapoi la listă</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
