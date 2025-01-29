<?php
session_start();
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha FROM usuarios WHERE usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();
        // Verifica se a senha está correta
        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['usuario_id'] = $dados['id'];
            $_SESSION['usuario_nome'] = $usuario;
            header("Location: index.php");
            exit;
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Área Administrativa</h1>
    <form action="login.php" method="post" class="mx-auto" style="max-width: 400px;">
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário:</label>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </div>
    </form>
</div>
</body>
</html>
