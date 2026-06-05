<?php
session_start();
require_once 'classes/SegurancaHeaders.php';
require_once 'classes/Usuario.php';

SegurancaHeaders::configSessionSecurity();
session_start();
SegurancaHeaders::setHeaders();

$usuario = new Usuario();
$usuarioSelecionado = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    // Buscar os dados do usuário para edição
    $usuarioSelecionado = $usuario->buscarUsuario($_GET['id']);
    if (!$usuarioSelecionado) {
        die("Usuário não encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenRecebido = $_POST['csrf_token'] ?? '';

    if (!SegurancaHeaders::validarTokenCsrf($tokenRecebido)) {
        die('Ação bloqueada: token de segurança inválido.');
    }

    $id    = (int) $_POST['id'];
    $nome  = SegurancaHeaders::sanitizar($_POST['nome']);
    $email = SegurancaHeaders::sanitizar($_POST['email']);

    // Atualizar os dados do usuário
    $usuario->atualizarUsuario($_POST['id'], $_POST['nome'], $_POST['email']);
    header('Location: usuarios.php');
    exit;
}

    $csrfToken = SegurancaHeaders::gerarTokenCsrf();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Início</a></li>
                <li><a href="compras.php">Cadastrar Compras</a></li>
                <li><a href="dividendos.php">Cadastrar Dividendos</a></li>
                <li><a href="relatorio.php">Relatório</a></li>
                <li><a href="usuarios.php">Gerenciar Usuários</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="POST">
            <h1>Editar Usuário</h1>
            <form method="POST">
              <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
              <input type="hidden" name="id" value="<?= (int)htmlspecialchars($usuarioSelecionado['id']) ?>">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?= SegurancaHeaders::sanitizar($usuarioSelecionado['nome']) ?>" required><br>
         
            <label>Email:</label>
            <input type="email" name="email" value="<?= SegurancaHeaders::sanitizar($usuarioSelecionado['email']) ?>" required>


            <button type="submit">Salvar Alterações</button>
        </form>
    </main>
</body>
</html>
