<?php
include_once 'verifica_login.php';
include_once '../conexao.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $conexao->prepare("UPDATE agendamentos SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: index.php?page=lista_agendamentos"); // Redireciona de volta para a lista
        exit();
    } else {
        echo "Erro ao atualizar o status: " . $stmt->error;
    }

    $stmt->close();
}

$conexao->close();
?>