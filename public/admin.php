<?php
require_once '../src/auth.php';
require_once '../src/db.php';
require_once '../src/funcoes.php';

// Verificar se o usuário está autenticado
verificarAutenticacao();

$pdo = conectarBanco();

// Adicionar pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_pergunta'], $_POST['setor'])) {
    $novaPergunta = $_POST['nova_pergunta'];
    $setor = $_POST['setor'];

    if (!empty($novaPergunta) && !empty($setor)) {
        $stmt = $pdo->prepare("INSERT INTO perguntas (texto, setor, status) VALUES (:texto, :setor, TRUE)");
        $stmt->execute([':texto' => $novaPergunta, ':setor' => $setor]);
        $mensagem = "Pergunta adicionada com sucesso!";
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}

// Excluir pergunta
if (isset($_GET['delete'])) {
    $perguntaId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM perguntas WHERE id = :id");
    $stmt->execute([':id' => $perguntaId]);
}

// Obter perguntas cadastradas
$stmt = $pdo->query("SELECT * FROM perguntas");
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="admin-container">
    <!-- Botão para acessar painel.php -->
    <div class="painel-navegacao">
        <a href="painel.php" class="botao-painel">Ver Respostas e Avaliações</a>
    </div>

    <!-- Formulário fixo no topo -->
    <div class="formulario-fixo">
        <form method="POST" action="admin.php">
            <input type="text" name="nova_pergunta" placeholder="Digite uma nova pergunta" required>
            <select name="setor" required>
                <option value="">Selecione um setor</option>
                <option value="Recepção">Recepção</option>
                <option value="Enfermagem">Enfermagem</option>
                <option value="Emergência">Emergência</option>
                <option value="Alimentação">Alimentação</option>
                <option value="Estacionamento">Estacionamento</option>
            </select>
            <button type="submit">Adicionar Pergunta</button>
        </form>
    </div>

    <!-- Conteúdo principal -->
    <div class="conteudo">
        <h2>Perguntas Cadastradas</h2>

        <!-- Mensagem de status -->
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <div class="pergunta-lista">
            <?php foreach ($perguntas as $pergunta): ?>
                <div class="pergunta-item">
                    <span><?php echo htmlspecialchars($pergunta['texto']); ?> (Setor: <?php echo htmlspecialchars($pergunta['setor']); ?>)</span>
                    <a href="admin.php?delete=<?php echo $pergunta['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta pergunta?');">
                        <button>Excluir</button>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
