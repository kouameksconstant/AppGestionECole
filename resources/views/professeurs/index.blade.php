@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-4 text-center text-primary fw-bold">
        <i class="fas fa-users"></i> Liste des Professeurs
    </h2>

    <div class="card shadow-lg p-3 mb-4 bg-body rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('professeurs.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus-circle"></i> Ajouter un Professeur
                </a>
                <div>
                    <a href="{{ route('absences.index', ['professeur' => 1]) }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fas fa-calendar-check"></i> Gérer les Absences
                    </a>
                    <a href="{{ route('matieres.assign', ['professeur' => 1]) }}" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-chalkboard-teacher"></i> Assigner Matières
                    </a>
                    <a href="{{ route('heures.index', ['professeur' => 1]) }}" class="btn btn-outline-dark rounded-pill">
                        <i class="fas fa-clock"></i> Gérer les Heures
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped text-center" id="professeursTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Spécialité</th>
                            <th>Type de Contrat</th>
                            <th>Date de Début</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($professeurs as $prof)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($prof->photo ? 'storage/' . $prof->photo : 'images/default-avatar.png') }}" 
                                         alt="Photo de {{ $prof->nom }}" 
                                         class="rounded-circle border shadow" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $prof->nom }}</td>
                                <td>{{ $prof->prenom }}</td>
                                <td>{{ $prof->email }}</td>
                                <td>{{ $prof->telephone }}</td>
                                <td>{{ $prof->specialite }}</td>
                                <td>
                                    <span class="badge bg-{{ $prof->type_contrat == 'CDI' ? 'success' : 'warning' }}">
                                        {{ $prof->type_contrat }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($prof->date_debut)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('professeurs.edit', $prof->id) }}" class="btn btn-warning btn-sm rounded-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('professeurs.show', $prof->id) }}" class="btn btn-info btn-sm rounded-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('professeurs.destroy', $prof->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination pagination-rounded">
                        {{ $professeurs->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#professeursTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-outline-primary btn-sm rounded-pill' },
                { extend: 'csv', className: 'btn btn-outline-success btn-sm rounded-pill' },
                { extend: 'excel', className: 'btn btn-outline-info btn-sm rounded-pill' },
                { extend: 'pdf', className: 'btn btn-outline-danger btn-sm rounded-pill' },
                { extend: 'print', className: 'btn btn-outline-dark btn-sm rounded-pill' }
            ]
        });
    });
</script>
@endsection
