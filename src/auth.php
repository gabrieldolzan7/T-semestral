<?php
session_start();

function verificarAutenticacao() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit();
    }
}

function autenticarUsuario($usuario, $senha) {
    // Substituir pela verificação no banco de dados
    $usuarioValido = 'admin';
    $senhaValida = 'admin';

    if ($usuario === $usuarioValido && $senha === $senhaValida) {
        $_SESSION['usuario'] = $usuario;
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
}
?>
