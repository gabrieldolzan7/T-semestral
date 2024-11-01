<?php
require_once 'config.php';

function conectar() {
    try {
        return new PDO("pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}
?>
