//Configuracion Seridor
const SERVER_NAME = "http://localhost:8080/P_Polleria/";

$(document).ready(function() {

    funcionalidadesGeneralesAdmin();

});

function funcionalidadesGeneralesAdmin(){
    try{
        // Salir del sistema
        $("#btnSalir").click(function() {


            Swal.fire({
                title: "¿Estás seguro?",
                text: "Se cerrará la sesión actual",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: SERVER_NAME+"AJAX/ajax.php",
                        data:{metodo:"cerrarSesion"},
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                // Eliminar datos de localStorage
                                localStorage.removeItem("adminID");
                                localStorage.removeItem("adminNombre");
    
                                Swal.fire("Sesión cerrada", response.message, "success").then(() => {
                                    window.location.href = "admin_login.php"; // Redirige a la página de login
                                });
                            } else {
                                Swal.fire("Error", "No se pudo cerrar la sesión.", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error", "Error en la solicitud.", "error");
                        }
                    });
                }
            });
        });
    }catch(e){
        console.log(e)
    }
}

function obtenerFechaActual() {
    let fecha = new Date();
    let dia = String(fecha.getDate()).padStart(2, '0');
    let mes = String(fecha.getMonth() + 1).padStart(2, '0');
    let año = String(fecha.getFullYear()).slice(-2);

    return `${dia}/${mes}/${año}`;
}

function asignarNombreUsuarioQueEntro(){
    $("#userMenu").text(localStorage.getItem("adminNombre"));
}