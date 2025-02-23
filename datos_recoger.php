<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos para Recoger - Pollería El Deleite</title>

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="text-center py-3 shadow">
        <h1 class="fw-bold">Datos para Recoger</h1>
        <a href="mi_pedido.php" class="btn btn-secondary btn-sm">
            ← Atrás
        </a>
    </header>

    <main class="container flex-grow-1 d-flex justify-content-center align-items-center bg-transparent">
        <div class="card p-4 w-100 bg-transparent" style="max-width: 400px;">
            <form id="formRecoger">

                <div class="mb-3">
                    <label for="nombre" class="form-label">DNI:</label>
                    <input type="tel" id="dni" class="form-control" pattern="[0-9]{8}" placeholder="Ej: 72645194" maxlength="8" required>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo:</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                </div>

                <div class="mb-3">
                    <label for="celular" class="form-label">Número de Celular:</label>
                    <input type="tel" id="celular" class="form-control" pattern="[0-9]{9}"
                        placeholder="Ej: 987654321" maxlength="9" required>
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label">Hora de Recojo:</label>
                    <input type="time" id="hora" class="form-control" required>
                </div>

                <button type="submit" class="agregar">Siguiente →</button>

            </form>
        </div>
    </main>

    <footer class="text-center py-3">
        &copy; 2025 Pollería El Deleite. Todos los derechos reservados.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script src="js/datos_recoger.js"></script>
    <script src="js/registrarPedido.js"></script>
</body>

</html>