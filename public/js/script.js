document.addEventListener('DOMContentLoaded', () => {
    // Evento 1: Seleção de quadrados
    const quadrados = document.querySelectorAll('.quadrado input[type="radio"]');
    quadrados.forEach(quadrado => {
        quadrado.addEventListener('change', (event) => {
            const labels = document.querySelectorAll('.quadrado');
            labels.forEach(label => label.classList.remove('ativo')); // Remove a classe 'ativo' de todos
            event.target.parentNode.classList.add('ativo'); // Adiciona a classe 'ativo' ao selecionado
        });
    });

    // Evento 2: Barra de progresso e redirecionamento
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) { // Verifica se a barra de progresso está presente na página
        let timeLeft = 5; // Tempo total em segundos
        let totalTime = 5; // Tempo total para cálculo da porcentagem

        const interval = setInterval(() => {
            timeLeft--; // Reduz o tempo restante
            const widthPercentage = (timeLeft / totalTime) * 100; // Calcula a largura restante
            progressBar.style.width = widthPercentage + "%"; // Ajusta a largura da barra

            if (timeLeft <= 0) {
                clearInterval(interval); // Para o intervalo
                window.location.href = "index.php"; // Redireciona
            }
        }, 1000); // Executa a cada segundo
    }
});
