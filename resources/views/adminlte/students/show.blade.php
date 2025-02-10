@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <!-- Titre de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary"><i class="fas fa-user"></i> Détails de l'étudiant</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <!-- Carte avec les détails de l'étudiant -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0"><i class="fas fa-id-card"></i> Informations de l'étudiant</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Nom :</strong> {{ $student->name }}
            </div>
            <div class="mb-3">
                <strong>Prénom :</strong> {{ $student->prenom }}
            </div>
            <div class="mb-3">
                <strong>Email :</strong> {{ $student->email }}
            </div>
            <div class="mb-3">
                <strong>Téléphone personnel :</strong> {{ $student->tel_perso }}
            </div>
            <div class="mb-3">
                <strong>Date de naissance :</strong> {{ $student->birth_date }}
            </div>
            <div class="mb-3">
                <strong>Lieu de naissance :</strong> {{ $student->lieu_naissance }}
            </div>
        </div>
    </div>
</div>
@endsection
