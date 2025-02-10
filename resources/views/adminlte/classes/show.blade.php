@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary"><i class="fas fa-users"></i> Étudiants dans la classe : {{ $class->name }}</h1>

        <div class="row">
            @foreach ($students as $student)
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $student->name }} {{ $student->prenom }}</h5>
                            <p class="card-text">{{ $student->email }}</p>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste des classes
            </a>
        </div>
    </div>
@endsection
