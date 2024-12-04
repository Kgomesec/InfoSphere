DROP DATABASE IF EXISTS ProjetoPW;

CREATE DATABASE ProjetoPW;

USE ProjetoPW;

CREATE TABLE IF NOT EXISTS Usuarios(
    ID_Usuario int(5) AUTO_INCREMENT PRIMARY KEY,
    Foto_perfil varchar(5),
    Username varchar(50),
    Nome varchar(50),
    Email varchar(50),
    Senha varchar(50)

);

CREATE TABLE IF NOT EXISTS Posts(
    ID_Post int(5),
    ID_Usuario int(5),
    Assunto Text,
    URL_midia text,
    Descricao varchar(50),
    Data_criacao timestamp default current_timestamp,
    Data_update timestamp default current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    Visibilidade VARCHAR(20) DEFAULT 'public',
    Cont_like int default 0,
    Cont_comment int default 0,
    Cont_compartilhamento int default 0,
    Post_delete boolean default false,
    Reference_post_id int REFERENCES Posts(id),
    FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) 
);

INSERT INTO Usuarios (ID_Usuario, Foto_perfil, Username, Email, Senha, Nome) VALUES
(1, 'img1', 'usuario1', 'user1@example.com', 'senha123', 'João Silva'),
(2, 'img2', 'usuario2', 'user2@example.com', 'senha456', 'Maria Oliveira'),
(3, 'img3', 'usuario3', 'user3@example.com', 'senha789', 'Carlos Souza'),
(4, 'img4', 'usuario4', 'user4@example.com', 'senha101', 'Ana Costa'),
(5, 'img5', 'usuario5', 'user5@example.com', 'senha202', 'Ricardo Lima'),
(6, 'img6', 'usuario6', 'user6@example.com', 'senha303', 'Patrícia Almeida'),
(7, 'img7', 'usuario7', 'user7@example.com', 'senha404', 'Fernanda Rocha'),
(8, 'img8', 'usuario8', 'user8@example.com', 'senha505', 'Eduardo Pereira'),
(9, 'img9', 'usuario9', 'user9@example.com', 'senha606', 'Juliana Martins'),
(10, 'img10', 'usuario10', 'user10@example.com', 'senha707', 'Felipe Alves');


INSERT INTO Posts (ID_Post, ID_Usuario, Assunto, URL_midia, Descricao, Data_criacao, Data_update, Visibilidade, Cont_like, Cont_comment, Cont_compartilhamento, Post_delete, Reference_post_id) VALUES
(1, 1, 'Assunto interessante', 'http://img1.com', 'Descrição do post 1', DEFAULT, DEFAULT, 'public', 10, 5, 2, FALSE, NULL),
(2, 2, 'Post sobre tecnologia', 'http://img2.com', 'Descrição do post 2', DEFAULT, DEFAULT, 'public', 20, 8, 3, FALSE, NULL),
(3, 3, 'Viagem incrível', 'http://img3.com', 'Descrição do post 3', DEFAULT, DEFAULT, 'private', 15, 7, 4, FALSE, NULL),
(4, 4, 'Dicas de carreira', 'http://img4.com', 'Descrição do post 4', DEFAULT, DEFAULT, 'connections', 12, 3, 1, FALSE, NULL),
(5, 5, 'Evento próximo', 'http://img5.com', 'Descrição do post 5', DEFAULT, DEFAULT, 'public', 25, 10, 5, FALSE, NULL),
(6, 6, 'Novidade na empresa', 'http://img6.com', 'Descrição do post 6', DEFAULT, DEFAULT, 'connections', 18, 4, 3, FALSE, NULL),
(7, 7, 'Projeto em andamento', 'http://img7.com', 'Descrição do post 7', DEFAULT, DEFAULT, 'private', 8, 2, 0, FALSE, NULL),
(8, 8, 'Fotos do evento', 'http://img8.com', 'Descrição do post 8', DEFAULT, DEFAULT, 'public', 30, 15, 7, FALSE, NULL),
(9, 9, 'Livro recomendado', 'http://img9.com', 'Descrição do post 9', DEFAULT, DEFAULT, 'connections', 22, 9, 2, FALSE, NULL),
(10, 10, 'Ideias para o futuro', 'http://img10.com', 'Descrição do post 10', DEFAULT, DEFAULT, 'public', 35, 20, 10, FALSE, NULL);

Select * from Usuarios where Username = 'usuario1' and Senha = 'senha789';
SELECT * FROM Posts WHERE Visibilidade = 'public';

-- hehehhe

