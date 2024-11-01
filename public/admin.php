<?php
require_once '../src/db.php';
require_once '../src/auth.php';

verificarAutenticacao();

try {
    $pdo = conectar();
    $stmt = $pdo->query("SELECT p.texto AS pergunta, AVG(a.resposta) AS media_resposta
                         FROM avaliacoes a
                         JOIN perguntas p ON a.id_pergunta = p.id
                         GROUP BY p.texto");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao carregar avaliações: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Administração</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="formulario">
        <h1>Painel Administrativo</h1>
        <table>
            <tr>
                <th>Pergunta</th>
                <th>Média de Resposta</th>
            </tr>
            <?php foreach ($resultados as $resultado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($resultado['pergunta']); ?></td>
                    <td><?php echo number_format($resultado['media_resposta'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="../src/logout.php">Sair</a>
    </div>
</body>
</html>
