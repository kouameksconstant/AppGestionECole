@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <!-- Affichage du message de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès !</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Titre de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary"><i class="fas fa-user-edit"></i> Modifier l'étudiant</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <!-- Formulaire de modification d'un étudiant -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Modifiez les informations de l'étudiant</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Méthode PUT pour la mise à jour -->

                <!-- Nom -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" placeholder="Entrez le nom de l'étudiant">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prénom -->
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $student->prenom) }}" placeholder="Entrez le prénom de l'étudiant">
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" placeholder="Entrez l'email de l'étudiant">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Téléphone personnel -->
                <div class="mb-3">
                    <label for="tel_perso" class="form-label">Téléphone personnel</label>
                    <input type="tel" name="tel_perso" id="tel_perso" class="form-control @error('tel_perso') is-invalid @enderror" value="{{ old('tel_perso', $student->tel_perso) }}" placeholder="Entrez le téléphone personnel de l'étudiant">
                    @error('tel_perso')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de naissance -->
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Date de naissance</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $student->birth_date) }}">
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lieu de naissance -->
                <div class="mb-3">
                    <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror" value="{{ old('lieu_naissance', $student->lieu_naissance) }}" placeholder="Entrez le lieu de naissance de l'étudiant">
                    @error('lieu_naissance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
