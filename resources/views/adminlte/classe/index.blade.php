@extends('adminlte.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-primary">Liste des Classes</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr>
                        <td>{{ $class->id }}</td>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->description }}</td>
                        <td>
                            <!-- Liens d'édition et suppression -->
                            <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
