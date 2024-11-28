<?php
session_start();
require_once '../src/db.php';  // Corrigido para o caminho correto
require_once '../src/funcoes.php';  // Corrigido para o caminho correto

// Mensagem de erro
$erro = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Sanitização básica
    $usuario = htmlspecialchars(trim($usuario), ENT_QUOTES, 'UTF-8');
    $senha = htmlspecialchars(trim($senha), ENT_QUOTES, 'UTF-8');

    // Verificação de credenciais (credenciais estáticas como exemplo)
    $usuariosValidos = [
        'admin' => '10203040', // Usuário: admin, Senha: 10203040
    ];

    if (isset($usuariosValidos[$usuario]) && $usuariosValidos[$usuario] === $senha) {
        $_SESSION['usuario'] = $usuario;
        header('Location: admin.php'); // Redireciona para o painel administrativo
        exit;
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
    <link rel="stylesheet" href="css/style.css">
    <title>Login - Painel Administrativo</title>
</head>
<body class="login-body">
    <div class="login-container">
        <h1>Login - Painel Administrativo</h1>

        <!-- Exibe a mensagem de erro -->
        <?php if ($erro): ?>
            <p class="error-message"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="login-form">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
