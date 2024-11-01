<?php
require_once 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    $pdo = conectar();
    $stmt = $pdo->prepare("SELECT * FROM usuarios_admin WHERE username = ?");
    $stmt->execute([$username]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_logado'] = $usuario['username'];
        header("Location: admin.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="formulario">
        <h1>Login Administrativo</h1>
        <?php if (!empty($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
