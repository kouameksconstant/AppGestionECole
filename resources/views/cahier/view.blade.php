@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cahier de Texte</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @foreach($cahierTextes as $cahierTexte)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Cours de {{ $cahierTexte->matiere->nom }}</h5>
                <p><strong>Professeur :</strong> {{ $cahierTexte->professeur->nom }}</p>
                <p><strong>Classe :</strong> {{ $cahierTexte->classe->nom }}</p>
                <p><strong>Résumé :</strong> {{ $cahierTexte->resume_cours }}</p>
                <p><strong>Heures effectuées :</strong> {{ $cahierTexte->heures_effectuees }}</p>
            </div>
        </div>
    @endforeach

    <a href="{{ route('dashboard') }}" class="btn btn-primary">Retour</a>
</div>
@endsection
