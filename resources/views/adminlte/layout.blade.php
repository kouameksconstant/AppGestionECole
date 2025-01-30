<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE v4 - Dashboard</title>

  <!-- Styles CSS -->
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <!-- FontAwesome (pour les icônes) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <!-- Styles personnalisés -->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    @include('adminlte.partials.navbar')

    <!-- Sidebar -->
    @include('adminlte.partials.sidebar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content p-4">
        @yield('content') <!-- Contenu dynamique -->
      </section>
    </div>

    <!-- Footer -->
    @include('adminlte.partials.footer')
  </div>

  <!-- Scripts JavaScript -->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE JS -->
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
  <!-- Scripts personnalisés -->
  <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
