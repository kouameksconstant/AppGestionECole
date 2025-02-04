@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <!-- Titre de la page avec boutons circulaires -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary"><i class="fas fa-users"></i> Liste des Étudiants-ESGS</h1>

            <div class="d-flex gap-2">
                <!-- Bouton pour ajouter un étudiant -->
                <a href="{{ route('students.create') }}" class="btn btn-success btn-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" title="Ajouter un étudiant">
                    <i class="fas fa-plus"></i>
                </a>

                <!-- Bouton pour ouvrir la modal de création de classe -->
                <button type="button" class="btn btn-primary btn-lg rounded-circle d-flex align-items-center justify-content-center" 
                        style="width: 50px; height: 50px;" title="Créer une classe" data-bs-toggle="modal" data-bs-target="#createClassModal">
                    <i class="fas fa-layer-group"></i>
                </button>

                <!-- Bouton pour affecter un étudiant à une classe -->
                <a href="{{ route('students.assign_class') }}" class="btn btn-warning btn-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" title="Affecter un étudiant à une classe">
                    <i class="fas fa-user-plus"></i>
                </a>
            </div>
        </div>
    <!-- Barre de navigation des classes -->
    <div class="mb-4">
            <h5 class="text-primary"><i class="fas fa-filter"></i> Filtrer par classe</h5>
            <div class="btn-group" role="group" aria-label="Classe de filtrage">
                <a href="{{ route('students.index', ['class' => 'bts1']) }}" class="btn btn-outline-primary">BTS 1</a>
                <a href="{{ route('students.index', ['class' => 'bts2']) }}" class="btn btn-outline-primary">BTS 2</a>
                <a href="{{ route('students.index', ['class' => 'licence1']) }}" class="btn btn-outline-primary">Licence 1</a>
                <a href="{{ route('students.index', ['class' => 'licence2']) }}" class="btn btn-outline-primary">Licence 2</a>
                <a href="{{ route('students.index', ['class' => 'licence3']) }}" class="btn btn-outline-primary">Licence 3</a>
                <a href="{{ route('students.index', ['class' => 'master1']) }}" class="btn btn-outline-primary">Master 1</a>
                <a href="{{ route('students.index', ['class' => 'master2']) }}" class="btn btn-outline-primary">Master 2</a>
            </div>
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
                                <th class="border">Classe</th>
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
                                    <td class="border">
                                        @if($student->classe)
                                            <span class="badge bg-info text-white">{{ $student->classe->name }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white">Non assignée</span>
                                        @endif
                                    </td>
                                    <td class="text-center border">  
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
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
                                    <td colspan="9" class="text-center text-muted border">
                                        <i class="fas fa-exclamation-circle"></i> Aucun étudiant trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal de création de classe -->
<div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="createClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassModalLabel">Créer une nouvelle classe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createClassForm">
                    @csrf
                    <div class="mb-3">
                        <label for="className" class="form-label">Nom de la classe</label>
                        <input type="text" class="form-control" id="className" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('createClassForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Récupérer les données du formulaire
        let formData = new FormData(this);

        // Effectuer une requête fetch pour soumettre les données
        fetch("{{ route('classes.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Réponse:', data); // Vérifiez la réponse dans la console
            if (data.success) {
                // Redirection après succès
                window.location.href = "{{ route('classes.index') }}"; 
            } else {
                alert('Erreur lors de la création de la classe');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur s\'est produite. Veuillez réessayer.');
        });
    });
</script>

@endsection
