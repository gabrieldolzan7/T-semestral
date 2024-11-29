-- Configuração do banco de dados
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha_hash TEXT NOT NULL -- Senha armazenada como hash
);

CREATE TABLE IF NOT EXISTS setores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS dispositivos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    setor_id INT NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (setor_id) REFERENCES setores(id)
);

CREATE TABLE IF NOT EXISTS avaliacao (
    id SERIAL PRIMARY KEY,
    setor_id INT NOT NULL,
    pergunta_id INT NOT NULL REFERENCES perguntas(id),
    dispositivo_id INT NOT NULL REFERENCES dispositivos(id),
    resposta INT NOT NULL CHECK (resposta BETWEEN 0 AND 10),
    feedback TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (setor_id) REFERENCES setores(id)
);

-- Inserção de dados iniciais
INSERT INTO setores (nome) VALUES ('Recepção'), ('Enfermagem'), ('Emergência')
ON CONFLICT DO NOTHING;

INSERT INTO perguntas (texto, status) VALUES 
('Como você avalia a recepção?', TRUE),
('Como você avalia a enfermagem?', TRUE),
('Como você avalia a emergência?', TRUE)
ON CONFLICT DO NOTHING;

-- Inserir o usuário admin com senha 10203040
INSERT INTO usuarios (login, senha_hash) VALUES 
('admin', '$2y$10$9QPqPeUFOkU3lfGAGkPYzeZRndAAyB7uNxwJ4chTI3T0ybplNWPCy') -- Hash da senha '10203040'
ON CONFLICT DO NOTHING;

ALTER TABLE avaliacao
ADD COLUMN pergunta_id INT;

ALTER TABLE avaliacao
ADD CONSTRAINT fk_pergunta_id
FOREIGN KEY (pergunta_id) REFERENCES perguntas(id);

ALTER TABLE perguntas ADD COLUMN setor VARCHAR(255);

CREATE TABLE categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

INSERT INTO categorias (nome) VALUES 
('Recepção'), 
('Enfermagem'), 
('Emergência'), 
('Alimentação');

