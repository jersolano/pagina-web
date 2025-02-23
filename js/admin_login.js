$(document).ready(function () {
    $("#formAdmin").submit(function (e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        let usuario = $("#adminUser").val().trim();
        let password = $("#passwordAdmin").val().trim();

        // Validar que los campos no estén vacíos
        if (usuario === "" || password === "") {
            Swal.fire({
                icon: "warning",
                title: "Campos Vacíos",
                text: "Por favor, complete todos los campos.",
            });
            return;
        }

        // Enviar datos por AJAX
        $.ajax({
            url: SERVER_NAME+"AJAX/ajax.php", // Archivo que procesará la petición
            type: "POST",
            data: {metodo:"validarLoginAdministrador", usuario: usuario, password: password },
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Validando...",
                    text: "Por favor, espere...",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                });
            },
            success: function (response) {
                Swal.close(); // Cierra el modal de carga

                if (response.status === "success") {
                    // Guardar datos en LocalStorage
                    localStorage.setItem("adminID", response.admin_id);
                    localStorage.setItem("adminNombre", response.admin_user);
                    Swal.fire({
                        icon: "success",
                        title: "Bienvenido",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = "admin_dashboard.php"; // Redirigir al dashboard
                    });
                    window.location.href = "admin_dashboard.php";
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error de Conexión",
                    text: "No se pudo conectar con el servidor. Inténtelo de nuevo.",
                });
            },
        });
    });

});
