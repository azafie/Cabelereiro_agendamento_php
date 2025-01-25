<?php
include '../conexao.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitiza o ID recebido

    $deleteQuery = "DELETE FROM agendamentos WHERE id = ?";
    $stmt = $conexao->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conexao->close();
} else {
    echo 'invalid_request';
}
?>
