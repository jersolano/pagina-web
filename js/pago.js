$(document).ready(function () {
    console.log("Script js/pago.js funcionando");
    console.log("Verificando carrito...");

    // Obtener el carrito y otros datos desde localStorage
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let pedidoId = localStorage.getItem("pedido_id");
    let totalPedido = localStorage.getItem("total_pedido") || "0.00";

    // Si el carrito está vacío, redirigir al menú con SweetAlert
    if (carrito.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Carrito Vacío",
            text: "Tu carrito está vacío. Serás redirigido al menú.",
            confirmButtonText: "Aceptar",
            allowOutsideClick: false
        }).then(() => {
            window.location.href = "menu.php";
        });
        return;
    }

    // Mostrar el monto total del pedido en la página
    $("#monto-total").text(`S/. ${parseFloat(totalPedido).toFixed(2)}`);

    // Validar y enviar el formulario de pago
    $("#btnConfirmarPago").on("click", function () {
        console.log("Validando formulario de pago...");

        // Obtener valores de los campos
        let operacion = $("#operacion").val().trim();
        let monto = $("#monto").val().trim();

        // Validaciones
        if (operacion === "" || !/^\d+$/.test(operacion)) {
            Swal.fire({
                icon: "error",
                title: "Número de Operación Inválido",
                text: "Por favor, ingresa un número de operación válido.",
                confirmButtonText: "Aceptar"
            });
            return;
        }

        if (monto === "" || isNaN(monto) || parseFloat(monto) <= 0) {
            Swal.fire({
                icon: "error",
                title: "Monto Inválido",
                text: "Por favor, ingresa un monto válido mayor a 0.",
                confirmButtonText: "Aceptar"
            });
            return;
        }

        // Validar que el monto pagado coincida con el total del pedido
        if (parseFloat(monto) < parseFloat(totalPedido)) {
            Swal.fire({
                icon: "warning",
                title: "Monto Insuficiente",
                text: `El monto pagado es menor al total del pedido (S/. ${parseFloat(totalPedido).toFixed(2)}).`,
                confirmButtonText: "Revisar"
            });
            return;
        }

        // Confirmación antes de enviar la solicitud
        Swal.fire({
            title: "¿Confirmar Pago?",
            text: "Una vez confirmado, no se podrá modificar.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar la petición AJAX
                $.ajax({
                    type: "POST",
                    url: SERVER_NAME + "AJAX/ajax.php",
                    data: {
                        metodo: "confirmarPago",
                        pedido_id: pedidoId,
                        total: totalPedido,
                        operacion: operacion,
                        monto: monto
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log("Respuesta del servidor:", response);

                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Pago Confirmado",
                                text: "Tu pago ha sido registrado con éxito.",
                                confirmButtonText: "Aceptar",
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href = "voucher.php"; // Redirigir a la confirmación
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error en el Pago",
                                text: response.message || "No se pudo procesar el pago.",
                                confirmButtonText: "Intentar de nuevo"
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al registrar el pago:", error);
                        Swal.fire({
                            icon: "error",
                            title: "Error en el Pago",
                            text: "Hubo un problema al procesar tu pago. Inténtalo nuevamente.",
                            confirmButtonText: "Aceptar"
                        });
                    }
                });
            }
        });
    });
});
