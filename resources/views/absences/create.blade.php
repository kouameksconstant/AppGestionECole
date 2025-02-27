@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Déclarer une Absence</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('absences.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="professeur_id" class="form-label">Professeur :</label>
                    <select name="professeur_id" id="professeur_id" class="form-select" required>
                        <option value="">-- Choisissez un professeur --</option>
                        @foreach($professeurs as $professeur)
                            <option value="{{ $professeur->id }}">{{ $professeur->nom }} {{ $professeur->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date_absence" class="form-label">Date d'absence :</label>
                    <input type="date" name="date_absence" id="date_absence" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="duree" class="form-label">Durée (en heures) :</label>
                    <input type="number" name="duree" id="duree" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="motif" class="form-label">Motif :</label>
                    <textarea name="motif" id="motif" class="form-control"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Déclarer l'absence</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
