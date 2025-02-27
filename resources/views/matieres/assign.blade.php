{{-- resources/views/absences/detail.blade.php --}}
@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
    <!-- Barre d'action en haut : Bouton Retour et Voir les absences -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('professeurs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>
        <a href="{{ route('absences.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-calendar-alt me-1"></i> Voir les absences
        </a>
    </div>

    <!-- Titre principal -->
    <div class="text-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="fas fa-chalkboard-teacher me-2"></i> Assigner une Matière à un Professeur
        </h2>
        <hr class="w-25 mx-auto">
    </div>

    <!-- Formulaire d'assignation dans une carte -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Formulaire d'Assignation</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('matieres.assign.save') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="professeur" class="form-label text-justify">Professeur :</label>
                        <select name="professeur_id" id="professeur" class="form-select" required>
                            <option value="">-- Choisissez --</option>
                            @foreach($professeurs as $professeur)
                                <option value="{{ $professeur->id }}">
                                    {{ $professeur->nom }} {{ $professeur->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="matieres" class="form-label text-justify">Matière :</label>
                        <select name="matiere_id" id="matieres" class="form-select" required>
                            <option value="">-- Choisissez --</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="classe" class="form-label text-justify">Classe :</label>
                        <select name="classe_id" id="classe" class="form-select" required>
                            <option value="">-- Choisissez --</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nb_heures" class="form-label text-justify">Heures :</label>
                        <input type="number" name="nb_heures" id="nb_heures" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label for="date_debut" class="form-label text-justify">Début :</label>
                        <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="date_fin" class="form-label text-justify">Fin :</label>
                        <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save fa-lg me-2"></i> Assigner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des attributions dans une carte avec design moderne -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Attributions Actuelles</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Professeur</th>
                            <th>Matière</th>
                            <th>Classe</th>
                            <th>Heures</th>
                            <th>Restantes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professeurs as $professeur)
                            @foreach($professeur->matieres as $matiere)
                                @php
                                    $heuresEffectuees = $matiere->pivot->heures_effectuees ?? 0;
                                    $heuresRestantes = $matiere->pivot->nb_heures - $heuresEffectuees;
                                    $classe = \App\Models\Classe::find($matiere->pivot->classe_id);
                                @endphp
                                <tr>
                                    <td>{{ $professeur->nom }} {{ $professeur->prenom }}</td>
                                    <td>{{ $matiere->nom }}</td>
                                    <td>{{ $classe ? $classe->name : 'Inconnue' }}</td>
                                    <td>{{ $matiere->pivot->nb_heures ?? 'Non spécifié' }} h</td>
                                    <td>{{ $heuresRestantes }} h</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Bouton Signaler Absence : Ouvre le modal pour déclarer l'absence -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#absenceModal{{ $professeur->id }}-{{ $matiere->id }}" title="Signaler Absence">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                            <!-- Bouton Cahier de Texte -->
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#cahierModal{{ $professeur->id }}-{{ $matiere->id }}" title="Cahier de Texte">
                                                <i class="fas fa-book"></i>
                                            </button>
                                            <!-- Bouton Voir Cahier -->
                                            <a href="{{ route('cahier.view', ['id' => $professeur->id]) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir Cahier">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal Cahier de Texte -->
                                <div class="modal fade" id="cahierModal{{ $professeur->id }}-{{ $matiere->id }}" tabindex="-1" aria-labelledby="cahierModalLabel{{ $professeur->id }}-{{ $matiere->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('cahier.texte.save') }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-justify" id="cahierModalLabel{{ $professeur->id }}-{{ $matiere->id }}">Cahier de Texte - {{ $matiere->nom }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="professeur_id" value="{{ $professeur->id }}">
                                                    <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                                    <input type="hidden" name="classe_id" value="{{ $classe->id ?? '' }}">
                                                    <div class="mb-3">
                                                        <label class="form-label text-justify">Résumé du Cours :</label>
                                                        <textarea name="resume_cours" class="form-control" rows="4" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-justify">Date :</label>
                                                        <input type="date" name="date" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-justify">Heures effectuées :</label>
                                                        <input type="number" name="heures_effectuees" class="form-control" min="1" max="{{ $heuresRestantes }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Modal pour Signaler une Absence -->
                                <div class="modal fade" id="absenceModal{{ $professeur->id }}-{{ $matiere->id }}" tabindex="-1" aria-labelledby="absenceModalLabel{{ $professeur->id }}-{{ $matiere->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('professeur.absence', $professeur->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-justify" id="absenceModalLabel{{ $professeur->id }}-{{ $matiere->id }}">Déclarer une Absence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Champs cachés pour transmettre matiere_id et classe_id -->
                                                    <input type="hidden" name="professeur_id" value="{{ $professeur->id }}">
                                                    <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                                    <input type="hidden" name="classe_id" value="{{ $classe->id ?? '' }}">
                                                    <div class="mb-3">
                                                        <label for="date_absence_{{ $professeur->id }}-{{ $matiere->id }}" class="form-label text-justify">Date d'absence :</label>
                                                        <input type="date" name="date_absence" id="date_absence_{{ $professeur->id }}-{{ $matiere->id }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="duree_{{ $professeur->id }}-{{ $matiere->id }}" class="form-label text-justify">Durée (en heures) :</label>
                                                        <input type="number" name="duree" id="duree_{{ $professeur->id }}-{{ $matiere->id }}" class="form-control" min="1" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="motif_{{ $professeur->id }}-{{ $matiere->id }}" class="form-label text-justify">Motif :</label>
                                                        <textarea name="motif" id="motif_{{ $professeur->id }}-{{ $matiere->id }}" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-user-times me-1"></i> Signaler l'absence
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
