<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function atualizarHorarios() {
            var dataSelecionada = document.getElementById("data").value;
            $.get("get_horarios.php", { data: dataSelecionada }, function(response) {
                $("#horario").html(response);
            });
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Agende seu horário</h1>
    <form action="processa_agendamento.php" method="post" class="row g-3">
        <div class="col-md-6">
            <label for="data" class="form-label">Data:</label>
            <input type="date" name="data" id="data" class="form-control" onchange="atualizarHorarios()" required>
        </div>

        <div class="col-md-6">
            <label for="servico" class="form-label">Serviço:</label>
            <select name="servico" id="servico" class="form-select">
                <?php
                include 'conexao.php';

                $itens_por_pagina = 5;
                $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                $offset = ($pagina_atual - 1) * $itens_por_pagina;

                $sql = "SELECT id, nome FROM servicos LIMIT $itens_por_pagina OFFSET $offset";
                $resultado = $conexao->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($linha = $resultado->fetch_assoc()) {
                        echo "<option value='" . $linha["id"] . "'>" . $linha["nome"] . "</option>";
                    }
                }

                $sql_total = "SELECT COUNT(*) AS total FROM servicos";
                $result_total = $conexao->query($sql_total);
                $total_registros = $result_total->fetch_assoc()['total'];
                $total_paginas = ceil($total_registros / $itens_por_pagina);

                echo "<div class='mt-3'>";
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo "<a href='?pagina=$i' class='btn btn-link'>" . $i . "</a> ";
                }
                echo "</div>";

                $conexao->close();
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label for="horario" class="form-label">Horário:</label>
            <select name="horario" id="horario" class="form-select">
            </select>
        </div>

        <div class="col-md-12 text-center mt-4">
            <input type="submit" value="Agendar" class="btn btn-primary">
        </div>
    </form>
</div>

<script>
    // Chama a função para carregar os horários iniciais (para a data atual, se houver)
    atualizarHorarios();
</script>
</body>
</html>
