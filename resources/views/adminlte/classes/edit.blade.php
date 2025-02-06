@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary">Modifier la Classe</h1>

        <form action="{{ route('classes.update', $class->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="className" class="form-label">Nom de la classe</label>
                <input type="text" class="form-control" id="className" name="name" value="{{ $class->name }}" required>
            </div>
            <div class="mb-3">
                <label for="classDescription" class="form-label">Description (optionnel)</label>
                <textarea class="form-control" id="classDescription" name="description">{{ $class->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection
