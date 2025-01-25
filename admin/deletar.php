<?php
// Inclui a conexão APENAS UMA VEZ
include '../conexao.php';

// Processa a exclusão do agendamento (DEVE vir ANTES do HTML)
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Usando Prepared Statement para segurança!
    $stmt = $conexao->prepare("DELETE FROM agendamentos WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que $id é um inteiro

    if ($stmt->execute()) {
        echo "success";
    } else {
        // Imprime o erro para debug (REMOVA em produção!)
        echo "error: " . $stmt->error;
    }
    $stmt->close();
    $conexao->close(); // Feche a conexão aqui, após o uso.
    exit; // Importante para parar a execução do script
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Agendamentos</h1>

    <?php
    // Consulta para exibir os agendamentos (APÓS o processamento de exclusão)
    $sql = "SELECT a.id, a.cliente_nome, a.cliente_telefone, a.data, a.horario, a.servico_id, a.status
            FROM agendamentos a
            ORDER BY a.data, a.horario";

    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<table class='table table-striped table-hover'>";
        echo "<thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Serviço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>";
        echo "<tbody>";

        while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $linha['id'] . "</td>";
            echo "<td>" . htmlspecialchars($linha['cliente_nome']) . "</td>"; // Segurança!
            echo "<td>" . htmlspecialchars($linha['cliente_telefone']) . "</td>"; // Segurança!
            echo "<td>" . $linha['data'] . "</td>";
            echo "<td>" . $linha['horario'] . "</td>";
            echo "<td>" . $linha['servico_id'] . "</td>";
            echo "<td>" . $linha['status'] . "</td>";
            echo "<td>
                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . $linha['id'] . "'>Deletar</button>
                    </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-warning text-center'>Nenhum agendamento encontrado.</div>";
    }
    // NÃO feche a conexão aqui.
    ?>

</div>

<script>
    $(document).ready(function() {
        $(".delete-btn").click(function() {
            var agendamentoId = $(this).data("id");

            if (confirm("Você tem certeza que deseja excluir este agendamento?")) {
                $.ajax({
                    url: '', // O próprio arquivo processa a exclusão
                    type: 'POST',
                    data: { 
                        action: 'delete', 
                        id: agendamentoId 
                    },
                    success: function(response) {
                        if (response === "success") {
                            $("button[data-id='" + agendamentoId + "']").closest("tr").remove();
                            alert("Agendamento deletado com sucesso.");
                        } else {
                            // Exibe o erro retornado pelo PHP (para debug)
                            alert("Erro ao deletar o agendamento: " + response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Erro na requisição AJAX: " + textStatus + " - " + errorThrown);
                    }
                });
            }
        });
    });
</script>

</body>
</html>
<?php $conexao->close(); ?>