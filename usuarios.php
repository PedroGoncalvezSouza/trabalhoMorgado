<?php

require_once 'classes/SegurancaHeaders.php';
require_once 'classes/Usuario.php';

SegurancaHeaders::configSessionSecurity(); 
session_start();
SegurancaHeaders::setHeaders(); 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenRecebido = $_POST['csrf_token'] ?? '';
    if (!SegurancaHeaders::validarTokenCsrf($tokenRecebido)) {
        die("Ação bloqueada: token de segurança inválido.");
    }

    if (isset($_POST['excluir'])) {
        $id = (int)$_POST['id']; 
        $usuario->excluirUsuario($id);
    }
}

$usuarios = $usuario->listarUsuarios();
$csrfToken = SegurancaHeaders::gerarTokenCsrf(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
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
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= SegurancaHeaders::sanitizar((string)$u['id']) ?></td>
                    <td><?= SegurancaHeaders::sanitizar($u['nome']) ?></td>
                    <td><?= SegurancaHeaders::sanitizar($u['email']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                            <button type="submit" name="excluir">Excluir</button>
                        </form>
                        <form method="GET" action="editar_usuario.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
