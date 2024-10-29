-- Active: 1730147736166@@127.0.0.1@5432@hrav_avaliacoes

CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,
    id_setor INT REFERENCES setores(id),
    id_pergunta INT REFERENCES perguntas(id),
    id_dispositivo INT REFERENCES dispositivos(id),
    resposta INT CHECK (resposta BETWEEN 0 AND 10) NOT NULL,
    feedback_textual TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE setores (
    id SERIAL PRIMARY KEY,
    nome TEXT NOT NULL
);

CREATE TABLE dispositivos (
    id SERIAL PRIMARY KEY,
    nome TEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    login TEXT NOT NULL,
    senha TEXT NOT NULL
);
