<?php
require_once '../src/db.php';
require_once '../src/perguntas.php';

// Obter perguntas ativas
$perguntasAtivas = obterPerguntasAtivas();

// Checar se as perguntas existem
if (count($perguntasAtivas) == 0) {
    echo "Não há perguntas disponíveis.";
    exit;
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
</head>
<body>
    <div class="container">
        <h1>Avaliação</h1>

        <!-- Seleção do setor -->
        <div id="setor-container">
            <h2>Selecione o setor que deseja avaliar:</h2>
            <div class="setores">
                <button class="setor-button" data-setor="Recepção">Recepção</button>
                <button class="setor-button" data-setor="Enfermagem">Enfermagem</button>
                <button class="setor-button" data-setor="Emergência">Emergência</button>
                <button class="setor-button" data-setor="Alimentação">Alimentação</button>
            </div>
        </div>

        <!-- Formulário para avaliação -->
        <form action="obrigado.php" method="POST" id="avaliacaoForm" style="display: none;">
            <!-- Campo oculto para armazenar o setor selecionado -->
            <input type="hidden" name="setor" id="setorSelecionado">

            <!-- Perguntas serão exibidas uma de cada vez -->
            <div id="pergunta-container">
                <?php
                foreach ($perguntasAtivas as $pergunta) {
                    echo '<div class="pergunta" id="pergunta-' . $pergunta['id'] . '" style="display: none;">';
                    echo '<p>' . htmlspecialchars($pergunta['texto']) . '</p>';
                    echo '<div class="escala">';
                    
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<label class="quadrado">';
                        echo '<input type="radio" name="respostas[' . $pergunta['id'] . ']" value="' . $i . '" id="pergunta' . $pergunta['id'] . '-nota' . $i . '" required>';
                        echo '<span>' . $i . '</span>';
                        echo '</label>';
                    }

                    echo '</div>';  // Fechando div escala
                    echo '<textarea name="feedback[' . $pergunta['id'] . ']" placeholder="Deixe um feedback (opcional)" rows="4"></textarea>';
                    echo '</div>';  // Fechando div pergunta
                }
                ?>
            </div>

            <!-- Botão de navegação -->
            <div id="navigation-buttons">
                <button type="button" id="nextButton">Próxima</button>
            </div>
        </form>
    </div>

    <!-- Botão para login -->
    <a href="login.php" class="admin-button">Administração</a>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentQuestionIndex = 0;
            const perguntas = document.querySelectorAll('.pergunta');
            const setorContainer = document.getElementById('setor-container');
            const avaliacaoForm = document.getElementById('avaliacaoForm');
            const perguntaContainer = document.getElementById('pergunta-container');
            const nextButton = document.getElementById('nextButton');
            const navigationButtons = document.getElementById('navigation-buttons');
            const setorSelecionado = document.getElementById('setorSelecionado');

            // Manipular clique nos botões de setor
            document.querySelectorAll('.setor-button').forEach(button => {
                button.addEventListener('click', () => {
                    const setor = button.getAttribute('data-setor');
                    setorSelecionado.value = setor; // Armazena o setor selecionado
                    setorContainer.style.display = 'none';
                    avaliacaoForm.style.display = 'block';
                    perguntas[currentQuestionIndex].style.display = 'block';
                });
            });

            // Exibir próxima pergunta
            nextButton.addEventListener('click', () => {
                const currentQuestion = perguntas[currentQuestionIndex];
                const selectedAnswer = currentQuestion.querySelector('input[type="radio"]:checked');
                
                if (!selectedAnswer) {
                    alert('Por favor, selecione uma nota antes de prosseguir.');
                    return;
                }

                // Esconder a pergunta atual
                currentQuestion.style.display = 'none';
                currentQuestionIndex++;

                // Mostrar próxima pergunta ou submeter o formulário
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
