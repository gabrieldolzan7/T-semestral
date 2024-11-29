<?php
require_once '../src/db.php';
require_once '../src/perguntas.php';

// Inicialize a variável
$setorSelecionado = $_GET['setor'] ?? null;

// Obter perguntas ativas com base no setor
$perguntasAtivas = $setorSelecionado ? obterPerguntasPorSetor($setorSelecionado) : [];

function obterPerguntasPorSetor($setor) {
    $pdo = conectarBanco();
    $stmt = $pdo->prepare("SELECT id, texto FROM perguntas WHERE status = TRUE AND setor = :setor");
    $stmt->execute([':setor' => $setor]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação - Hospital</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Avaliação de satisfação - HRAV</h1>

        <!-- Seleção do setor -->
        <div id="setor-container">
            <?php if (!$setorSelecionado): ?>
                <h2>Selecione o setor que deseja avaliar:</h2>
                <div class="setores">
    <a href="index.php?setor=Recepção" class="setor-button">
        <i class="fas fa-user-check"></i> Recepção
    </a>
    <a href="index.php?setor=Enfermagem" class="setor-button">
        <i class="fas fa-stethoscope"></i> Enfermagem
    </a>
    <a href="index.php?setor=Emergência" class="setor-button">
        <i class="fas fa-ambulance"></i> Emergência
    </a>
    <a href="index.php?setor=Alimentação" class="setor-button">
        <i class="fas fa-utensils"></i> Alimentação
    </a>
    <a href="index.php?setor=Estacionamento" class="setor-button">
        <i class="fas fa-car"></i> Estacionamento
    </a>
</div>

            <?php endif; ?>
        </div>

        <!-- Formulário para avaliação -->
        <?php if ($setorSelecionado && count($perguntasAtivas) > 0): ?>
            <form action="obrigado.php" method="POST" id="avaliacaoForm">
                <input type="hidden" name="setor" value="<?php echo htmlspecialchars($setorSelecionado); ?>">
                <h2>Avaliando o setor: <?php echo htmlspecialchars($setorSelecionado); ?></h2>

                <div id="pergunta-container">
                    <?php foreach ($perguntasAtivas as $pergunta): ?>
                        <div class="pergunta" id="pergunta-<?php echo $pergunta['id']; ?>" style="display: none;">
                            <p><?php echo htmlspecialchars($pergunta['texto']); ?></p>
                            <div class="escala">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <label class="quadrado">
                                        <input type="radio" name="respostas[<?php echo $pergunta['id']; ?>]" value="<?php echo $i; ?>" required>
                                        <span><?php echo $i; ?></span>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <textarea name="feedback[<?php echo $pergunta['id']; ?>]" placeholder="Deixe um feedback (opcional)" rows="4"></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="navigation-buttons">
                    <button type="button" id="nextButton">Próxima</button>
                </div>
            </form>
        <?php elseif ($setorSelecionado): ?>
            <p>Não há perguntas disponíveis para o setor selecionado.</p>
        <?php endif; ?>
    </div>

    <a href="login.php" class="admin-button">Administração</a>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentQuestionIndex = 0;
            const perguntas = document.querySelectorAll('.pergunta');
            const avaliacaoForm = document.getElementById('avaliacaoForm');
            const nextButton = document.getElementById('nextButton');

            if (perguntas.length > 0) {
                perguntas[currentQuestionIndex].style.display = 'block';
            }

            // Exibir próxima pergunta
            nextButton.addEventListener('click', () => {
                const currentQuestion = perguntas[currentQuestionIndex];
                const selectedAnswer = currentQuestion.querySelector('input[type="radio"]:checked');

                if (!selectedAnswer) {
                    alert('Por favor, selecione uma nota antes de prosseguir.');
                    return;
                }

                currentQuestion.style.display = 'none';
                currentQuestionIndex++;

                if (currentQuestionIndex < perguntas.length) {
                    perguntas[currentQuestionIndex].style.display = 'block';
                } else {
                    avaliacaoForm.submit();
                }
            });
        });
    </script>
</body>
</html>
