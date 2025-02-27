@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
    <!-- Titre principal -->
    <div class="mb-4">
        <div class="card border-primary shadow-sm">
            <div class="card-body text-center">
                <h2 class="card-title text-primary fw-bold">
                    <i class="fas fa-book"></i> Cahier de Texte
                </h2>
                <h4 class="card-subtitle text-secondary">
                    Professeur : <span class="fw-bold">{{ $professeur->nom ?? 'Inconnu' }} {{ $professeur->prenom ?? '' }}</span>
                </h4>
            </div>
        </div>
    </div>

    <!-- Alertes -->
    @if(session('error'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filtre par classe -->
    <div class="mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                Filtrer par classe
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('cahier.filtrer') }}">
                    <div class="form-row align-items-end">
                        <div class="col-md-6 mb-3">
                            <label for="classe">Sélectionner la classe :</label>
                            <select name="classe_id" id="classe" class="form-control">
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="professeur_id" value="{{ $professeur->id }}">
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Appliquer le filtre
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        // Calcul des informations de période
        $dateDebut = $professeur->matieres->pluck('pivot.date_debut')->filter()->sort()->first();
        $dateFin = $professeur->matieres->pluck('pivot.date_fin')->filter()->sort()->last();
        $periode = ($dateDebut && $dateFin) ? \Carbon\Carbon::parse($dateDebut)->diffInDays(\Carbon\Carbon::parse($dateFin)) : 0;
        $joursRestants = $periode - ($cahierTextes->count() ?? 0);
    @endphp

    <!-- Résumé global -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">
                        <i class="fas fa-hourglass-half"></i> Heures effectuées
                    </h5>
                    <p class="display-4 fw-bold text-success">
                        {{ $cahierTextes->sum('heures_effectuees') }} h
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">
                        <i class="fas fa-hourglass-end"></i> Heures restantes
                    </h5>
                    <p class="display-4 fw-bold text-danger">
                        {{ max(0, ($professeur->matieres->sum('pivot.nb_heures') ?? 0) - $cahierTextes->sum('heures_effectuees')) }} h
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-info shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">
                        <i class="fas fa-calendar-alt"></i> Période
                    </h5>
                    <p class="fw-bold text-dark">Durée : {{ $periode }} jours</p>
                    <p class="fw-bold text-dark">Jours restants : {{ $joursRestants }} jours</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des cours enregistrés (sans date début et fin) -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-list"></i> Liste des cours enregistrés
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-dark text-center">
                    <tr>
                        <th><i class="fas fa-book"></i> Matière</th>
                        <th><i class="fas fa-chalkboard-teacher"></i> Classe</th>
                        <th><i class="fas fa-align-left"></i> Résumé</th>
                        <th><i class="fas fa-clock"></i> Heures</th>
                        <th><i class="fas fa-calendar-alt"></i> Date d'enregistrement</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($cahierTextes as $cahierTexte)
                        <tr>
                            <td class="fw-bold">{{ $cahierTexte->matiere->nom ?? 'Matière inconnue' }}</td>
                            <td class="text-primary">{{ $cahierTexte->classe->name ?? 'Classe inconnue' }}</td>
                            <td class="text-muted">{{ $cahierTexte->resume_cours ?? 'Aucun résumé disponible' }}</td>
                            <td class="fw-bold text-success">{{ $cahierTexte->heures_effectuees ?? 0 }} h</td>
                            <td class="fw-bold text-dark">{{ \Carbon\Carbon::parse($cahierTexte->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Zone d'affichage des dates d'attribution -->
    @if($dateDebut || $dateFin)
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                Dates d'attribution
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <strong>Date de début:</strong>
                        <p>{{ $dateDebut ? \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <strong>Date de fin:</strong>
                        <p>{{ $dateFin ? \Carbon\Carbon::parse($dateFin)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($cahierTextes) && $cahierTextes->isEmpty())
        <div class="alert alert-info text-center mt-4">
            <i class="fas fa-exclamation-circle"></i> Aucun cahier de texte disponible pour ce professeur.
        </div>
    @endif
</div>
@endsection
