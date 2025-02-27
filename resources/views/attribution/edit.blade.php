{{-- resources/views/attribution/edit.blade.php --}}
@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
    <!-- Bouton Retour -->
    <div class="mb-3">
        <a href="{{ route('matieres.assign') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>
    </div>
    
    <h2 class="text-center text-primary fw-bold mb-4">Modifier l'assignation</h2>
    
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Modifier l'assignation</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('matieres.assign.update') }}" method="POST">
                @csrf
                @method('PUT')
                {{-- Vous pouvez également transmettre l'ID de l'assignation via un champ caché --}}
                <input type="hidden" name="id" value="{{ $id }}">
                
                <div class="mb-3">
                    <label for="nb_heures" class="form-label">Nombre d'heures</label>
                    <input type="number" name="nb_heures" id="nb_heures" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
