@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assigner un étudiant à une classe</h2>
    
    <form action="{{ route('students.storeAssignedClass') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Étudiant</label>
            <select name="student_id" id="student_id" class="form-control">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->prenom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" id="classe_id" class="form-control">
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('students.assignClass') }}">Assigner une classe</a>    </form>
</div>
@endsection
