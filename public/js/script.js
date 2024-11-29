document.addEventListener('DOMContentLoaded', () => {
    function iniciarBarraProgresso() {
        const progressContainer = document.getElementById('progress-container');
        const progressFill = document.getElementById('progress-fill');

        if (!progressContainer || !progressFill) {
            return;
        }

        progressContainer.style.display = 'block'; // Exibe a barra de progresso

        // Após 100ms, ativa a animação deslizando a barra
        setTimeout(() => {
            progressFill.style.transform = 'translateX(0)'; // Movimenta a barra até 0%
        }, 100);

        // Redireciona para a página após o término da animação (5s)
        setTimeout(() => {
            window.location.href = "index.php"; // Redireciona após 5 segundos
        }, 5100); // Inclui 100ms de atraso inicial
    }

    // Iniciar a barra de progresso ao carregar a página
    iniciarBarraProgresso();
});
