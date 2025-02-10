@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <!-- Titre de la page avec boutons circulaires -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold"><i class="fas fa-users me-2"></i>Liste des Étudiants ESGS</h1>

            <div class="d-flex gap-3">
                <a href="{{ route('students.create') }}" class="btn btn-success btn-lg shadow rounded-circle d-flex align-items-center justify-content-center" 
                   style="width: 50px; height: 50px;" title="Ajouter un étudiant">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{ route('classes.create') }}" class="btn btn-primary btn-lg shadow rounded-circle d-flex align-items-center justify-content-center" 
                   style="width: 50px; height: 50px;" title="Créer une classe">
                    <i class="fas fa-layer-group"></i>
                </a>
                <a href="{{ route('students.assign_class') }}" class="btn btn-warning btn-lg shadow rounded-circle d-flex align-items-center justify-content-center" 
                   style="width: 50px; height: 50px;" title="Affecter un étudiant à une classe">
                    <i class="fas fa-user-plus"></i>
                </a>
            </div>
        </div>

        <!-- Barre de navigation des classes -->
        <div class="mb-4">
            <h5 class="text-primary fw-bold"><i class="fas fa-filter me-2"></i>Filtrer par classe</h5>
            <div class="btn-group" role="group">
                @foreach(['bts1' => 'BTS 1', 'bts2' => 'BTS 2', 'licence1' => 'Licence 1', 'licence2' => 'Licence 2', 'licence3' => 'Licence 3', 'master1' => 'Master 1', 'master2' => 'Master 2'] as $key => $value)
                    <a href="{{ route('students.index', ['class' => $key]) }}" class="btn btn-outline-primary fw-bold">{{ $value }}</a>
                @endforeach
            </div>
        </div>

        <!-- Tableau des étudiants -->
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white rounded-top text-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list-alt me-2"></i>Liste des étudiants</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center mb-0">
                        <thead class="bg-light text-uppercase fw-bold">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Lieu de naissance</th>
                                <th>Date de naissance</th>
                                <th>Classe</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->prenom }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->tel_perso }}</td>
                                    <td>{{ $student->lieu_naissance }}</td>
                                    <td>{{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($student->classe)
                                            <span class="badge bg-info text-white">{{ $student->classe->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">Non assignée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">
                                        <i class="fas fa-exclamation-circle"></i> Aucun étudiant trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav>{!! $students->links('pagination::bootstrap-4') !!}</nav>
        </div>
    </div>
@endsection
