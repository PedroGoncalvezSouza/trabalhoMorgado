<?php

require_once 'Database.php';

class Ativo {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function calcularPrecoMedio() {
        $sql = "SELECT ativo, SUM(quantidade) AS total_quantidade,
                       SUM(quantidade * valor_unitario) AS total_valor
                FROM compras
                GROUP BY ativo";
        $stmt = $this->db->query($sql);
        $ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($ativos as &$ativo) {
            $ativo['preco_medio'] = $ativo['total_valor'] / $ativo['total_quantidade'];
        }
        return $ativos;
    }
}
?>