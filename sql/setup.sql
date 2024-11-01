DROP TABLE IF EXISTS avaliacoes;
DROP TABLE IF EXISTS perguntas;
DROP TABLE IF EXISTS dispositivos;
DROP TABLE IF EXISTS usuarios_admin;

CREATE TABLE dispositivos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,
    id_dispositivo INTEGER REFERENCES dispositivos(id),
    id_pergunta INTEGER REFERENCES perguntas(id),
    resposta INTEGER CHECK (resposta BETWEEN 0 AND 10),
    feedback TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuarios_admin (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE EXTENSION IF NOT EXISTS pgcrypto;


INSERT INTO usuarios_admin (username, password) VALUES ('admin', crypt('10203040', gen_salt('bf')));
