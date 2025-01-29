<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Agendamentos</h1>

    <?php
    include_once 'verifica_login.php';
    include_once '../conexao.php';

    $itens_por_pagina = 10;
    $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $offset = ($pagina_atual - 1) * $itens_por_pagina;

    // Prioridade para agendamentos a partir da data atual
    $sql = "SELECT a.id, a.cliente_nome, a.cliente_telefone, a.data, a.horario, s.nome AS servico_nome, a.status
            FROM agendamentos a
            INNER JOIN servicos s ON a.servico_id = s.id
            ORDER BY CASE WHEN a.data = CURDATE() THEN 0 WHEN a.data > CURDATE() THEN 1 ELSE 2 END, a.data, a.horario
            LIMIT $itens_por_pagina OFFSET $offset";

    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-hover'>";
        echo "<thead class='table-dark'><tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Serviço</th>
                <th>Status</th>
                <th>Ações</th>
              </tr></thead>";
        echo "<tbody>";

        while ($linha = $resultado->fetch_assoc()) {
            $status_class = ($linha['status'] === 'Concluído') ? 'table-success' : (($linha['status'] === 'Cancelado') ? 'table-danger' : '');
            echo "<tr class='$status_class'>";
            echo "<td>" . $linha['id'] . "</td>";
            echo "<td>" . htmlspecialchars($linha['cliente_nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['cliente_telefone']) . "</td>";
            echo "<td>" . $linha['data'] . "</td>";
            echo "<td>" . $linha['horario'] . "</td>";
            echo "<td>" . htmlspecialchars($linha['servico_nome']) . "</td>";
            echo "<td>" . $linha['status'] . "</td>";
            echo "<td>";
            if ($linha['status'] != 'Concluído' && $linha['status'] != 'Cancelado') {
                echo "<a href='atualiza_status.php?id=" . $linha['id'] . "&status=Concluído' class='btn btn-success btn-sm'>Concluído</a> ";
                echo "<a href='atualiza_status.php?id=" . $linha['id'] . "&status=Cancelado' class='btn btn-danger btn-sm'>Cancelado</a>";
            }
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        // Paginação
        $sql_total = "SELECT COUNT(*) AS total FROM agendamentos";
        $result_total = $conexao->query($sql_total);
        $total_registros = $result_total->fetch_assoc()['total'];
        $total_paginas = ceil($total_registros / $itens_por_pagina);

        echo "<nav>";
        echo "<ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $total_paginas; $i++) {
            $active = ($i == $pagina_atual) ? 'active' : '';
            echo "<li class='page-item $active'><a class='page-link' href='lista_agendamentos.php?pagina=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</nav>";

    } else {
        echo "<div class='alert alert-warning text-center'>Nenhum agendamento encontrado.</div>";
    }

    $conexao->close();
    ?>
</div>

<script>
$(document).ready(function () {
    // Destacar a linha com a data mais próxima da atual
    $("tbody tr").each(function () {
        const data = $(this).find("td:nth-child(4)").text();
        const hoje = new Date().toISOString().split('T')[0];

        if (data === hoje) {
            $(this).addClass("table-primary");
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
