<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - Pollería El Deleite</title>

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">

    <!-- Estilos personalizados -->
    <style>
        body {
            background: url('assets/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>

<body>

    <div class="overlay container py-4">
        <!-- Botón de retroceso -->
        <button class="btn btn-dark btn-back" onclick="history.back()">⬅ Atrás</button>

        <!-- Contenido principal -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">Confirmar Pago</h1>
                </div>

                <!-- Total a pagar -->
                <div class="alert alert-info text-center">
                    <h2>Total a Pagar: <strong id="monto-total">S/ 0.00</strong></h2>
                </div>

                <!-- Opciones de pago -->
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h2 class="card-title">Opciones de Pago</h2>
                        <h3 class="text-primary">Yape</h3>
                        <img src="assets/img/qr_yape.png" alt="Código QR de Yape" class="img-fluid rounded w-50">
                        <p class="mt-2">Número de Celular: <strong>944 566 662</strong></p>
                    </div>
                </div>

                <!-- Formulario de pago -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Confirmar Pago</h2>
                        <form id="formPago">
                            <div class="mb-3">
                                <label for="operacion" class="form-label">Número de Operación:</label>
                                <input type="text" id="operacion" class="form-control" placeholder="Ej: 123456789" required>
                            </div>

                            <div class="mb-3">
                                <label for="monto" class="form-label">Monto Pagado:</label>
                                <input type="number" id="monto" class="form-control" placeholder="Ej: 50.00" min="0.10" step="0.01" required>
                            </div>

                            <button type="button" class="btn btn-success w-100" id="btnConfirmarPago">✅ Confirmar Pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script src="js/pago.js"></script>
</body>

</html>