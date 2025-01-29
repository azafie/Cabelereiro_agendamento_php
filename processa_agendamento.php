<?php
include 'conexao.php';

$data = $_POST['data'];
$horario = $_POST['horario'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$servico = $_POST['servico'];

// Verifica se o horário já existe (com prepared statement)
$stmt_verifica = $conexao->prepare("SELECT * FROM agendamentos WHERE data = ? AND horario = ?");
$stmt_verifica->bind_param("ss", $data, $horario);
$stmt_verifica->execute();
$resultado_verifica = $stmt_verifica->get_result();

if ($resultado_verifica->num_rows > 0) {
    echo "Horário Indisponível";
    exit;
}
$stmt_verifica->close();

// Insere o agendamento 
$stmt = $conexao->prepare("INSERT INTO agendamentos (cliente_nome, cliente_telefone, data, horario, servico_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $nome, $telefone, $data, $horario, $servico);

if ($stmt->execute()) {
    echo "Agendamento realizado com sucesso!";
    header("Location: index.php?page=fila");
} else {
    echo "Erro ao agendar: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>