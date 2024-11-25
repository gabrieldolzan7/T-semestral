<?php
require_once '../src/db.php';

try {
    $pdo = conectar();
    $stmt = $pdo->query("SELECT * FROM perguntas WHERE status = TRUE");
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao carregar perguntas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="formulario">
        <h1>Avalie nossos serviços</h1>
        <form action="../src/respostas.php" method="post">
            <?php foreach ($perguntas as $pergunta): ?>
                <div class="pergunta">
                    <p><?php echo htmlspecialchars($pergunta['texto']); ?></p>
                    <div class="escala">
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <label class="radio-label">
                                <input type="radio" name="resposta[<?php echo $pergunta['id']; ?>]" value="<?php echo $i; ?>" required>
                                <span class="radio-span" data-value="<?php echo $i; ?>"><?php echo $i; ?></span>
                             </label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <textarea name="feedback" placeholder="Deixe um feedback adicional (opcional)"></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
