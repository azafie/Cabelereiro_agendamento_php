<?php
require '../conexao.php'; // Incluindo o arquivo de conexão

// Adicionando serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $duracao = $conexao->real_escape_string($_POST['duracao']); // Duração como string

    $sql = "INSERT INTO servicos (nome, duracao) VALUES ('$nome', '$duracao')";
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Serviço adicionado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao adicionar serviço: " . $conexao->error . "');</script>";
    }
}

// Excluindo serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_service'])) {
    $id = (int) $_POST['id'];
    $sql = "DELETE FROM servicos WHERE id = $id";
    $conexao->query($sql);
}

// Editando serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_service'])) {
    $id = (int) $_POST['id'];
    $nome = $conexao->real_escape_string($_POST['nome']);
    $duracao = $conexao->real_escape_string($_POST['duracao']); // Duração como string

    $sql = "UPDATE servicos SET nome = '$nome', duracao = '$duracao' WHERE id = $id";
    $conexao->query($sql);
}

// Recuperando serviços
$servicos = $conexao->query("SELECT * FROM servicos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Gerenciar Serviços</h2>

    <!-- Formulário para adicionar serviço -->
    <form method="POST" class="mt-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="nome" class="form-control" placeholder="Nome do Serviço" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="duracao" class="form-control" placeholder="Duração (em minutos)" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add_service" class="btn btn-success w-100">Adicionar</button>
            </div>
        </div>
    </form>

    <!-- Lista de serviços -->
    <div class="mt-5">
        <h4>Serviços Cadastrados</h4>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Duração</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $servicos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= htmlspecialchars($row['duracao']) ?> min</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="<?= $row['id'] ?>" 
                                data-nome="<?= htmlspecialchars($row['nome']) ?>" 
                                data-duracao="<?= htmlspecialchars($row['duracao']) ?>">Editar</button>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_service" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para editar serviço -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-nome" class="form-label">Nome do Serviço</label>
                        <input type="text" class="form-control" name="nome" id="edit-nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-duracao" class="form-label">Duração</label>
                        <input type="text" class="form-control" name="duracao" id="edit-duracao" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit_service" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).on('click', '.edit-btn', function() {
    const id = $(this).data('id');
    const nome = $(this).data('nome');
    const duracao = $(this).data('duracao');

    $('#edit-id').val(id);
    $('#edit-nome').val(nome);
    $('#edit-duracao').val(duracao);

    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
});
</script>
</body>
</html>
