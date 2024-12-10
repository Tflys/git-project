<?php

class Database {
    private $host = '127.0.0.1'; // Cambiar según tu entorno
    private $dbName = 'biblioteca'; // Nombre de la base de datos
    private $username = 'root'; // Usuario de la base de datos
    private $password = ''; // Contraseña del usuario
    private $port = '3306'; // Puerto de la base de datos
    private $charset = 'utf8mb4'; // Juego de caracteres
    private $pdo;

    /**
     * Conecta a la base de datos y devuelve una instancia PDO.
     *
     * @return PDO|null Retorna el objeto PDO o null en caso de error.
     */
    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};port={$this->port};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->pdo;
        } catch (PDOException $e) {
            // Manejo de errores en la conexión
            error_log("Error en la conexión a la base de datos: " . $e->getMessage());
            return null;
        }
    }
}
