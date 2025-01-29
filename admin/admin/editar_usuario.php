<?php
include_once 'conexao.php';
include_once 'verifica_login.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $novoUsuario = $_POST['usuario'];
        $novaSenha = $_POST['senha'];

        // Atualizar os dados do usuário
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET usuario = ?, senha = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssi", $novoUsuario, $senhaHash, $id);

        if ($stmt->execute()) {
            header("Location: index.php?page=listar_usuarios");
            exit;
        } else {
            $erro = "Erro ao atualizar o usuário.";
        }
    }
} else {
    header("Location: index.php?page=listar_usuarios");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Editar Usuário</h1>
    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>
    <form action="" method="post" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário:</label>
            <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $usuario['usuario']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Nova Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Salvar</button>
        </div>
    </form>
</div>
</body>
</html>
