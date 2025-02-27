{{-- resources/views/absences/detail.blade.php --}}
@extends('adminlte.layout')

@section('content')
<div class="container mt-5">
  <!-- Barre d'action en haut : Bouton Retour et Titre -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('matieres.assign') }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Retour
    </a>
    <h2 class="text-primary fw-bold fs-3">Détails des Absences</h2>
    <div class="d-none d-md-block" style="width: 40px;"></div>
  </div>

  <!-- Description -->
  <div class="text-center mb-5">
    <p class="fs-5 text-muted">Consultez les informations complètes de chaque absence, incluant la date, la durée, le motif et le statut.</p>
    <hr class="w-50 mx-auto">
  </div>

  <!-- Carte avec tableau des absences -->
  <div class="card shadow-lg border-0">
    <div class="card-header bg-gradient-primary text-bard py-3">
      <h5 class="card-title mb-0">Informations Complètes</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col" class="py-3">ID</th>
              <th scope="col" class="py-3">Date d'Absence</th>
              <th scope="col" class="py-3">Durée (h)</th>
              <th scope="col" class="py-3">Motif</th>
              <th scope="col" class="py-3">Statut</th>
              <th scope="col" class="py-3">Créé le</th>
            </tr>
          </thead>
          <tbody>
            @forelse($absences as $absence)
            <tr>
              <td class="py-2">{{ $absence->id }}</td>
              <td class="py-2">{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
              <td class="py-2">{{ $absence->duree }}</td>
              <td class="py-2">{{ $absence->motif ?? '-' }}</td>
              <td class="py-2">
                @if($absence->statut == 'en attente')
                  <span class="badge bg-warning text-dark">En attente</span>
                @elseif($absence->statut == 'approuvée')
                  <span class="badge bg-success">Approuvée</span>
                @elseif($absence->statut == 'rejetée')
                  <span class="badge bg-danger">Rejetée</span>
                @else
                  <span class="badge bg-secondary">{{ $absence->statut }}</span>
                @endif
              </td>
              <td class="py-2">{{ \Carbon\Carbon::parse($absence->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">Aucune absence trouvée.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        {{ $absences->links() }}
      </div>
    </div>
  </div>

  <!-- Bouton Retour en bas 
  <div class="text-center mt-5">
    <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary btn-lg">
      <i class="fas fa-arrow-left"></i> Retour
    </a>
  </div>
</div>-->
@endsection
