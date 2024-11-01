<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = conectar();
    $feedback = !empty($_POST['feedback']) ? $_POST['feedback'] : null;
    $dispositivo_id = 1; // ID fixo para o dispositivo neste exemplo. Pode ser configurado conforme o ambiente real.

    try {
        $pdo->beginTransaction();

        // Iterar sobre cada pergunta e salvar a resposta
        foreach ($_POST['resposta'] as $pergunta_id => $resposta) {
            $stmt = $pdo->prepare("INSERT INTO avaliacoes (id_dispositivo, id_pergunta, resposta, feedback) VALUES (?, ?, ?, ?)");
            $stmt->execute([$dispositivo_id, $pergunta_id, $resposta, $feedback]);
        }

        $pdo->commit();
        header("Location: ../public/obrigado.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro ao salvar respostas: " . $e->getMessage());
    }
}
?>
