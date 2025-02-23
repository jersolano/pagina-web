$(document).ready(function () {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    cargarCartaMenu();


    $("#continuar-pedido").click(function () {
        if (carrito.length === 0) {
            alert("El carrito está vacío.");
        }else{
            window.location.href = SERVER_NAME + "mi_pedido.php";
        }
    
        
});

function cargarCartaMenu() {
    return $.ajax({
        type: "POST",
        url: SERVER_NAME + "AJAX/ajax.php",
        data: { metodo: "listarProductos" },
        dataType: "json",
        success: function (response) {
            console.log("Respuesta del servidor:", response);
            actualizarCartaMenu(response);
            funcionalidadCarrito(); // Ahora se llama después de cargar los productos
        }
    });
}

function actualizarCartaMenu(productos) {
    let seccionPollos = $("#cartaMenuSeccion_pollos").html(`<h2 class="text-center mb-3 fw-bold">Pollo a la Brasa</h2>`);
    let seccionAcompanamiento = $("#cartaMenuSeccion_acompanamientos").html(`<h2 class="text-center mb-3 fw-bold">Acompañamientos</h2>`);
    let seccionBrosters = $("#cartaMenuSeccion_broasters").html(`<h2 class="text-center mb-3 fw-bold">Broasters</h2>`);

    // Obtener carrito almacenado en localStorage
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    productos.forEach(producto => {
        let stockID = `stock-${producto.producto_id}`;
        let stockDisponible = producto.cantidad;

        // Ajustar stock según los productos en el carrito
        let productoEnCarrito = carrito.find(p => p.id === producto.producto_id);
        if (productoEnCarrito) {
            stockDisponible -= productoEnCarrito.cantidad;
        }

        let elementoHTML = `
            <div class="menu-item d-flex align-items-center border rounded p-3 mb-2 bg-light">
                <img src="assets/img/${producto.nombre_imagen}" alt="${producto.nombre_producto}" class="img-fluid rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                
                <p class="mb-0 flex-grow-1">
                    <span class="text-dark fw-bold">${producto.nombre_producto}</span><br>
                    <strong class="text-dark">S/ ${producto.precio}</strong> <br>
                    <small class="text-secondary">SKU: 000${producto.producto_id}</small> |
                    <small class="text-secondary">Stock: <span id="${stockID}">${stockDisponible}</span></small>
                </p>

                <button class="agregar" 
                        data-nombre="${producto.nombre_producto}" 
                        data-precio="${producto.precio}" 
                        data-id="${producto.producto_id}"
                        data-stock="${stockDisponible}"
                        ${stockDisponible === 0 ? "disabled" : ""}>
                    <i class="fas fa-cart-plus"></i> Agregar
                </button>
            </div>`;

        switch (producto.categoria) {
            case "Pollo a la Brasa":
                seccionPollos.append(elementoHTML);
                break;
            case "Acompañamientos":
                seccionAcompanamiento.append(elementoHTML);
                break;
            case "Pollo Broster":
                seccionBrosters.append(elementoHTML);
                break;
            default:
                console.log("Categoría no reconocida:", producto.categoria);
                break;
        }
    });
}

function funcionalidadCarrito() {
    console.log("Script de carrito funcionando");
    let total = 0;

    if (carrito.length > 0) {
        actualizarCarrito();
    }

    // Agregar producto al carrito con validación de stock
    $(document).on("click", ".agregar", function () {
        let boton = $(this);
        let nombre = boton.data("nombre");
        let precio = parseFloat(boton.data("precio"));
        let id = boton.data("id");
        let stockElemento = $(`#stock-${id}`);
        let stockActual = parseInt(stockElemento.text());

        if (stockActual > 0) {
            stockActual--;
            stockElemento.text(stockActual);

            // Agregar al carrito
            let productoExistente = carrito.find(p => p.id === id);
            if (productoExistente) {
                productoExistente.cantidad++;
            } else {
                carrito.push({ nombre, precio, cantidad: 1, id });
            }

            guardarCarrito();
            actualizarCarrito();

            // Si el stock llega a 0, deshabilitar botón
            if (stockActual === 0) {
                boton.prop("disabled", true).text("Agotado");
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stock insuficiente',
                text: 'No hay más unidades disponibles de: ' + nombre,
                confirmButtonText: 'Entendido',
                timer: 3000,
                timerProgressBar: true
            });
        }
    });

    function guardarCarrito() {
        localStorage.setItem("carrito", JSON.stringify(carrito));
    }

    function actualizarCarrito() {
        let listaCarrito = $("#lista-carrito");
        let totalElemento = $("#total");

        listaCarrito.empty();
        total = 0;

        carrito.forEach((producto, index) => {
            total += producto.precio * producto.cantidad;
            listaCarrito.append(`
                <li class="d-flex justify-content-center align-items-center gap-1">
                    <div> <p class="text-dark fw-bold mb-0">${producto.nombre} - S/ ${producto.precio.toFixed(2)}</p> </div>
                    <div> <span class="badge bg-primary mb-1">${producto.cantidad}</span> </div>
                    <div> <button class="btn btn-sm btn-danger eliminar fw-bold" data-index="${index}" data-id="${producto.id}">X</button> </div>
                </li>
            `);
        });

        totalElemento.text(`S/ ${total.toFixed(2)}`);
        $("#carrito").toggle(carrito.length > 0);
    }

    // Eliminar producto y aumentar stock
    $(document).on("click", ".eliminar", function () {
        let index = $(this).data("index");
        let id = $(this).data("id");
        let stockElemento = $(`#stock-${id}`);

        let productoEliminado = carrito[index];
        let stockActual = parseInt(stockElemento.text()) + productoEliminado.cantidad;
        stockElemento.text(stockActual);

        let botonAgregar = $(`button[data-id='${id}']`);
        botonAgregar.prop("disabled", false).text("Agregar");

        carrito.splice(index, 1);
        guardarCarrito();
        actualizarCarrito();
    });
}



});