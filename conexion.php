<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'noxtbee';
    private $username = 'root';
    private $password = '';
    public $pdo;

    public function connect() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
        return $this->pdo;
    }
    public function select() {

        $stmt = $this->pdo->prepare('SELECT * FROM roles');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
