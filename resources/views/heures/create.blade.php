@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Ajouter un Nombre d'Heures pour un Professeur</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('heures.store', ['professeur' => $professeur->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="professeur" class="form-label">Professeur</label>
            <select name="professeur" class="form-control" id="professeur" required>
                @foreach ($professeurs as $prof)
                    <option value="{{ $prof->id }}">{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="matiere" class="form-label">Matière</label>
            <select name="matiere" class="form-control" id="matiere" required>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nombre_heures" class="form-label">Nombre d'Heures</label>
            <input type="number" name="nombre_heures" class="form-control" id="nombre_heures" required>
        </div>
        <div class="mb-3">
            <label for="heure" class="form-label">Heure</label>
            <input type="time" name="heure" class="form-control" id="heure" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" id="date" required>
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de Début</label>
            <input type="date" name="date_debut" class="form-control" id="date_debut" required>
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de Fin</label>
            <input type="date" name="date_fin" class="form-control" id="date_fin" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection
