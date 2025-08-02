<?php
class Model_DB {
    private $host = 'service_db';        // ← nombre del contenedor DB
    private $dbname = 'PatriaDB';        // ← nombre de la base de datos
    private $username = 'user';          // ← usuario
    private $password = 'password';      // ← contraseña

    public function connect() {
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", 
                            $this->username, 
                            $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
