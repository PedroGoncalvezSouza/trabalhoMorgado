<?php

    require_once 'classes/SegurancaHeaders.php';
    require_once 'classes/Usuario.php';

    SegurancaHeaders::configSessionSecurity();
    session_start();
    SegurancaHeaders::setHeaders();

    $erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Validar o token CSRF antes de processar qualquer dado e se não bater, rejeitamos a requisição 
    $tokenRecebido = $_POST['csrf_token'] ?? '';

    if (!SegurancaHeaders::validarTokenCsrf($tokenRecebido)) {
        // Se houver ataque CSRF, rejeitamos imediatamente sem dar detalhes
        $erro = 'Requisição inválida. Recarregue a página e tente novamente.';
    } else {

    $usuario = new Usuario();
    $login = $usuario->validarLogin($_POST['email'], $_POST['senha']);

    if ($login) {

    session_regenerate_id(true); // Regenera o ID da sessão para evitar fixação de sessão

        $_SESSION['usuario'] = $login;
        header('Location: index.php');
        exit;
    } else {
        $erro = "Credenciais inválidas!";
       }
   }
}
$csrfToken = SegurancaHeaders::gerarTokenCsrf();
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

    <?php if ($erro): ?>
        <!-- Usamos sanitizar() para exibir a mensagem de erro com segurança -->
        <p style="color:red;"><?= SegurancaHeaders::sanitizar($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <!-- Todo formulario é obrigado ter um token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="registro.php">Registrar-se</a></p>
</body>
</html>