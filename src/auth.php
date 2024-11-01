<?php
session_start();

function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_logado'])) {
        header("Location: ../public/login.php");
        exit;
    }
}
?>
