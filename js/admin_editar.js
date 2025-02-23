$(document).ready(() => {
    asignarNombreUsuarioQueEntro();
    $("#form-registrar-admin").on("submit", function (event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario

        // Validar el formulario manualmente
        if (!this.checkValidity()) {
            event.stopPropagation();
            $(this).addClass("was-validated"); // Aplicar estilos de validación de Bootstrap
            return;
        }

        // Serializar los datos del formulario
        let formData = $(this).serialize();

        // Enviar la petición AJAX
        $.ajax({
            url: SERVER_NAME+"AJAX/ajax.php",
            type: "POST",
            data: formData + "&metodo=editarAdmin&admin_id=" + $("#form-registrar-admin").attr("data-idAdmin"),
            dataType: "json",
            success: function (response) {
                console.log("Respuesta del servidor:", response); // Ver la respuesta en consola
        
                if (response && response.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "Administrador editado con éxito",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = SERVER_NAME + "admin_admins.php";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message || "Ocurrió un error inesperado.",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error AJAX:", textStatus, errorThrown);
                console.error("Respuesta del servidor:", jqXHR.responseText); // Ver la respuesta completa
        
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un error al procesar la solicitud.",
                    confirmButtonText: "OK"
                });
            }
        });
        
    });
});
