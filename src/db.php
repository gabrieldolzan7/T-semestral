<?php
function conectar() {
    $host = 'localhost';
    $dbname = 'hrav_avaliacoes';
    $user = 'postgres';
    $password = 'postgres';

    try {
        return new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}
?>
