<?php
require_once "main_controller.php";

class DashboardController extends MainController
{
    // Función para obtener información relevante en formato JSON
    public static function obtenerJSONInformacionRelevante()
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Llamar al procedimiento almacenado
            $stmt = $conn->prepare("CALL ObtenerInformacionRelevanteJSON()");
            $stmt->execute();

            // Obtener el resultado del procedimiento
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // 🔴 Liberar el resultado pendiente

            if (!$resultado) {
                throw new Exception("No se pudo obtener la información relevante.");
            }

            return json_encode($resultado["resultado_json"]); // Devuelvo la información en formato JSON
        } catch (Exception $e) {
            return json_encode(["status" => "error", "message" => "Error al obtener la información: " . $e->getMessage()]);
        }
    }
}
