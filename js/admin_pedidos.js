$(document).ready(function() {
    // Cargar pedidos al cargar la página
    cargarPedidos();
    asignarNombreUsuarioQueEntro();
});


// Cargar pedidos con AJAX
function cargarPedidos() {
    $.ajax({
        url: SERVER_NAME + "AJAX/ajax.php",
        method: "POST",
        dataType: "json",
        data: { metodo: "listarPedidosAdmin" },
        success: function(data) {
            let tabla = $("#tablaPedidos tbody");
            tabla.empty();

            data.forEach(pedido => {
                let fila = `
                            <tr>
                                <td>${pedido.pedido_id}</td>
                                <td>${pedido.nombre_cliente}</td>
                                <td>${pedido.tipo_pedido}</td>
                                <td>S/ ${pedido.monto_total}</td>
                                <td>${pedido.estado}</td>
                                <td>
                                    <button class="btn btn-success btn-sm btnVer" data-productos='${JSON.stringify(pedido.productos)}'>Ver</button>
                                    ${pedido.estado !== "CANCELADO" ? `<button class="btn btn-danger btn-sm btnEliminarPedido" data-idPedido="${pedido.pedido_id}">Eliminar</button>` : ""}
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
$(document).on("click", ".btnVer", function() {
    let productos = $(this).data("productos"); 
    console.log(productos);
    
    // Si `productos` es un array, lo formateamos para mostrarlo bien
    if (Array.isArray(productos)) {
        productos = productos.map(p => `- ${p}`).join("\n");
    }
    
    $("#productosPedido").text(productos);
    $("#modalPedido").modal("show");
});

$(document).on("click", ".btnEliminarPedido", function() {
    let id = $(this).attr("data-idPedido");
    
    Swal.fire({
        title: `¿Está seguro de cancelar el pedido con ID ${id}?`,
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "OK",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarPedido(id);
        }
    });
});


//Eliminar Pedido con AJAX
function eliminarPedido(idPedido){
    $.ajax({
        url: SERVER_NAME + "AJAX/ajax.php",
        method: "POST",
        dataType: "json",
        data: {
            metodo: "eliminarPedidoAdmin",
            idPedidoEliminar: idPedido,
        },
        success: function(data) {
            Swal.fire(
                "Cancelado",
                `El pedido con ID ${idPedido} ha sido cancelado.`,
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