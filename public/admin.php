<?php
session_start();
require_once '../src/db.php';
require_once '../src/perguntas.php';

// Verificar autenticação
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Adicionar pergunta ao banco de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = $_POST['texto'] ?? '';
    $setor = $_POST['setor'] ?? '';

    if (!empty($texto) && !empty($setor)) {
        $pdo = conectarBanco();
        $stmt = $pdo->prepare("INSERT INTO perguntas (texto, setor, status) VALUES (:texto, :setor, TRUE)");
        $stmt->execute([
            ':texto' => $texto,
            ':setor' => $setor
        ]);
        $mensagem = "Pergunta adicionada com sucesso!";
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

// Obter perguntas existentes
$pdo = conectarBanco();
$perguntas = $pdo->query("SELECT * FROM perguntas")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Administração - Painel</title>
</head>
<body>
    <h1>Painel Administrativo</h1>

    <!-- Mensagem de sucesso ou erro -->
    <?php if (!empty($mensagem)): ?>
        <p class="mensagem"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <!-- Formulário de adição de perguntas -->
    <form action="admin.php" method="POST">
        <label for="texto">Texto da Pergunta:</label>
        <input type="text" id="texto" name="texto" required>

        <label for="setor">Setor:</label>
        <select id="setor" name="setor" required>
            <option value="">Selecione o setor</option>
            <option value="Recepção">Recepção</option>
            <option value="Enfermagem">Enfermagem</option>
            <option value="Emergência">Emergência</option>
            <option value="Alimentação">Alimentação</option>
        </select>

        <button type="submit">Adicionar Pergunta</button>
    </form>

    <!-- Lista de perguntas existentes -->
    <h2>Perguntas Cadastradas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Texto</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($perguntas as $pergunta): ?>
                <tr>
                    <td><?php echo $pergunta['id']; ?></td>
                    <td><?php echo htmlspecialchars($pergunta['texto']); ?></td>
                    <td><?php echo htmlspecialchars($pergunta['setor']); ?></td>
                    <td>
                        <a href="excluir_pergunta.php?id=<?php echo $pergunta['id']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
