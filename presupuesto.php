<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto Diario - Pollería El Deleite</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Presupuesto Diario</h1>
        <a href="admin_pedidos.html">Volver</a>
    </header>

    <main>
        <h2>Total de Ventas: S/ <span id="total-ventas">0.00</span></h2>
        <h3>Detalle de Ventas por Producto:</h3>
        <ul id="detalle-ventas"></ul>

        <h3>Resumen de Pedidos:</h3>
        <table id="tablaPresupuesto">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los pedidos se insertarán aquí dinámicamente -->
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let pedidos = JSON.parse(localStorage.getItem("pedidos")) || [];
            let totalVentas = pedidos.reduce((total, pedido) => total + parseFloat(pedido.monto), 0);
            document.getElementById("total-ventas").textContent = totalVentas.toFixed(2);

            let detalleVentas = {};
            pedidos.forEach(pedido => {
                pedido.productos.forEach(producto => {
                    let nombreProducto = producto.split(" - ")[0];
                    if (detalleVentas[nombreProducto]) {
                        detalleVentas[nombreProducto]++;
                    } else {
                        detalleVentas[nombreProducto] = 1;
                    }
                });
            });

            let detalleLista = document.getElementById("detalle-ventas");
            detalleLista.innerHTML = Object.entries(detalleVentas).map(([producto, cantidad]) => 
                `<li>${producto}: ${cantidad} vendidos</li>`).join("");

            let tablaPresupuesto = document.getElementById("tablaPresupuesto").querySelector("tbody");
            tablaPresupuesto.innerHTML = pedidos.length === 0
                ? "<tr><td colspan='4'>No hay ventas registradas hoy.</td></tr>"
                : pedidos.map(p => 
                    `<tr>
                        <td>${p.id}</td>
                        <td>${p.cliente}</td>
                        <td>S/ ${p.monto}</td>
                        <td>${p.tipo}</td>
                    </tr>`).join("");
        });
    </script>
</body>
</html>
