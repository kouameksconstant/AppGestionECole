@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="mb-4 text-center text-primary">Liste des Heures pour {{ $professeur->nom }} {{ $professeur->prenom }}</h2>
    <p class="text-center">Nombre total d'heures assignées : {{ $heures->sum('heure') }}</p>
    
    <a href="{{ route('heures.create', ['professeur' => $professeur->id]) }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Ajouter une Heure
    </a>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped" id="heuresTable">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Matière</th>
                        <th>Heure</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($heures as $heure)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $heure->matiere ? $heure->matiere->nom : 'Matière non définie' }}</td>
                            <td>{{ $heure->heure }}</td>
                            <td>{{ \Carbon\Carbon::parse($heure->date_debut)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($heure->date_fin)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('heures.edit', ['professeur' => $professeur->id, 'heure' => $heure->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="{{ route('heures.show', ['professeur' => $professeur->id, 'heure' => $heure->id]) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Détails
                                </a>
                                <form action="{{ route('heures.destroy', ['professeur' => $professeur->id, 'heure' => $heure->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette heure ?')">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#heuresTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection
