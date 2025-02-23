$(() => {
    obtenerInformacionRelevanteDash();
    asignarNombreUsuarioQueEntro();
});

function obtenerInformacionRelevanteDash(){
    $.ajax({
        url: SERVER_NAME + "AJAX/ajax.php",
        type: "POST",
        data: { metodo: "getJSONInformacionRelevante" },
        dataType: "json", // Si el servidor devuelve JSON, no hace falta JSON.parse()
        success: function (response) {
            let infoRelevante = JSON.parse(response);
            console.log("Respuesta recibida:", infoRelevante);

            // Verifica que la respuesta tenga las claves esperadas
            if (infoRelevante && infoRelevante.totalMonto !== undefined) {
                $("#totalPedidos").text(infoRelevante.totalPedidos);
                $("#totalMonto").text(parseFloat(infoRelevante.totalMonto).toFixed(2)); // Asegura formato numérico
                $("#fechaActual").text(obtenerFechaActual);
                $("#adminsRegistrados").text(infoRelevante.adminsRegistrados);
                $("#clientesRegistrados").text(infoRelevante.clientesRegistrados);
            } else {
                console.error("Respuesta inválida:", infoRelevante);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
        }
});
}