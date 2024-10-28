<?php
define('DB_HOST', 'localhost'); // YOUR DATABASE HOST
define('DB_NAME', 'product_registry'); // YOUR DATABASE NAME
define('DB_USER', 'root'); // YOUR DATABASE USER
define('DB_PASSWORD', 'alvaro'); // YOUR DATABASE PASSWORD

class Database {
    private $connection;

    public function getDbConnection() {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error de conexión: " . $e->getMessage()]);
            exit;
        }
    }

    public function closeConnection() {
        $this->connection = null;
    }
}
?>