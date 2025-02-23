<?php
require_once "main_controller.php";

class PedidosController extends MainController
{
    public static function registrarPedido($dni, $nombreCliente, $celularCliente, $direccionCliente, $montoTotal, $tipo, $hora, $fecha, $estado, $carrito)
    {
        if (empty($carrito)) {
            return json_encode(["status" => "error", "message" => "El carrito está vacío"]);
        }

        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // ⚠️ Verificar si ya hay una transacción activa antes de iniciarla
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            // Llamar al procedimiento almacenado para registrar el pedido
            $stmt = $conn->prepare("CALL InsertarPedido(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$dni, $nombreCliente, $celularCliente, $direccionCliente, $montoTotal, $tipo, $hora, $fecha, $estado]);

            // Obtener el ID del pedido
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // 🔴 IMPORTANTE: Liberar el resultado pendiente

            if (!$pedido || !isset($pedido["pedido_id"])) {
                throw new Exception("Error al obtener el ID del pedido.");
            }
            $pedidoId = $pedido["pedido_id"];

            // Insertar los productos del carrito
            foreach ($carrito as $producto) {
                $stmt = $conn->prepare("CALL InsertarProductoPedido(?, ?, ?, ?)");
                $stmt->execute([$producto["id"], $pedidoId, $producto["cantidad"], $producto["precio"]]);
                $stmt->closeCursor(); // 🔴 Liberar el resultado después de cada ejecución
            }

            // Confirmar la transacción solo si está activa
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Pedido registrado con éxito", "pedido_id" => $pedidoId]);
        } catch (Exception $e) {
            // ⚠️ Verificar si hay una transacción antes de hacer rollback
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return json_encode(["status" => "error", "message" => "Error al registrar el pedido: " . $e->getMessage()]);
        }
    }


    public static function registrarPago($idPedido, $montoPagado, $metodoPago, $operacion)
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Iniciar transacción solo si no hay una activa
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            // Llamar al procedimiento almacenado para registrar el pago
            $stmt = $conn->prepare("CALL RegistrarPago(?, ?, ?, ?)");
            $stmt->execute([$idPedido, $montoPagado, $metodoPago, $operacion]);
            $stmt->closeCursor(); // 🔴 Liberar resultado pendiente

            // Confirmar la transacción si sigue activa
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Pago registrado con éxito"]);
        } catch (Exception $e) {
            // Hacer rollback si hay una transacción activa
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return json_encode(["status" => "error", "message" => "Error al registrar el pago: " . $e->getMessage()]);
        }
    }

    //Función para eliminar un pedido
    public static function eliminarPedido($idPedido)
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Iniciar transacción solo si no hay una activa
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            // Llamar al procedimiento almacenado para registrar el pago
            $stmt = $conn->prepare("CALL EliminarPedido(?)");
            $stmt->execute([$idPedido]);
            $stmt->closeCursor(); // 🔴 Liberar resultado pendiente

            // Confirmar la transacción si sigue activa
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Pago cancelado con éxito"]);
        } catch (Exception $e) {
            // ⚠️ Verificar si hay una transacción antes de hacer rollback
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return json_encode(["status" => "error", "message" => "Error al eliminar el pedido: " . $e->getMessage()]);
        }
    }

    // Función para listar los pedidos con productos asociados
    public static function listarPedidosAdmin()
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Consulta SQL para obtener los pedidos con productos
            $stmt = $conn->prepare("
               SELECT 
                    p.pedido_id,
                    p.cliente_id,
                    cl.nombre_cliente,
                    tp.tipo AS tipo_pedido,
                    p.monto_total,
                    ep.estado,
                    GROUP_CONCAT(CONCAT(prod.nombre_producto, ' (', pp.cantidad, ' x ', pp.monto, ')') SEPARATOR ', ') AS productos
                FROM pedidos p
                JOIN clientes as cl on cl.cliente_id = p.cliente_id
                JOIN tipo_pedido tp ON p.tipo = tp.tipo_pedido_id
                JOIN estado_pedido ep ON p.estado = ep.estado_pedido_id
                LEFT JOIN productoPedido pp ON p.pedido_id = pp.pedido_id
                LEFT JOIN productos prod ON pp.producto_id = prod.producto_id
                GROUP BY p.pedido_id
            ");
            $stmt->execute();

            // Obtener los resultados
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // 🔴 Liberar el resultado pendiente

            if (!$pedidos) {
                throw new Exception("No se encontraron pedidos.");
            }

            return json_encode($pedidos); // Devuelvo los pedidos como JSON
        } catch (Exception $e) {
            return json_encode(["status" => "error", "message" => "Error al listar los pedidos: " . $e->getMessage()]);
        }
    }
}
