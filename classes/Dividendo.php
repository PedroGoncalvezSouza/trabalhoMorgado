<?php

require_once 'Database.php';

class Dividendo {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function adicionarDividendo($ativo, $valor, $dataRecebimento) {
        $sql = "INSERT INTO dividendos (ativo, valor, data_recebimento) VALUES (:ativo, :valor, :data_recebimento)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'ativo' => $ativo,
            'valor' => $valor,
            'data_recebimento' => $dataRecebimento
        ]);
    }

    public function listarDividendos() {
        $sql = "SELECT * FROM dividendos";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calcularDividendosPorAtivo() {
        $sql = "SELECT ativo, SUM(valor) AS total_dividendos FROM dividendos GROUP BY ativo";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
