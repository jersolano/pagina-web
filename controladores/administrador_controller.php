<?php
class AdministradorController extends MainController
{

    public static function listarAdministradores()
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Consulta SQL para obtener los pedidos con productos
            $stmt = $conn->prepare("
               SELECT admin_id, admin_nombre, admin_apellido , admin_user, admin_estado FROM admins
            ");
            $stmt->execute();

            // Obtener los resultados
            $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // 🔴 Liberar el resultado pendiente

            if (!$administradores) {
                throw new Exception("No se encontraron Administradores.");
            }

            return json_encode($administradores); // Devuelvo los pedidos como JSON
        } catch (Exception $e) {
            return json_encode(["status" => "error", "message" => "Error al listar los pedidos: " . $e->getMessage()]);
        }
    }

    public static function registrarAdministrador($nombre, $apellido, $usuario, $password)
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // ⚠️ Iniciar transacción si no está activa
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            // Llamar al procedimiento almacenado
            $stmt = $conn->prepare("CALL sp_CrearAdmin(?, ?, ?, ?, ?)");
            $estado = 1; // Asumiendo que siempre se crea activo
            $stmt->execute([$nombre, $apellido, $usuario, $password, $estado]);

            // 🔴 Liberar el resultado pendiente
            $stmt->closeCursor();

            // 🔹 Obtener el último ID insertado
            $stmt = $conn->query("SELECT LAST_INSERT_ID() AS admin_id");
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$admin || !isset($admin["admin_id"])) {
                throw new Exception("Error al obtener el ID del administrador.");
            }

            $adminId = $admin["admin_id"];

            // Confirmar la transacción
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Administrador registrado con éxito", "admin_id" => $adminId]);
        } catch (Exception $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return json_encode(["status" => "error", "message" => "Error al registrar el administrador: " . $e->getMessage()]);
        }
    }

    public static function editarAdministrador($id, $nombre, $apellido, $usuario)
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Validar que los parámetros no estén vacíos
            if (empty($id) || empty($nombre) || empty($apellido) || empty($usuario)) {
                throw new Exception("Todos los campos son obligatorios.");
            }

            // Iniciar transacción si no está activa
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            // Preparar la llamada al procedimiento almacenado
            $stmt = $conn->prepare("CALL sp_EditarAdmin(?, ?, ?, ?)");

            // Ejecutar la consulta
            if (!$stmt->execute([$id, $nombre, $apellido, $usuario])) {
                throw new Exception("Error al ejecutar la consulta.");
            }

            // Liberar el resultado pendiente
            $stmt->closeCursor();

            // Confirmar la transacción si todo está bien
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Administrador editado con éxito"]);
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }

            return json_encode(["status" => "error", "message" => "Error al editar el administrador: " . $e->getMessage()]);
        }
    }


    //Función para eliminar un pedido
    public static function eliminarAdministrador($idAdmin)
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
            $stmt = $conn->prepare("CALL EliminarAdmin(?)");
            $stmt->execute([$idAdmin]);
            $stmt->closeCursor(); // 🔴 Liberar resultado pendiente

            // Confirmar la transacción si sigue activa
            if ($conn->inTransaction()) {
                $conn->commit();
            }

            return json_encode(["status" => "success", "message" => "Administrador inactivado con éxito"]);
        } catch (Exception $e) {
            // ⚠️ Verificar si hay una transacción antes de hacer rollback
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return json_encode(["status" => "error", "message" => "Error al inactivar el administrador: " . $e->getMessage()]);
        }
    }

    public static function iniciarSesion($usuario, $password)
    {
        try {
            $conn = self::getConnection();
            if (!$conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }

            // Llamar al procedimiento almacenado para verificar credenciales
            $stmt = $conn->prepare("CALL sp_VerificarAdmin(?,?)");
            $stmt->execute([$usuario, $password]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el usuario existe
            if (!$admin) {
                throw new Exception("Usuario no encontrado.");
            }

            // Iniciar sesión
            session_start();
            $_SESSION["admin_id"] = $admin["admin_id"];
            $_SESSION["admin_user"] = $admin["admin_user"];

            return json_encode([
                "status" => "success",
                "message" => "Inicio de sesión exitoso",
                "admin_id" => $admin["admin_id"],
                "admin_user" => $admin["admin_user"]
            ]);
        } catch (Exception $e) {
            return json_encode([
                "status" => "error",
                "message" => "Error al iniciar sesión: " . $e->getMessage()
            ]);
        }
    }

    public static function cerrarSesion()
    {
        session_start();

        // Verifica si hay una sesión activa
        if (isset($_SESSION["admin_id"])) {
            session_unset(); // Elimina todas las variables de sesión
            session_destroy(); // Destruye la sesión

            echo json_encode(["status" => "success", "message" => "Sesión cerrada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay una sesión activa."]);
        }
        exit;
    }
}
