CREATE database fatec;

use fatec;

USE fatec;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    perfil ENUM('usuario', 'administrador', 'administrador_supremo') NOT NULL
);

-- update usuarios set perfil = 'AdmiNisTrador_sUpReMo' where id_usuario = 4;

-- select * from usuarios;
-- select * from reserva;
-- SELECT * FROM reserva WHERE id_usuario = 2;

-- Tabela de Equipamentos
CREATE TABLE equipamentos (
    id_equipamento INT AUTO_INCREMENT PRIMARY KEY,
    nome_equipamento VARCHAR(144) NOT NULL,
    descricao_equipamento VARCHAR(144) NOT NULL,
    quantidade_equipamento INT CHECK (quantidade_equipamento > 0) NOT NULL
);

-- Tabela de Softwares
CREATE TABLE software (
    id_software INT AUTO_INCREMENT PRIMARY KEY,
    nome_software VARCHAR(100) NOT NULL,
    versao_software VARCHAR(50) NOT NULL,
    descricao_software VARCHAR(100),
    preco_software DECIMAL(10, 2) NULL
);

-- Tabela Intermediária para Equipamentos e Softwares
CREATE TABLE equipamento_software (
    id_equipamento INT,
    id_software INT,
    PRIMARY KEY (id_equipamento, id_software),
    FOREIGN KEY (id_equipamento) REFERENCES equipamentos(id_equipamento),
    FOREIGN KEY (id_software) REFERENCES software(id_software)
);

-- Tabela de Salas
CREATE TABLE sala(
    id_sala INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome_sala VARCHAR(50) UNIQUE NOT NULL,
    numero_sala INTEGER,
    capacidade_sala INTEGER,
    id_equipamento INTEGER,
    FOREIGN KEY (id_equipamento) REFERENCES equipamentos(id_equipamento)
 );


-- Tabela Intermediária para Salas e Equipamentos
CREATE TABLE sala_equipamento (
    id_sala INT,
    id_equipamento INT,
    PRIMARY KEY (id_sala, id_equipamento),
    FOREIGN KEY (id_sala) REFERENCES sala(id_sala),
    FOREIGN KEY (id_equipamento) REFERENCES equipamentos(id_equipamento)
);

-- Tabela de Movimentação de Equipamentos
CREATE TABLE movimentacao_equipamentos (
    id_mov_equipamento INT AUTO_INCREMENT PRIMARY KEY,
    data_mov_equipamento TIMESTAMP NOT NULL,
    quantidade_mov_equipamento INT NOT NULL,
    previsao_retorno_equipamento TIMESTAMP NULL,
    valor_manutencao DECIMAL(10, 2) NULL,
    observacao_mov_equipamento VARCHAR(120) NULL,
    id_equipamento INT NOT NULL,
    FOREIGN KEY (id_equipamento) REFERENCES equipamentos(id_equipamento)
);

-- Tabela de Reservas
CREATE TABLE reserva (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    destinatario_reserva VARCHAR(120) NULL,
    observacao VARCHAR(120) NULL,
    data_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    horario_inicio TIMESTAMP NOT NULL,
    horario_fim TIMESTAMP NOT NULL,
    status ENUM('pendente', 'confirmada', 'cancelada') DEFAULT 'pendente',
    id_usuario INT NOT NULL,
    nome_sala VARCHAR(144) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (nome_sala) REFERENCES sala(nome_sala)
);

INSERT INTO usuarios (nome_usuario, login, senha, email, perfil) VALUES
('Daniel Rodrigues', 'daniel', '123', 'danel@example.com', 'administrador_supremo'),
('Cecilia Prado', 'cecilia', '123', 'cecilia@example.com', 'administrador');

INSERT INTO equipamentos (nome_equipamento, descricao_equipamento, quantidade_equipamento) VALUES
('Notebook', 'Notebook Dell Inspiron', 10),
('Projetor', 'Projetor Epson', 5);

INSERT INTO software (nome_software, versao_software, descricao_software, preco_software) VALUES
('Microsoft Office', '2019', 'Pacote Office completo', 299.99),
('Adobe Photoshop', '2021', 'Editor de imagens', 499.99);

INSERT INTO equipamento_software (id_equipamento, id_software) VALUES
(1, 1),  -- Notebook com Microsoft Office
(1, 2),  -- Notebook com Adobe Photoshop
(2, 1);  -- Projetor com Microsoft Office

INSERT INTO sala (numero_sala, capacidade_sala, id_equipamento, nome_sala) VALUES
(101, 20, 1, 'Sala 1'),
(102, 30, 2, 'Sala 2');

INSERT INTO sala_equipamento (id_sala, id_equipamento) VALUES
(1, 1),  -- Sala 101 com Notebook
(1, 2),  -- Sala 101 com Projetor
(2, 1);  -- Sala 102 com Notebook

INSERT INTO movimentacao_equipamentos (data_mov_equipamento, quantidade_mov_equipamento, previsao_retorno_equipamento, valor_manutencao, observacao_mov_equipamento, id_equipamento) VALUES
('2023-05-01 10:00:00', 2, '2023-05-10 10:00:00', 50.00, 'Manutenção preventiva', 1),
('2023-05-02 11:00:00', 1, '2023-05-12 11:00:00', 30.00, 'Reparação do projetor', 2);

INSERT INTO reserva (destinatario_reserva, observacao, horario_inicio, horario_fim, id_usuario, nome_sala) VALUES
('Evento Corporativo', 'Reserva para reunião',  '2023-05-10 10:00:00', '2023-05-10  12:00:00', 1, 'Sala 1'),
('Treinamento', 'Treinamento de novos funcionários',  '2023-05-10 10:00:00', '2023-05-10  12:00:00', 2, 'Sala 2');

-- INSERT INTO reserva (destinatario_reserva, observacao, horario_inicio, horario_fim, id_usuario, nome_sala) VALUES (':destinatario', ':observacao', '2023-05-10 09:00:00', '2023-05-10 09:00:00', 1, 'Sala 2');