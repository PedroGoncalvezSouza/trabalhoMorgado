<?php
    require_once 'classes/SegurancaHeaders.php';
    require_once "classes/Usuario.php";

    SegurancaHeaders::configSessionSecurity();
    session_start();
    SegurancaHeaders::setHeaders();

     $erro = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $tokenRecebido = $_POST['csrf_token'] ?? '';

        if (!SegurancaHeaders::validarTokenCsrf($tokenRecebido)) {
            $erro = 'Requisição inválida. Tente novamente.';
        } else {
            $nome = SegurancaHeaders::sanitizar($_POST['nome']);
            $email = SegurancaHeaders::sanitizar($_POST['email']);  
            $senha = $_POST['senha']; // Senha não sanitiza aqui, vai direto pro hash 
        




        $usuario = new Usuario();
        $usuario->criarUsuario($nome, $email, $senha);
        header('Location: login.php');
        exit;
      }
    }
    
    $csrfToken = SegurancaHeaders::gerarTokenCsrf();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Registrar usuário</h1>

    <?php if ($erro): ?>
        <p style="color:red;"><?= SegurancaHeaders::sanitizar($erro) ?></p>
    <?php endif; ?>


    <form method="POST">
        <!-- Todo formulario é obrigado ter um token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
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