<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Fila de Agendamentos</h1>

    <?php
    include 'conexao.php';

    $itens_por_pagina = 10;
    $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $offset = ($pagina_atual - 1) * $itens_por_pagina;

    // Filtrar apenas agendamentos pendentes e ordenar pela data e horário
    $sql = "SELECT a.id, a.cliente_nome, a.data, a.horario, s.nome AS servico_nome
            FROM agendamentos a
            INNER JOIN servicos s ON a.servico_id = s.id
            WHERE a.status = 'Pendente'
            ORDER BY a.data, a.horario
            LIMIT $itens_por_pagina OFFSET $offset";

    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-hover'>";
        echo "<thead class='table-dark'><tr>
                <th>#</th>
                <th>Nome</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Serviço</th>
              </tr></thead>";
        echo "<tbody>";

        $numero = 1 + $offset; // Contador da fila
        while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $numero++ . "</td>"; // Exibe o número da fila
            echo "<td>" . htmlspecialchars($linha['cliente_nome']) . "</td>"; // Nome do cliente
            echo "<td>" . $linha['data'] . "</td>";
            echo "<td>" . $linha['horario'] . "</td>";
            echo "<td>" . htmlspecialchars($linha['servico_nome']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        // Paginação
        $sql_total = "SELECT COUNT(*) AS total FROM agendamentos WHERE status = 'Pendente'";
        $result_total = $conexao->query($sql_total);
        $total_registros = $result_total->fetch_assoc()['total'];
        $total_paginas = ceil($total_registros / $itens_por_pagina);

        echo "<nav>";
        echo "<ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $total_paginas; $i++) {
            $active = ($i == $pagina_atual) ? 'active' : '';
            echo "<li class='page-item $active'><a class='page-link' href='fila_agendamentos.php?pagina=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</nav>";

    } else {
        echo "<div class='alert alert-warning text-center'>Nenhum agendamento pendente encontrado.</div>";
    }

    $conexao->close();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
