CREATE DATABASE gerenciadorTarefas;
USE gerenciadorTarefas;

-- Comando para apagar  o banco de dados
DROP DATABASE gerenciadorTarefas;

CREATE TABLE usuario (

id_usuario INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
nome VARCHAR(255) NOT NULL UNIQUE,
email VARCHAR(255) NOT NULL

);

CREATE TABLE tarefa (

id_tarefa INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
nomeTarefa VARCHAR(255) NOT NULL,
descricaoTarefa VARCHAR(255) NOT NULL,
nomeSetor VARCHAR(255),
dataTarefa VARCHAR(255) NOT NULL,
statusTarefa ENUM('A fazer', 'Fazendo', 'Pronto'),
prioridadeTarefa ENUM ('Baixa', 'Média', 'Alta')

);

SELECT * FROM usuario;

set foreign_key_checks = 0;

ALTER TABLE tarefa ADD COLUMN id_usuario INTEGER NOT NULL, ADD CONSTRAINT fk_usuario 
FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);




SELECT 
    usuario.nome AS nome_usuario,
    tarefa.nomeTarefa AS nome_tarefa,
    tarefa.descricaoTarefa AS descricao_tarefa,
    tarefa.nomeSetor AS nome_setor,
    tarefa.dataTarefa AS data_tarefa,
    tarefa.statusTarefa AS status_tarefa,
    tarefa.prioridadeTarefa AS prioridade_tarefa
FROM 
    tarefa
JOIN 
    usuario ON tarefa.id_usuario = usuario.id_usuario;

