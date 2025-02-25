@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Ajouter un Professeur</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
            <form action="{{ route('professeurs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" id="telephone" value="{{ old('telephone') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" name="specialite" class="form-control" id="specialite" value="{{ old('specialite') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type_contrat" class="form-label">Type de Contrat</label>
                        <input type="text" name="type_contrat" class="form-control" id="type_contrat" value="{{ old('type_contrat') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date de Début</label>
                    <input type="date" name="date_debut" class="form-control" id="date_debut" value="{{ old('date_debut') }}" required>
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-plus-circle"></i> Ajouter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
