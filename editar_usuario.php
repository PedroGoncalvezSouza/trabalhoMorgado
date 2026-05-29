<?php
session_start();
require_once 'classes/Usuario.php';

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Buscar os dados do usuário para edição
    $usuarioSelecionado = $usuario->buscarUsuario($_GET['id']);
    if (!$usuarioSelecionado) {
        die("Usuário não encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar os dados do usuário
    $usuario->atualizarUsuario($_POST['id'], $_POST['nome'], $_POST['email']);
    header('Location: usuarios.php');
    exit;
}
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
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuarioSelecionado['id']) ?>">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuarioSelecionado['nome']) ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuarioSelecionado['email']) ?>" required>
            <button type="submit">Salvar Alterações</button>
        </form>
    </main>
</body>
</html>
