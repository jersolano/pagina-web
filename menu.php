<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuestro Menú - Pollería El Deleite</title>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

  <!-- Encabezado -->
  <header class="container text-center py-4 rounded">
    <h1 class="fw-bold">Nuestro Menú</h1>
    <div>
      <a href="index.php" class="btn btn-secondary mt-2">🏠 Volver al inicio</a>
      <!-- <a href="ver_mis_pedidos.php" class="btn btn-dark mt-2">🍗 Ver mis pedidos</a> -->

    </div>

  </header>

  <!--
    NOTA01: La información o trae de la base de datos mediante una peticióm asíncrona vía AJAX,
    Para esto se realiza una petición del tipo POST, ver línea 5 a 18 en el script: js/menu.js,
    los elementos html se agregan al DOM mediante JS, ver línea 20 a 74 en el script: js/menu.js
  -->
  <!-- Contenido principal -->
  <main class="container mt-4">
    <div class="row justify-content-center">

      <!-- Categoría: Pollo a la Brasa -->
      <section id="cartaMenuSeccion_pollos" class="col-md-5 mb-4">
      </section>

      <!-- Categoría: Acompañamientos -->
      <section id="cartaMenuSeccion_acompanamientos" class=" col-md-5 mb-4">
      </section>

      <!-- Categoría: Broasters -->
      <section id="cartaMenuSeccion_broasters" class=" col-md-5 mb-4">
      </section>
    </div>
    <!--
    FIN NOTA01; 
-->
    <!-- Carrito de Compras -->
    <section id="carrito" class="text-center mt-5">
      <h2>Carrito de Compras</h2>
      <ul id="lista-carrito" class="list-group mb-3"></ul>
      <p class="fs-5">Total: <strong id="total">S/ 0.00</strong></p>
      <button id="continuar-pedido" class="btn btn-success">Continuar</button>
    </section>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
  <script src="global.js"></script>
  <script src="script.js"></script>
  <script src="js/menu.js"></script>

</body>

</html>