<?php

$host = 'localhost:3308';
$username = 'root';
$password = '';
$database = 'infosphere';

$mysqli = new mysqli($host, $username, $password, $database);

if($mysqli->error) {
    die("Falha ao conectar com o banco de dados: " . $mysqli->error);
}

?>