@extends('adminlte.layout')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4"><i class="fas fa-user-plus"></i> Assigner un étudiant à une classe</h2>
    
    <!-- Afficher les messages flash -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulaire pour assigner une classe -->
    <form action="{{ route('classes.storeAssignedClass') }}" method="POST" class="shadow-sm p-4 rounded-lg bg-light">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Sélectionner un étudiant</label>
            <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                <option value="" disabled selected>Choisir un étudiant</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->prenom }}</option>
                @endforeach
            </select>
            @error('student_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="class_id" class="form-label">Sélectionner une classe</label>
            <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror">
                <option value="" disabled selected>Choisir une classe</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
            </select>
            @error('class_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Assigner une classe</button>
        </div>
    </form>
</div>

<!-- Bouton Retour à la liste des étudiants -->
<div class="text-center mt-4">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste des étudiants
            </a>
        </div>
    </div>
@endsection
