<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pollería El Deleite</title>

  <!-- Bootstrap CSS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <header class="text-center py-4  shadow-lg">
    <img src="assets/img/logo.png" alt="Logo de Pollería El Deleite" class="img-fluid mb-2" style="max-width: 150px;">
    <h1 class="fw-bold">Pollería El Deleite</h1>
  </header>

  <main class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
    <div class="text-center">
      <button class="btn btn-primary btn-lg m-2 w-50" onclick="location.href='menu.php'">Cliente</button>
      <button class="btn btn-danger btn-lg m-2 w-50" onclick="location.href='admin_login.php'">Administrador</button>
    </div>
  </main>

  <footer class="text-center py-3">
    &copy; 2025 Pollería El Deleite. Todos los derechos reservados.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="global.js"></script>
  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
</body>

</html>