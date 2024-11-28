<?php
function conectarBanco() {
    $host = 'localhost';
    $dbname = 'hospital_avaliacoes';
    $user = 'postgres';
    $password = 'postgres';

    try {
        return new PDO("pgsql:host=$host;dbname=$dbname", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}
?>
