<?php
require_once "main_controller.php";

class ProductosController extends MainController
{


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
                    pr.producto_id,
                    pr.nombre_producto,
                    pr.descripcion,
                    pr.precio,
                    pr.categoria,
                    pr.nombre_imagen,
                    s.cantidad
                        FROM productos as pr
                        INNER JOIN stock as s
                        ON pr.producto_id = s.producto_id;
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
