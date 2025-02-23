<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elige una Opción - Pollería El Deleite</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Encabezado -->
    <header class="container text-center py-4">
        <h1 class="fw-bold">Elige una Opción</h1>
        <a href="menu.php" class="btn btn-secondary">← Volver al Menú</a>
    </header>

    <!-- Sección de opciones -->
    <main class="container text-center mt-4 flex-grow-1">
        <section id="opciones">
            <h2 class="mb-4">Selecciona tu forma de entrega</h2>
            <div class="d-grid gap-3 col-md-6 mx-auto">
                <button class="agregar" onclick="location.href='datos_recoger.php'">Recoger</button>
                <button class="agregar" onclick="location.href='datos_delivery.php'">Delivery</button>
                <button class="agregar" onclick="location.href='datos_mesa.php'">Comer en Mesa</button>
            </div>
        </section>

        <!-- Carrito de compras -->
        <section id="carrito-container" class="mt-5" style="display: none;">
            <h2 class="border-bottom pb-2">Tu Pedido</h2>
            <ul id="lista-carrito" class="list-group mb-3"></ul>
            <h2 id="totalPedido_miPedido" class="fw-bold"></h2>
        </section>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script src="js/mi_pedido.js"></script>
</body>

</html>