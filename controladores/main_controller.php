<?php
require_once "../config/CONFIG.php"; // Asegúrate de que la ruta es correcta

class MainController
{
    private static $conn = null;

    private static function connect()
    {
        if (!self::$conn) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]));
            }
        }
        return self::$conn;
    }

    protected static function getConnection()
    {
        return self::connect();
    }

    public static function query($sql, $params = [])
    {
        try {
            $stmt = self::getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "Error en la consulta: " . $e->getMessage()];
        }
    }

    public static function disconnect()
    {
        self::$conn = null;
    }
}
