<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = conectar();

    foreach ($_POST['resposta'] as $id_pergunta => $resposta) {
        $feedback_textual = $_POST['feedback_textual'] ?? null;

        $query = "INSERT INTO avaliacoes (id_pergunta, resposta, feedback_textual, id_setor, id_dispositivo) 
                  VALUES (:id_pergunta, :resposta, :feedback_textual, 1, 1)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':id_pergunta' => $id_pergunta,
            ':resposta' => $resposta,
            ':feedback_textual' => $feedback_textual
        ]);
    }

    header('Location: ../public/obrigado.php');
    exit;
}
?>
