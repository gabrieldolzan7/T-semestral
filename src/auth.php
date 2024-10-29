<?php
include 'db.php';

session_start();

function login($login, $senha) {
    $db = conectar();
    $query = "SELECT * FROM usuarios WHERE login = :login";
    $stmt = $db->prepare($query);
    $stmt->execute([':login' => $login]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['login'];
        header('Location: admin.php');
    } else {
        echo "Login ou senha incorretos.";
    }
}
?>
