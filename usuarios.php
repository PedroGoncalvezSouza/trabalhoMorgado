<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'classes/Usuario.php';

$usuario = new Usuario();

// Operações de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['excluir'])) {
        $usuario->excluirUsuario($_POST['id']);
    }
}

$usuarios = $usuario->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
        <h1>Gerenciar Usuários</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['nome'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                            <button type="submit" name="excluir">Excluir</button>
                        </form>
                        <form method="GET" action="editar_usuario.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
