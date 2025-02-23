<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido - Pollería El Deleite</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Detalle del Pedido</h1>
        <a href="admin_pedidos.html">Volver</a>
    </header>

    <main>
        <section id="pedido-detalle">
            <h2>ID de Pedido: <span id="pedido-id"></span></h2>
            <p><strong>Cliente:</strong> <span id="cliente-nombre"></span></p>
            <p><strong>Monto Total:</strong> S/ <span id="monto-total"></span></p>
            <h3>Productos:</h3>
            <ul id="lista-productos"></ul>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let pedido = JSON.parse(localStorage.getItem("pedidoSeleccionado")) || {};
            document.getElementById("pedido-id").textContent = pedido.id || "No disponible";
            document.getElementById("cliente-nombre").textContent = pedido.cliente || "No disponible";
            document.getElementById("monto-total").textContent = pedido.monto || "0.00";

            let listaProductos = document.getElementById("lista-productos");
            listaProductos.innerHTML = pedido.productos ? pedido.productos.map(p => `<li>${p}</li>`).join("") : "<li>No disponible</li>";
        });
    </script>
</body>

</html>