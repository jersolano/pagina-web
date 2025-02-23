$(document).ready(function () {
    $("#formRecoger").submit(function (event) {
        event.preventDefault(); // Evita el envío por defecto
        let dni = $("#dni").val().trim();
        let nombre = $("#nombre").val().trim();
        let celular = $("#celular").val().trim();
        let direccion = $("#direccion").val().trim();

        // Validación de campos vacíos
        if (dni === "" ||nombre === "" || celular === "" || direccion === "") {
            Swal.fire({
                icon: "warning",
                title: "Campos Vacíos",
                text: "Por favor, completa todos los campos.",
            });
            return;
        }

        // Validación del celular (9 dígitos)
        let celularRegex = /^[0-9]{9}$/;
        let dniRegex = /^[0-9]{8}$/;
        if (!celularRegex.test(celular)) {
            Swal.fire({
                icon: "error",
                title: "Número Inválido",
                text: "El número de celular debe tener 9 dígitos.",
            });
            return;
        }
        if (!dniRegex.test(dni)) {
            Swal.fire({
                icon: "error",
                title: "DNI Inválido",
                text: "El número de DNI debe tener 8 dígitos.",
            });
            return;
        }

        // Obtener el carrito de localStorage (o de donde lo tengas almacenado)
        let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

        // Si todo está correcto, mostrar alerta de éxito y llamar a `registrarPedido`
        registrarPedido(carrito, dni, nombre, celular, 1, direccion);
    });
});
