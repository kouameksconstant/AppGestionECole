@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Modifier un Professeur</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('professeurs.update', $professeur->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" value="{{ $professeur->nom }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" value="{{ $professeur->prenom }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $professeur->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" id="telephone" value="{{ $professeur->telephone }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" name="specialite" class="form-control" id="specialite" value="{{ $professeur->specialite }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type_contrat" class="form-label">Type de Contrat</label>
                        <input type="text" name="type_contrat" class="form-control" id="type_contrat" value="{{ $professeur->type_contrat }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date de Début</label>
                    <input type="date" name="date_debut" class="form-control" id="date_debut" value="{{ $professeur->date_debut }}" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-save"></i> Mettre à Jour
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
