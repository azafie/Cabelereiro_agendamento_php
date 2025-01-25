<?php
$host = "localhost"; // Ou 127.0.0.1
$usuario = "emerson";
$senha = "41512212";
$banco = "agendamentos";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Para usar UTF-8 (recomendado)
$conexao->set_charset("utf8");
?>