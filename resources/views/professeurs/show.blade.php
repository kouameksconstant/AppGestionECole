@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Détails du Professeur</h2>
    <div class="card shadow-lg rounded">
        <div class="card-body">
            <h3 class="card-title text-center text-success mb-4">{{ $professeur->nom }} {{ $professeur->prenom }}</h3>
            
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <p class="card-text"><strong>Email : </strong>{{ $professeur->email }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="card-text"><strong>Téléphone : </strong>{{ $professeur->telephone }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <p class="card-text"><strong>Spécialité : </strong>{{ $professeur->specialite }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="card-text"><strong>Type de Contrat : </strong>{{ $professeur->type_contrat }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <p class="card-text"><strong>Date de Début : </strong>{{ $professeur->date_debut }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('professeurs.edit', $professeur->id) }}" class="btn btn-warning btn-lg w-48">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('professeurs.index') }}" class="btn btn-secondary btn-lg w-48">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
