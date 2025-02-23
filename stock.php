<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Stock - Pollería El Deleite</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Stock</h1>
        <a href="admin_pedidos.html">Volver</a>
    </header>

    <main>
        <label for="stock-pollo">Stock de Pollo (Unidades):</label>
        <input type="number" id="stock-pollo" min="0">
        <button onclick="actualizarStock()">Actualizar Stock</button>
        <p>Stock Actual: <strong id="stock-actual">---</strong></p>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("stock-actual").textContent = localStorage.getItem("stockPollo") || "No definido";
        });

        function actualizarStock() {
            let stock = document.getElementById("stock-pollo").value;
            localStorage.setItem("stockPollo", stock);
            alert("Stock actualizado.");
            document.getElementById("stock-actual").textContent = stock;
        }
    </script>
</body>
</html>
