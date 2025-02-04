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

                <!-- Bouton pour créer une classe -->
                <a href="{{ route('classes.create') }}" class="btn btn-primary btn-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" title="Créer une classe">
                    <i class="fas fa-layer-group"></i>
                </a>

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
                @php
                    $classes = ['bts1' => 'BTS 1', 'bts2' => 'BTS 2', 'licence1' => 'Licence 1', 
                                'licence2' => 'Licence 2', 'licence3' => 'Licence 3', 
                                'master1' => 'Master 1', 'master2' => 'Master 2'];
                @endphp

                @foreach ($classes as $key => $label)
                    <a href="{{ route('students.index', ['class' => $key]) }}" 
                       class="btn {{ request('class') == $key ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $label }}
                    </a>
                @endforeach
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
                                <th class="border">Classe</th> <!-- Nouvelle colonne pour la classe -->
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
                                    <td colspan="9" class="text-center text-muted border">
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
                    {{ $students->appends(['class' => request('class')])->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
