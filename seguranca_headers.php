<?php

class SegurancaHeaders {

    public static function setHeaders() {
        
        //Definir o cabeçalho de segurança

        // Política de Segurança de Conteúdo — permite Chart.js do CDN no relatorio.php
        // 'self' = apenas do próprio servidor
        // cdn.jsdelivr.net = necessário para o Chart.js
        header("Content-Security-Policy: " ."default-src 'self'; " ."script-src 'self' https://cdn.jsdelivr.net; " ."style-src 'self'; " ."img-src 'self' data:; " ."font-src 'self'; " ."frame-ancestors 'none';"); //Evita que o navegador adivinhe o tipo de conteúdo
        header('X-Frame-Options: DENY');// Bloqueia a página em iframes de outros domínios (anti-clickjacking)
        header('Referrer-Policy: no-referrer-when-downgrade');// Não envia a URL de origem ao acessar links externos
        header('X-Powered-By'); // Remove o header que revela que o servidor usa PHP (informação desnecessária para invasores)
    }


public static function configSessionSecurity(): void { //sempre chamar antes da session_start()!!!!!

    session_set_cookie_params([
        'lifetime' => 0, //Duração do cookie quando a aba é fechada, no caso é zero pra fechar quando a aba for fechada
        'path' => '/', //Caminho por onde o cookie é válido. 
        'httponly' => true, //Bloqueia os acessos via JS, fica "invisível"
        'secure' => true, //O cookie só envia conexões HTTPS
        'samesite' => 'Strict' //Proteção contra CSRF, o cookie envia e recebe requisições para o mesmo site
    ]);
}

public static function gerarTokenCsrf(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Gerar um token CSRF único para a sessão, se já existir um, ele apenas não cria outro
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // ramdom_bytes(32) - gera 32 bytes aleatórios criptografados 
    }                                                        // bin2hex() - faz a conversão desses bytes em uma string hexadecimal legível
    return $_SESSION['csrf_token'];

}

public static function validarTokenCsrf(string $tokenRecebido): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token']))) {
        return false; // Token inválido ou ausente
    }
    return hash_equals($_SESSION['csrf_token'], $tokenRecebido);

    public static function sanatizar(string $dados): string {
        return htmlspecialchars(trim ($dado), ENT_QUOTES, ENT_HTML5, 'UTF-8'); // Converte caracteres especiais em entidades HTML
    }

}


