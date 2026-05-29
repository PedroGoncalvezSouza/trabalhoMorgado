<?php
require_once 'functions.php';
validarSessao();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestão de Ativos</title>
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
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <h1>Bem-vindo à Gestão de Ativos</h1>
            <p>Este sistema ajuda você a gerenciar seus investimentos em ativos e os dividendos recebidos. Use o menu acima para navegar pelas opções.</p>
            <div class="cards">
                <div class="card">
                    <h2>Total Investido</h2>
                    <p>(R$ 00,00)</p>
                </div>
                <div class="card">
                    <h2>Total de Dividendos</h2>
                    <p>R$ 00,00</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Gestão de Ativos. Todos os direitos reservados.</p>
    </footer>
</body>
</html>