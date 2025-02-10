@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary"><i class="fas fa-layer-group"></i> Créer une classe</h1>

        <!-- Formulaire de création de classe -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white rounded-top">
                <h5 class="mb-0"><i class="fas fa-plus"></i> Ajouter une nouvelle classe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf

                    <!-- Nom de la classe -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de la classe</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description de la classe -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('classes.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Créer la classe</button>
                    </div>
                </form>
            </div>
            <!-- Bouton pour voir les classes existantes -->
<div class="text-center mt-3">
    <a href="{{ route('classes.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-list"></i> Voir les classes existantes
    </a>
</div>
<!-- Bouton Retour à la liste des étudiants -->
<div class="text-center mt-4">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste des étudiants
            </a>
        </div>
    </div>
        </div>
    </div>
@endsection
