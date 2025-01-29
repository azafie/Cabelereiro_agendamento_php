<?php
include_once 'conexao.php';
include_once 'verifica_login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    
    // Hash da senha para segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario, $senhaHash);

    if ($stmt->execute()) {
        header("Location: index.php?page=listar_usuarios");
    } else {
        $mensagem = "Erro ao inserir usuário: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Inserir Novo Usuário</h1>
    <?php if (isset($mensagem)): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    <form action="inserir_usuario.php" method="post" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário:</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Inserir</button>
        </div>
    </form>
</div>
</body>
</html>
