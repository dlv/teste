CREATE TABLE usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login TEXT NOT NULL,
    senha TEXT NOT NULL
);

CREATE TABLE clientes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome TEXT,
    data_nascimento date,
    CPF TEXT,
    RG TEXT,
    telefone Text
);

CREATE TABLE email_cliente (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email TEXT,
    idcliente INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (idcliente) REFERENCES clientes(id) ON DELETE CASCADE
);