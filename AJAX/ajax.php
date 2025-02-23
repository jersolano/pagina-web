<?php
header("Content-Type: application/json"); // Asegura que la respuesta sea JSON
require_once("../controladores/pedidos_controller.php");
require_once("../controladores/productos_controller.php");
require_once("../controladores/dashboard_controller.php");
require_once("../controladores/administrador_controller.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $metodo = $_POST["metodo"] ?? "";

    switch ($metodo) {
        case "registrarPedido":
            if (!isset($_POST["carrito"])) {
                echo json_encode(["status" => "error", "message" => "Carrito no recibido"]);
                exit;
            }

            // Decodificar JSON recibido del carrito
            $carrito = json_decode($_POST["carrito"], true);
            if (!$carrito) {
                echo json_encode(["status" => "error", "message" => "Formato de carrito inválido"]);
                exit;
            }

            // Obtener los demás datos del pedido
            $nombreCliente  = $_POST["nombreCliente"] ?? "";
            $dni  = $_POST["dni"] ?? "00000000";
            $celularCliente = $_POST["celular"] ?? "";
            $direccion      = $_POST["direccion"] ?? "";
            $horaRecojo     = $_POST["horaRecojo"] ?? null;
            $montoTotal     = $_POST["total"] ?? 0;
            $tipo           = $_POST["tipoPedido"]; // Puedes cambiar esto según la lógica de tu app
            $fecha          = date("Y-m-d"); // Fecha actual
            $estado         = 1; // Estado inicial del pedido

            // Llamar al controlador Pedidos / registrar pedido
            echo PedidosController::registrarPedido($dni, $nombreCliente, $celularCliente, $direccion, $montoTotal, $tipo, $horaRecojo, $fecha, $estado, $carrito);
            break;
        case "confirmarPago":
            // Verificar si los datos están presentes y no están vacíos
            if (
                empty($_POST["operacion"]) ||
                empty($_POST["pedido_id"]) ||
                empty($_POST["total"]) ||
                empty($_POST["monto"])
            ) {
                echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
                exit;
            }

            // Sanitizar y convertir datos
            $pedidoId = intval($_POST["pedido_id"]);
            $montoPagado = floatval($_POST["monto"]);
            $total = floatval($_POST["total"]);
            $operacion = trim($_POST["operacion"]);
            $metodoPago = "Yape"; // Método fijo

            // Validar que el monto pagado sea suficiente
            if ($montoPagado < $total) {
                echo json_encode(["status" => "error", "message" => "El monto pagado es menor al total"]);
                exit;
            }

            // Llamar al método para registrar el pago
            $respuesta = PedidosController::registrarPago($pedidoId, $montoPagado, $metodoPago, $operacion);
            echo $respuesta;
            break;

        case "listarPedidosAdmin":
            // Llamar al método para listar los pedidos
            echo PedidosController::listarPedidosAdmin();
            break;
        case "listarProductos":
            echo ProductosController::listarPedidosAdmin();
            break;
        case "getJSONInformacionRelevante":
            echo DashboardController::obtenerJSONInformacionRelevante();
            break;
        case "registrarAdmin":
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $nombre = $_POST["admin_nombre"] ?? null;
                $apellido = $_POST["admin_apelldio"] ?? null; // Cuidado con el error de escritura en 'apellido'
                $usuario = $_POST["admin_user"] ?? null;
                $password = $_POST["admin_password"] ?? null;

                // Verificar si los campos obligatorios están llenos
                if (empty($nombre) || empty($usuario) || empty($password)) {
                    echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                    exit;
                }

                // Llamar al método del controlador
                echo AdministradorController::registrarAdministrador($nombre, $apellido, $usuario, $password);
            } else {
                echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            }
            break;
        case "validarLoginAdministrador":
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $usuario = $_POST["usuario"] ?? null;
                $password = $_POST["password"] ?? null;

                if ($usuario && $password) {
                    echo AdministradorController::iniciarSesion($usuario, $password);
                } else {
                    echo json_encode(["status" => "error", "message" => "Faltan datos en la solicitud"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            }
            break;
        case "cerrarSesion":
            echo AdministradorController::cerrarSesion();
            break;
        case "eliminarPedidoAdmin":
            echo PedidosController::eliminarPedido($_POST["idPedidoEliminar"]);
            break;
        case "eliminarAdmin":
            echo AdministradorController::eliminarAdministrador($_POST["idAdminEliminar"]);
            break;
        case "listarAdministradores":
            // Llamar al método para listar los administradores
            echo AdministradorController::listarAdministradores();
            break;
        case "editarAdmin":
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $id = $_POST["admin_id"] ?? null;
                $nombre = $_POST["admin_nombre"] ?? null;
                $apellido = $_POST["admin_apellido"] ?? null; // Cuidado con el error de escritura en 'apellido'
                $usuario = $_POST["admin_user"] ?? null;

                // Verificar si los campos obligatorios están llenos
                if (empty($nombre) || empty($usuario) || empty($id)) {
                    echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
                    exit;
                }

                // Llamar al método del controlador
                echo AdministradorController::editarAdministrador($id, $nombre, $apellido, $usuario);
            } else {
                echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            }
            break;
        default:
            echo json_encode(["status" => "error", "message" => "Método no válido"]);
            break;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
