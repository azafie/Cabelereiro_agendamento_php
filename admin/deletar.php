<?php
include_once '../conexao.php'; // Conexão com o banco de dados
include_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <!-- Link do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* Estilo personalizado para a cor "zebrada" */
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #7B68EE !important;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .btn-danger:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Agendamentos</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Horário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT id, cliente_nome, horario FROM agendamentos";
                $result = $conexao->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='row-{$row['id']}'>";
                    echo "<td>" . htmlspecialchars($row['cliente_nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['horario']) . "</td>";
                    echo "<td><button class='btn btn-danger delete-btn' data-id='{$row['id']}'>Deletar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Script de deleção com jQuery -->
    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                const id = $(this).data('id'); // Pega o ID do botão clicado

                if (confirm('Tem certeza que deseja deletar este agendamento?')) {
                    $.ajax({
                        url: 'delete_agendamento.php',
                        method: 'POST',
                        data: { id: id },
                        success: function (response) {
                            if (response === 'success') {
                                $('#row-' + id).remove(); // Remove a linha
                                alert('Agendamento deletado com sucesso!');
                            } else {
                                alert('Erro ao deletar o agendamento.');
                            }
                        },
                        error: function () {
                            alert('Erro na requisição.');
                        }
                    });
                }
            });
        });
    </script>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conexao->close(); // Fecha a conexão com o banco de dados
?>
