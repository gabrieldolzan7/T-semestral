<?php
require_once '../src/db.php';

function obterRespostas() {
    $pdo = conectarBanco();
    $stmt = $pdo->query("
        SELECT 
            r.id,
            p.texto AS pergunta,
            r.resposta,
            r.setor,
            r.data_resposta
        FROM respostas r
        INNER JOIN perguntas p ON r.pergunta_id = p.id
        ORDER BY r.data_resposta DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$respostas = obterRespostas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Painel Administrativo - Respostas das Avaliações</h1>
        
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Setor</th>
                    <th>Data da Resposta</th>
                    <th>Pergunta</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($respostas) > 0): ?>
                    <?php foreach ($respostas as $resposta): ?>
                        <tr>
                            <td><?php echo $resposta['id']; ?></td>
                            <td><?php echo htmlspecialchars($resposta['setor']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($resposta['data_resposta'])); ?></td>
                            <td><?php echo htmlspecialchars($resposta['pergunta']); ?></td>
                            <td><?php echo htmlspecialchars($resposta['resposta']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhuma resposta encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="admin-links">
            <a href="index.php">Voltar para Avaliações</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
