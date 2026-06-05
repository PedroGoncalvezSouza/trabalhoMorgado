<?php
    require_once 'classes/SegurancaHeaders.php';
    require_once 'classes/Compra.php';

    SegurancaHeaders::configSessionSecurity();
    session_start();
    SegurancaHeaders::setHeaders();

        // Verificar se o usuário está logado   
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit;
    }

    $mensagem = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tokenRecebido = $_POST['csrf_token'] ?? '';

    if (!SegurancaHeaders::validarTokenCsrf($tokenRecebido)) {
        $mensagem = 'Erro: requisição inválida (token CSRF ausente ou incorreto).';
    } else {
        // Sanitiza o campo de texto; valores numéricos são convertidos diretamente
        $ativo          = SegurancaHeaders::sanitizar($_POST['ativo']);
        $quantidade     = (int) $_POST['quantidade'];
        $valorUnitario  = (float) $_POST['valor_unitario'];
        $dataCompra     = SegurancaHeaders::sanitizar($_POST['data_compra']);

        $compra = new Compra();
        $compra->adicionarCompra($ativo, $quantidade, $valorUnitario, $dataCompra);
        $mensagem = 'Compra adicionada com sucesso!';
    }
}

$csrfToken = SegurancaHeaders::gerarTokenCsrf();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Compra</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Cadastrar Compra</h1>
    <?php if ($mensagem): ?>
        <p style="color:green;"><?= SegurancaHeaders::sanitizar($mensagem) ?></p>
    <?php endif; ?>
    <form method="POST">
        <!-- Todo formulario é obrigado ter um token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
        <label>Ativo:</label>
        <input type="text" name="ativo" required><br>
        <label>Quantidade:</label>
        <input type="number" name="quantidade" required><br>
        <label>Valor Unitário:</label>
        <input type="number" step="0.01" name="valor_unitario" required><br>
        <label>Data da Compra:</label>
        <input type="date" name="data_compra" required><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>