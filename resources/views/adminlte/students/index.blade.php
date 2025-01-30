@extends('adminlte.layout') <!-- Utilise le layout AdminLTE -->

@section('content')
    <div class="container mt-4">
        <!-- Titre de la page -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary"><i class="fas fa-users"></i> Liste des Étudiants-ESGS</h1>
            <a href="{{ route('students.create') }}" class="btn btn-success btn-lg">
                <i class="fas fa-plus-circle"></i> Ajouter un étudiant
            </a>
        </div>

        <!-- Tableau des étudiants -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white rounded-top">
                <h5 class="mb-0"><i class="fas fa-list-alt"></i> Liste des étudiants enregistrés</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center border">#</th>
                                <th class="border">Nom</th>
                                <th class="border">Prénom</th>
                                <th class="border">Email</th>
                                <th class="border">Numéro de téléphone</th>
                                <th class="border">Lieu de naissance</th>
                                <th class="border">Date de naissance</th>
                                <th class="text-center border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td class="text-center border">{{ $student->id }}</td>
                                    <td class="border">{{ $student->name }}</td>
                                    <td class="border">{{ $student->prenom }}</td>
                                    <td class="border">{{ $student->email }}</td>
                                    <td class="border">{{ $student->tel_perso }}</td>
                                    <td class="border">{{ $student->lieu_naissance }}</td>
                                    <td class="border">{{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}</td>
                                    <td class="text-center border">
                                        <!-- Boutons d'action -->
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted border">
                                        <i class="fas fa-exclamation-circle"></i> Aucun étudiant trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer de la carte -->
            <div class="card-footer bg-light text-center rounded-bottom">
                @if ($students->hasPages())
                    {{ $students->links('pagination::bootstrap-5') }} <!-- Pagination Bootstrap -->
                @endif
            </div>
        </div>
    </div>
@endsection
