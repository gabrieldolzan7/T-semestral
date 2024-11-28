<?php
require_once '../src/db.php';
require_once '../src/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = $_POST['respostas'] ?? [];
    $feedback = $_POST['feedback'] ?? null;

    // Conectar ao banco
    $db = conectarBanco();

    // Suponha que o setor_id e dispositivo_id sejam fixos para esta implementação
    $setorId = 1; // Ajuste conforme o setor
    $dispositivoId = 1; // Ajuste conforme o dispositivo

    foreach ($respostas as $perguntaId => $nota) {
        $query = "INSERT INTO avaliacao (setor_id, pergunta_id, dispositivo_id, resposta, feedback) 
                  VALUES (:setor_id, :pergunta_id, :dispositivo_id, :resposta, :feedback)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':setor_id' => $setorId,
            ':pergunta_id' => $perguntaId,
            ':dispositivo_id' => $dispositivoId,
            ':resposta' => $nota,
            ':feedback' => $feedback
        ]);
    }

    // Redirecionar para a página de agradecimento
    header('Location: ../public/obrigado.php');
    exit();
}
