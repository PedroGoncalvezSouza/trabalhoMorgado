<?php
    require_once "classes/Usuario.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario = new Usuario();
        $usuario->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);
        header('Location: login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>
    <h1>Registrar usuário</h1>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>