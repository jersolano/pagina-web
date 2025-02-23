<?php
session_start();

// Si el administrador ya ha iniciado sesión, redirigir al dashboard
if (isset($_SESSION["admin_id"])) {
    echo '<script>window.location.href = "admin_dashboard.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso de Administrador - Pollería El Deleite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header class="text-center my-4">
        <h1>Acceso de Administrador</h1>
        <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
    </header>

    <main class="container">
        <h3 class="text-center mb-3">Iniciar Sesión</h3>
        <form id="formAdmin">
            <div class="mb-3">
                <label for="adminUser" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="adminUser" name="adminUser" required>
            </div>

            <div class="mb-3">
                <label for="passwordAdmin" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passwordAdmin" name="passwordAdmin" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁️</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script src="js/admin_login.js"></script>
    <script>
        $(document).ready(function() {
            $("#togglePassword").click(function() {
                let passwordField = $("#passwordAdmin");
                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    $(this).html("🙈");
                } else {
                    passwordField.attr("type", "password");
                    $(this).html("👁️");
                }
            });
        });
    </script>
</body>

</html>