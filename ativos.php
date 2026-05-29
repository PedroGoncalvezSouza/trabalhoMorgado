<?php
require_once 'classes/Ativo.php';

$ativo = new Ativo();
$relatorio = $ativo->calcularPrecoMedio();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Ativos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Relatório de Ativos</h1>
    <table border="1">
        <tr>
            <th>Ativo</th>
            <th>Total Comprado</th>
            <th>Preço Médio</th>
        </tr>
        <?php foreach ($relatorio as $linha): ?>
            <tr>
                <td><?= $linha['ativo'] ?></td>
                <td><?= $linha['total_quantidade'] ?></td>
                <td><?= number_format($linha['preco_medio'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>