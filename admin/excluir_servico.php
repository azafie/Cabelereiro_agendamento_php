<?php
require_once '../conexao.php'; // Incluindo o arquivo de conexão

// Verifica se o ID foi passado e é válido
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int) $_POST['id'];

    // Tentando excluir o serviço
    $sql = "DELETE FROM servicos WHERE id = $id";
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Serviço excluído com sucesso!'); window.location.href = 'gerenciar_servicos.php';</script>";
    } else {
        error_log("Erro ao excluir serviço: " . $conexao->error); // Logar erro
        echo "<script>alert('Erro ao excluir serviço. Tente novamente mais tarde.'); window.location.href = 'index.php?page=gerenciar_servicos';</script>";
    }
} else {
    echo "<script>alert('ID inválido!'); window.location.href = 'index.php?page=gerenciar_servicos';</script>";
}
?>
