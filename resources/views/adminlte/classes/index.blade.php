@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary"><i class="fas fa-layer-group"></i> Liste des Classes</h1>

        <!-- Afficher les messages de succès ou d'erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach ($classes as $class)
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-body text-center">
                            <!-- Icône et Nom de la Classe -->
                            <div class="mb-3">
                                <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title text-uppercase font-weight-bold">{{ $class->name }}</h5>
                            
                            <!-- Description de la Classe (si elle existe) -->
                            <p class="card-text text-muted">
                                {{ $class->description ?? 'Aucune description disponible pour cette classe.' }}
                            </p>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>

                            <!-- Bouton pour Voir les Étudiants dans la classe -->
                            <div class="mt-3">
                                <a href="{{ route('classes.show', $class->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-users"></i> Voir les étudiants
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bouton Ajouter une classe -->
        <div class="text-center mt-4">
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter une nouvelle classe
            </a>
        </div>

        <!-- Bouton Retour à la liste des étudiants -->
        <div class="text-center mt-4">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste des étudiants
            </a>
        </div>
    </div>
@endsection
