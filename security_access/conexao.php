<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = '';

$mysqli = new mysqli($host, $username, $password, $database);

if($mysqli->error) {
    die("Falha ao conectar com o banco de dados: " . $mysqli->error);
}

?>