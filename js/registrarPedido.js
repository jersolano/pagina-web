$(document).ready(function () {
    console.log("Script para registrar pedido funcionando, URL: js/registrarPedido.js");

    function registrarPedido(carrito = [], dni, nombreCliente, celular, tipoPedido, direccion = "", horaRecojo = null) {
        let nombreTipoPedido = "";

        switch (tipoPedido) {
            case 1:
                nombreTipoPedido = "Delivery";
                break;
            case 2:
                nombreTipoPedido = "Mesa";
                break;
            case 3:
                nombreTipoPedido = "Recoger";
                break;
            default:
                nombreTipoPedido = "Desconocido"; // Valor por defecto si no coincide
                break;
        }

        if (carrito.length === 0) {
            console.warn("El carrito está vacío, no se registrará el pedido.");
            Swal.fire({
                icon: "warning",
                title: "Carrito Vacío",
                text: "Agrega productos antes de continuar.",
            });
            return;
        }

        // Calcular el total sumando (precio * cantidad) de cada producto
        let total = carrito.reduce((sum, producto) => sum + (producto.precio * producto.cantidad), 0);
        if(tipoPedido===1){
            total += 3;
        }
        $.ajax({
            type: "POST",
            url: SERVER_NAME + "AJAX/ajax.php",
            data: {
                metodo: "registrarPedido",
                dni: dni,
                nombreCliente: nombreCliente,
                celular: celular,
                direccion: direccion,
                horaRecojo: horaRecojo,
                tipoPedido: tipoPedido,
                total: total.toFixed(2), // Redondear a dos decimales
                carrito: JSON.stringify(carrito) // Convertir el array a JSON
            },
            dataType: "json",
            success: function (response) {
                console.log("Pedido registrado con éxito:", response);

                if (response.status === "success") {
                    // Guardar en localStorage
                    localStorage.setItem("pedido_id", response.pedido_id);
                    localStorage.setItem("total_pedido", total.toFixed(2));
                    localStorage.setItem("cliente", nombreCliente);
                    localStorage.setItem("tipoPedido", nombreTipoPedido);
                    localStorage.setItem("hora", horaRecojo);
                    localStorage.setItem("direccion", direccion);
                    
                    Swal.fire({
                        icon: "success",
                        title: "Pedido registrado",
                        text: "Ahora confirme el pago.",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "pago.php"; // Redirigir a la página de pago
                    });
                } else {
                    console.error("Error en la respuesta:", response);
                    Swal.fire({
                        icon: "error",
                        title: "Error en el pedido",
                        text: response.message || "Hubo un problema al procesar tu pedido.",
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al registrar el pedido:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error en el pedido",
                    text: "Hubo un problema al procesar tu pedido.",
                });
            }
        });
    }

    // Exponer la función globalmente para que `datos_recoger.js` pueda llamarla
    window.registrarPedido = registrarPedido;
});
