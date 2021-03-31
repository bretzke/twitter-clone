CREATE DATABASE twitter_clone;

USE twitter_clone;

CREATE TABLE usuarios(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(32) NOT NULL
);

CREATE TABLE tweets(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_usuario INT NOT NULL,
	tweet VARCHAR(140) NOT NULL,
	DATA DATETIME DEFAULT current_timestamp
);

CREATE TABLE usuarios_seguidores(
	id INT NOT NULL PRIMARY KEY auto_increment,
	id_usuario INT NOT NULL,
	id_usuario_seguindo INT NOT NULL
);

/*opcional para popular o banco
INSERT INTO usuarios (nome, email, senha)
VALUES
("Willian Teste", "willian@teste.com", MD5('willian1234')),
("Joãozinho", "joao@teste.com", MD5('joao1234')),
("Suyani", "suyani@teste.com", MD5('suyani1234')),
("Lucas Schwarzenegger", "lucas@teste.com", MD5('lucas1234'));
*/