@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold">
        <i class="fas fa-chalkboard-teacher"></i> Assigner une Matière à un Professeur dans une Classe
    </h2>

    <div class="card shadow-lg p-3 mb-4 bg-body rounded">
        <div class="card-body">
            <form action="{{ route('matieres.assign.save') }}" method="POST">
                @csrf
                
                <!-- Sélection du Professeur -->
                <div class="mb-3">
                    <label for="professeur" class="form-label">Sélectionnez un Professeur :</label>
                    <select name="professeur_id" id="professeur" class="form-select" required>
                        <option value="">-- Choisissez un professeur --</option>
                        @foreach($professeurs as $professeur)
                            <option value="{{ $professeur->id }}">{{ $professeur->nom }} {{ $professeur->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection des Matières -->
                <div class="mb-3">
                    <label for="matieres" class="form-label">Sélectionnez une matière :</label>
                    <select name="matiere_id" id="matieres" class="form-select" required>
                        <option value="">-- Choisissez une matière --</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection de la Classe -->
                <div class="mb-3">
                    <label for="classe" class="form-label">Sélectionnez une classe :</label>
                    <select name="classe_id" id="classe" class="form-select" required>
                        <option value="">-- Choisissez une classe --</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nombre d'heures -->
                <div class="mb-3">
                    <label for="nb_heures" class="form-label">Nombre d'heures :</label>
                    <input type="number" name="nb_heures" id="nb_heures" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Assigner
                </button>
            </form>
        </div>
    </div>

    <!-- Affichage des attributions -->
    <h3 class="text-center text-success fw-bold mt-4">Attributions actuelles</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Professeur</th>
                <th>Matière</th>
                <th>Classe</th>
                <th>Nombre d'heures</th>
                <th>Heures Restantes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professeurs as $professeur)
                @foreach($professeur->matieres as $matiere)
                    @php
                        $heuresEffectuees = $matiere->pivot->heures_effectuees ?? 0;
                        $heuresRestantes = $matiere->pivot->nb_heures - $heuresEffectuees;
                    @endphp
                    <tr>
                        <td>{{ $professeur->nom }} {{ $professeur->prenom }}</td>
                        <td>{{ $matiere->nom }}</td>
                        <td>{{ \App\Models\Classe::find($matiere->pivot->classe_id)->name ?? 'Classe inconnue' }}</td>
                        <td>{{ $matiere->pivot->nb_heures ?? 'Non spécifié' }} h</td>
                        <td>{{ $heuresRestantes }} h</td>
                        <td>
                            <!-- Bouton Marquer Présence/Absence -->
                            <form action="{{ route('professeur.absence', $professeur->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-user-times"></i> Absence
                                </button>
                            </form>

                            <!-- Bouton Remplir Cahier de Texte -->
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#cahierModal{{ $professeur->id }}">
                                <i class="fas fa-book"></i> Cahier de Texte
                            </button>

                            <!-- Bouton Voir Cahier de Texte -->
                            <a href="{{ route('cahier.texte.view', $professeur->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Voir Cahier
                            </a>

                            <!-- Bouton Modifier -->
                            <a href="{{ route('attribution.edit', $professeur->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>

                            <!-- Modal Cahier de Texte -->
                            <div class="modal fade" id="cahierModal{{ $professeur->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('cahier.texte.save') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Remplir Cahier de Texte</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="professeur_id" value="{{ $professeur->id }}">
                                                <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                                <input type="hidden" name="classe_id" value="{{ $matiere->pivot->classe_id }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Résumé du cours :</label>
                                                    <textarea name="resume_cours" class="form-control" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Heures effectuées :</label>
                                                    <input type="number" name="heures_effectuees" class="form-control" min="1" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Valider</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
