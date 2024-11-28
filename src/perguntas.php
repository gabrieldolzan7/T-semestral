<?php
require_once 'db.php';

function obterPerguntasAtivas() {
    $pdo = conectarBanco();
    $stmt = $pdo->query("SELECT id, texto FROM perguntas WHERE status = TRUE");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
