<?php


//HttpOnly e cookies   
session_set_cookie_params([
    'lifetime' => 0, //Duração do cookie quando a aba é fechada
    'path' => '/', //Caminho por onde o cookie é válido. 
    'httponly' => true, //Bloqueia os acessos via JS, fica "invisível"
    'secure' => true, //O cookie só envia conexões HTTPS
    'samesite' => 'Strict' //Proteção contra CSRF, o cookie envia e recebe requisições para o mesmo site
    ]);

session_start();
require_once 'classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario();
    $login = $usuario->validarLogin($_POST['email'], $_POST['senha']);

    if ($login) {
        $_SESSION['usuario'] = $login;
        header('Location: index.php');
        exit;
    } else {
        $erro = "Credenciais inválidas!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <?php if (isset($erro)): ?>
        <p><?= $erro ?></p>
    <?php endif; ?>
</body>
</html>