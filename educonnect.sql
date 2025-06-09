CREATE DATABASE educonnect;
USE educonnect;

-- Tabela principal de autenticação
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('aluno', 'educador', 'admin')  NOT NULL,
  educoins INT NOT NULL DEFAULT 0
);

-- Detalhes dos alunos
CREATE TABLE alunos (
  usuario_id INT PRIMARY KEY,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Detalhes dos educadores
CREATE TABLE educadores (
  usuario_id INT PRIMARY KEY,
  materia VARCHAR(100),
  bairro VARCHAR(100),
  cidade VARCHAR(100),
  avaliacao DECIMAL(2,1),
  foto VARCHAR(255),
  -- novo
  valor_hora DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  descricao TEXT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Detalhes dos admins
CREATE TABLE admins (
  usuario_id INT PRIMARY KEY,
  nivel_acesso INT DEFAULT 1,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Agendamentos conectando aluno a educador
CREATE TABLE agendamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aluno_id INT,
  educador_id INT,
  data DATETIME,
  FOREIGN KEY (aluno_id) REFERENCES usuarios(id),
  FOREIGN KEY (educador_id) REFERENCES usuarios(id)
);

select * from usuarios;
select * from alunos;
select * from educadores;
select * from admins;
select * from agendamentos;

show tables;

SELECT * FROM agendamentos;

INSERT INTO usuarios (nome, email, senha, tipo, educoins) VALUES
('Ana Souza', 'ana.souza@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Bruno Lima', 'bruno.lima@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Carla Mendes', 'carla.mendes@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Daniel Costa', 'daniel.costa@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Eduarda Rocha', 'eduarda.rocha@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Fernando Silva', 'fernando.silva@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Gabriela Pinto', 'gabriela.pinto@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Henrique Dias', 'henrique.dias@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Isabela Faria', 'isabela.faria@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('João Pedro', 'joao.pedro@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Karla Nunes', 'karla.nunes@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Lucas Martins', 'lucas.martins@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Mariana Gomes', 'mariana.gomes@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Nicolas Alves', 'nicolas.alves@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0),
('Olívia Teixeira', 'olivia.teixeira@example.com', '$2y$10$8gACGMbtoqCrCTkzW601Nee9rBsB.Lq5nLwoQd1HxHbRoJJR.f0nO', 'educador', 0);


INSERT INTO educadores (usuario_id, materia, bairro, cidade, avaliacao, foto, valor_hora, descricao) VALUES
(3, 'Matemática', 'Centro', 'São Paulo', 0.0, NULL, 100.00, 'Educador experiente em matemática básica e avançada.'),
(4, 'Português', 'Copacabana', 'Rio de Janeiro', 0.0, NULL, 100.00, 'Especialista em gramática e redação para ENEM.'),
(5, 'Física', 'Savassi', 'Belo Horizonte', 0.0, NULL, 100.00, 'Foco em física do ensino médio e vestibulares.'),
(6, 'Química', 'Boa Viagem', 'Recife', 0.0, NULL, 100.00, 'Aulas práticas e teóricas de química.'),
(7, 'Biologia', 'Asa Sul', 'Brasília', 0.0, NULL, 100.00, 'Explicações claras para biologia celular e humana.'),
(8, 'Inglês', 'Jardins', 'São Paulo', 0.0, NULL, 100.00, 'Aulas de inglês do básico ao avançado.'),
(9, 'História', 'Batel', 'Curitiba', 0.0, NULL, 100.00, 'História geral e do Brasil para concursos.'),
(10, 'Geografia', 'Meireles', 'Fortaleza', 0.0, NULL, 100.00, 'Compreensão geográfica com mapas e atualidades.'),
(11, 'Redação', 'Centro', 'Salvador', 0.0, NULL, 100.00, 'Técnicas de escrita e correção de redações.'),
(12, 'Literatura', 'Trindade', 'Florianópolis', 0.0, NULL, 100.00, 'Aulas com foco em análise literária e interpretação.'),
(13, 'Filosofia', 'Praia do Canto', 'Vitória', 0.0, NULL, 100.00, 'Discussões e estudos filosóficos modernos e clássicos.'),
(14, 'Sociologia', 'Centro', 'Campinas', 0.0, NULL, 100.00, 'Sociologia para o ensino médio e vestibular.'),
(15, 'Artes', 'Centro', 'Belém', 0.0, NULL, 100.00, 'Introdução às artes visuais e história da arte.'),
(16, 'Educação Física', 'Moinhos de Vento', 'Porto Alegre', 0.0, NULL, 100.00, 'Teoria e prática para desenvolvimento corporal.'),
(17, 'Espanhol', 'Ponta Verde', 'Maceió', 0.0, NULL, 100.00, 'Conversação e gramática em espanhol.');


