<?php
function conectar() {
    $host = 'localhost';
    $dbname = 'hrav_avaliacoes';
    $user = 'postgres';
    $password = 'postgres';

    try {
        return new PDO("pgsql:host=$host;dbname=$dbname", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}

function buscarPerguntas() {
    $pdo = conectar();
    $sql = "SELECT * FROM perguntas"; 

    $stmt = $pdo->query($sql);
    if ($stmt === false) {
        die("Erro ao executar a consulta: " . print_r($pdo->errorInfo(), true));
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

