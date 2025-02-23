$(document).ready(function() {
    // Cargar pedidos al cargar la página
    cargarAdmins();
    asignarNombreUsuarioQueEntro();
});


// Cargar pedidos con AJAX
function cargarAdmins() {
    $.ajax({
        url: SERVER_NAME + "AJAX/ajax.php",
        method: "POST",
        dataType: "json",
        data: { metodo: "listarAdministradores" },
        success: function(data) {
            let tabla = $("#tablaAdmins tbody");
            tabla.empty();

            data.forEach(admin => {
                let estadoBadge = admin.admin_estado == 1 
                    ? `<span class="badge bg-success">Activo</span>` 
                    : `<span class="badge bg-danger">Inactivo</span>`;
            
                let fila = `
                    <tr>
                        <td>${admin.admin_id}</td>
                        <td>${admin.admin_user}</td>
                        <td>${admin.admin_nombre} ${admin.admin_apellido}</td>
                        <td>${estadoBadge}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEditarAdmin" data-userName = "${admin.admin_user}" data-nombreAdmin="${admin.admin_nombre}" data-apellidoAdmin="${admin.admin_apellido}" data-administrador ="${admin.admin_nombre} ${admin.admin_apellido}" data-idAdmin="${admin.admin_id}">Editar</button>
                            ${admin.admin_estado !== 0 ? `<button class="btn btn-danger btn-sm btnEliminarAdmin" data-userName = "${admin.admin_user}" data-nombreAdmin="${admin.admin_nombre}" data-apellidoAdmin="${admin.admin_apellido}" data-administrador ="${admin.admin_nombre} ${admin.admin_apellido}" data-idAdmin="${admin.admin_id}">Eliminar</button>` : ""}
                        </td>
                    </tr>
                `;
            
                tabla.append(fila);
            });
            
        },
        error: function(xhr, status, error) {
            console.error("Error en AJAX:", error);
            alert("Error al cargar los pedidos.");
        }
    });
}


// Delegación de eventos para evitar duplicaciones
$(document).on("click", ".btnEditarAdmin", function() {
    let id = $(this).attr("data-idAdmin");
    let nombre = encodeURIComponent($(this).attr("data-nombreAdmin"));
    let apellido = encodeURIComponent($(this).attr("data-apellidoAdmin"));
    let username = encodeURIComponent($(this).attr("data-userName"));

    // Redirecciona a la interfaz para editar con parámetros seguros
    window.location.href = SERVER_NAME + `admin_editar.php?id=${id}&nombre=${nombre}&apellido=${apellido}&username=${username}`;
});


$(document).on("click", ".btnEliminarAdmin", function() {
    let id = $(this).attr("data-idAdmin");
    let nombre = $(this).attr("data-administrador");
  
    Swal.fire({
        title: `¿Está seguro de inactivar al administrador: ${nombre}?`,
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "OK",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarAdmin(id);
        }
    });
});


//Eliminar Pedido con AJAX
function eliminarAdmin(idAdmin){
    $.ajax({
        url: SERVER_NAME + "AJAX/ajax.php",
        method: "POST",
        dataType: "json",
        data: {
            metodo: "eliminarAdmin",
            idAdminEliminar: idAdmin,
        },
        success: function(data) {
            Swal.fire(
                "Cancelado",
                `El administrador con ID ${idAdmin} ha sido inactivado.`,
                "success"
            );
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error en AJAX:", error);
            alert("Error al cargar los pedidos.");
        }
    });
}