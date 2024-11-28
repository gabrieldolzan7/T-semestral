<?php
require_once 'db.php';  // Corrigido para o caminho correto

// **Sanitização**
function sanitizarEntrada($dados) {
    return is_array($dados) 
        ? array_map('sanitizarEntrada', $dados)
        : htmlspecialchars(trim($dados), ENT_QUOTES, 'UTF-8');
}


// Função para obter os dados do dashboard
function obterDadosDashboard($db) {
    $query = "
        SELECT 
            s.nome AS setor,
            p.texto AS pergunta,
            AVG(a.resposta) AS media_resposta
        FROM avaliacao a
        INNER JOIN setores s ON a.setor_id = s.id
        INNER JOIN perguntas p ON a.pergunta_id = p.id  -- Corrigido para 'pergunta_id', ou outro nome correto
        GROUP BY s.nome, p.texto
        ORDER BY s.nome, p.texto;
    ";

    // Executa a consulta SQL
    $stmt = $db->query($query);

    // Retorna os dados como um array associativo
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// **Funções de Perguntas**
function listarPerguntas($db) {
    $query = "SELECT * FROM perguntas WHERE status = TRUE ORDER BY id ASC";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarPergunta($db, $texto) {
    $query = "INSERT INTO perguntas (texto, status) VALUES (:texto, TRUE)";
    $stmt = $db->prepare($query);
    $stmt->execute([':texto' => sanitizarEntrada($texto)]);
}

function editarPergunta($db, $id, $texto, $status = true) {
    $query = "UPDATE perguntas SET texto = :texto, status = :status WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':texto' => sanitizarEntrada($texto),
        ':status' => $status,
        ':id' => (int)$id
    ]);
}

function removerPergunta($db, $id) {
    $query = "DELETE FROM perguntas WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => (int)$id]);
}

// **Funções de Dispositivos**
function listarDispositivos($db) {
    $query = "
        SELECT dispositivos.*, setores.nome AS setor_nome
        FROM dispositivos
        INNER JOIN setores ON dispositivos.setor_id = setores.id
        WHERE dispositivos.status = TRUE
        ORDER BY dispositivos.id ASC
    ";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarDispositivo($db, $nome, $setor_id) {
    $query = "INSERT INTO dispositivos (nome, setor_id, status) VALUES (:nome, :setor_id, TRUE)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nome' => sanitizarEntrada($nome),
        ':setor_id' => (int)$setor_id
    ]);
}

function editarDispositivo($db, $id, $nome, $setor_id) {
    $query = "UPDATE dispositivos SET nome = :nome, setor_id = :setor_id WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nome' => sanitizarEntrada($nome),
        ':setor_id' => (int)$setor_id,
        ':id' => (int)$id
    ]);
}

function removerDispositivo($db, $id) {
    $query = "DELETE FROM dispositivos WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => (int)$id]);
}
?>
