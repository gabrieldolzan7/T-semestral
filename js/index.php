<?php
include '../src/perguntas.php';

$perguntas = buscarPerguntas();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação HRAV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Avaliação de Serviços HRAV</h1>
    <form action="../src/respostas.php
    " method="POST">
        <?php foreach ($perguntas as $pergunta): ?>
            <label><?= htmlspecialchars($pergunta['texto']) ?></label>
            <input type="range" name="resposta[<?= $pergunta['id'] ?>]" min="0" max="10" value="5">
        <?php endforeach; ?>
        
        <label>Comentários adicionais:</label>
        <textarea name="feedback_textual"></textarea>
        
        <input type="submit" value="Enviar Avaliação">
    </form>
    <footer>
        <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
    </footer>
</body>
</html>
