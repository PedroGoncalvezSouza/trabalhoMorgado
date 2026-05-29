<?php

class Database {
    private $host = 'localhost';
    private $port = '3306'; // Porta do banco de dados
    private $db = 'bolsa_de_valores';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    public function connect() {
        if (!$this->pdo) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db}";
                $this->pdo = new PDO($dsn, $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
?>
