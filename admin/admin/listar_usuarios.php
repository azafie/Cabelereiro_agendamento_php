<?php
include 'verifica_login.php';
include 'conexao.php';

// Deletar usuário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php?page=listar_usuarios");
    exit;
}

// Selecionar todos os usuários
$sql = "SELECT * FROM usuarios";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gerenciar Usuários</h1>
    <a href="inserir_usuario.php" class="btn btn-success mb-3">Inserir Novo Usuário</a>
    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($usuario = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="listar_usuarios.php?delete=<?php echo $usuario['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Deletar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Nenhum usuário encontrado.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
