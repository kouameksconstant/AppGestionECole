@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary"><i class="fas fa-user-plus"></i> Assigner un étudiant à une classe</h1>

        <form action="{{ route('students.store_assign_class') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="student_id" class="form-label">Étudiant</label>
                <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                    <option value="">Sélectionner un étudiant</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} {{ $student->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <select name="classe_id" id="classe_id" class="form-control @error('classe_id') is-invalid @enderror">
                    <option value="">Sélectionner une classe</option>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->name }}
                        </option>
                    @endforeach
                </select>
                @error('classe_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assigner</button>
        </form>
    </div>
@endsection
