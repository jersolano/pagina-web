<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pedido - Pollería El Deleite</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
    <style>
        body {
            background: url('assets/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.9);
        }

        @media print {
            button {
                display: none;
            }

            .container {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card p-4">
            <header class="text-center">
                <h2 class="text-primary">Comprobante de Pedido</h2>
                <hr>
            </header>

            <main>
                <section id="voucher-info">
                    <h4 class="text-success text-center">¡Pedido Confirmado!</h4>
                    <p><strong>ID de Pedido:</strong> <span id="pedido-id">---</span></p>
                    <p><strong>Cliente:</strong> <span id="cliente-nombre">---</span></p>
                    <p><strong>Total Pagado:</strong> S/ <span id="monto-total">0.00</span></p>

                    <h5 class="mt-3">Productos:</h5>
                    <ul id="lista-productos" class="list-group list-group-flush"></ul>

                    <p class="mt-3"><strong>Tipo de Pedido:</strong> <span id="tipo-pedido">---</span></p>
                    <p id="info-hora"><strong>Hora de Recojo:</strong> <span id="hora-recojo">---</span></p>
                    <p id="info-direccion"><strong>Dirección de Entrega:</strong> <span id="direccion">---</span></p>
                </section>

                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" onclick="window.print()">Imprimir Comprobante</button>
                    <button class="btn btn-secondary" id="btn-volver">Volver al Inicio</button>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let pedido_id = localStorage.getItem("pedido_id") || "No disponible";
            let cliente = localStorage.getItem("cliente") || "No disponible";
            let total_pedido = parseFloat(localStorage.getItem("total_pedido")) || 0.00;
            let tipoPedido = localStorage.getItem("tipoPedido") || "No especificado";
            let carritoData = localStorage.getItem("carrito");
            let productos = carritoData ? JSON.parse(carritoData) : [];

            document.getElementById("pedido-id").textContent = pedido_id;
            document.getElementById("cliente-nombre").textContent = cliente;
            document.getElementById("monto-total").textContent = total_pedido.toFixed(2);
            document.getElementById("tipo-pedido").textContent = tipoPedido;

            let listaProductos = document.getElementById("lista-productos");
            listaProductos.innerHTML = productos.length > 0 ?
                productos.map(p => `<li class="list-group-item">${p.nombre} - S/ ${p.precio} x ${p.cantidad}</li>`).join("") :
                "<li class='list-group-item'>No disponible</li>";

            if (tipoPedido === "Delivery") {
                document.getElementById("info-direccion").style.display = "block";
                document.getElementById("direccion").textContent = localStorage.getItem("direccion") || "No especificado";
                document.getElementById("info-hora").style.display = "none";

                // Agregar el costo del delivery (S/ 3.00)
                listaProductos.innerHTML += `<li class="list-group-item">Delivery - S/ 3.00</li>`;
                document.getElementById("monto-total").textContent = total_pedido.toFixed(2);
            } else {
                document.getElementById("info-hora").style.display = "block";
                document.getElementById("hora-recojo").textContent = localStorage.getItem("hora") || "No especificado";
                document.getElementById("info-direccion").style.display = "none";
            }
        });

        document.getElementById("btn-volver").addEventListener("click", function() {
            localStorage.clear(); // Borra todo el localStorage
            window.location.href = "menu.php"; // Vuelve a la página anterior
        });
    </script>

</body>

</html>