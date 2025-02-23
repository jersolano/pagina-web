$(document).ready(function () {
    console.log("Script js/mi_pedido.js funcionando");
    console.log("Verificando carrito...");

    // Obtener el carrito del localStorage
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    // Si el carrito está vacío, redirige al menú
    if (carrito.length === 0) {
        alert("Tu carrito está vacío. Te redirigimos al menú.");
        window.location.href = "menu.php";
    } else {
        actualizarCarrito2();
    }

    function actualizarCarrito2() {
        let listaCarrito = $("#lista-carrito");

        listaCarrito.empty();
        let total = 0;

        carrito.forEach((producto, index) => {
            let cantidad = (producto.cantidad === undefined)? 1 : producto.cantidad;
            total += producto.precio * cantidad;
            listaCarrito.append(`
                <li>
                    ${producto.nombre} - S/ ${producto.precio.toFixed(2)} x ${cantidad}
                    <button class="eliminar" data-index="${index}">❌</button>
                </li>
            `);

        });
        total = parseFloat(total.toFixed(2));
        $("#totalPedido_miPedido").append(` <br>Total S/ ${total}<br>--------------------------------------------`);
        // Mostrar u ocultar el carrito
        if (carrito.length > 0) {
            $("#carrito-container").show();
        } else {
            $("#carrito-container").hide();
        }
    }

    // Evento para eliminar productos del carrito
    $(document).on("click", ".eliminar", function () {
        let index = $(this).data("index");
        carrito.splice(index, 1);
        localStorage.setItem("carrito", JSON.stringify(carrito));
        actualizarCarrito2();
        if (carrito.length === 0) {
            alert("Tu carrito está vacío. Te redirigimos al menú.");
            window.location.href = "menu.php";
        }
    });
});
