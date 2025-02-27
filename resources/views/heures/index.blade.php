@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
    <!-- Barre d'action en haut -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left fa-lg"></i> Retour
        </a>
        <h2 class="text-primary fw-bold">Comptabilité des Professeurs</h2>
        <div></div>
    </div>

    <!-- Description justifiée -->
    <div class="text-center mb-5" style="text-align: justify;">
        <p class="fs-5 text-muted">
            Cette page récapitule pour chaque professeur le nombre d'heures qui lui ont été assignées, les heures déjà réalisées ainsi que le total des heures d'absence. Le bulletin de paie est généré en fonction du nombre d'heures effectuées.
        </p>
        <hr class="w-50 mx-auto">
    </div>

    <!-- Tableau des professeurs -->
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-gradient-success text-white py-3">
            <h5 class="card-title mb-0">Récapitulatif des Heures par Professeur</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Professeur</th>
                            <th>Heures Assignées</th>
                            <th>Heures Réalisées</th>
                            <th>Heures d'Absence</th>
                            <th>Bulletin de Paie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professeurs as $professeur)
                        <tr>
                            <td class="fw-bold">{{ $professeur->nom }} {{ $professeur->prenom }}</td>
                            <td>
                                {{-- Somme des nb_heures de la relation matieres --}}
                                {{ $professeur->matieres->sum(fn($matiere) => $matiere->pivot->nb_heures) }} h
                            </td>
                            <td>
                                {{-- Somme des heures réalisées (relation heures) --}}
                                {{ $professeur->heures->sum('heure') }} h
                            </td>
                            <td>
                                {{-- Somme des heures d'absence (relation absences) --}}
                                {{ $professeur->absences->sum('duree') }} h
                            </td>
                            <td>
                                <a href="{{ route('professeur.payslip', $professeur->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-file-invoice-dollar"></i> Générer
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $professeurs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
