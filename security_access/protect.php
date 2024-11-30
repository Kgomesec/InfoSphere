<?php
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    if (strpos($_SERVER['REQUEST_URI'], '') !== false) {
        die("Você precisa estar logado para...<p><a href=\"/login\">Entrar | Cadastrar-se</a></p>");
        exit;
    }

    die("Você precisa estar logado para acessar esta página.<p><a href=\"login/\">Entrar | Cadastrar-se</a></p>");
}
?>