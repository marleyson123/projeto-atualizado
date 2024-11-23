<!-- -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/11/2024 às 21:07
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `educamentes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `matricula` int(11) NOT NULL,
  `nome` varchar(225) NOT NULL,
  `ano_ingresso` year(4) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `tipo_sanguineo` varchar(45) DEFAULT NULL,
  `deficiencia` varchar(255) DEFAULT NULL,
  `alergia` varchar(255) DEFAULT NULL,
  `nome_mae` varchar(105) DEFAULT NULL,
  `id_responsavel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`matricula`, `nome`, `ano_ingresso`, `data_nascimento`, `tipo_sanguineo`, `deficiencia`, `alergia`, `nome_mae`, `id_responsavel`) VALUES
(15, 'Julia Martins da silva', '2015', '2024-11-25', 'B+', 'TDAH', 'amendoin', 'João Lucas Barreto ', 46),
(16, 'Laura Cardoso', '2015', '2541-12-12', 'AB+', 'nula', 'nula', 'João Lucas Barreto ', 46),
(17, 'Vitória Cristina Martins e Martins', '2024', '2024-02-15', 'A-', 'nula', 'nula', 'João Lucas Barreto ', 46);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastroadm`
--

CREATE TABLE `cadastroadm` (
  `id_Adm` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastroadm`
--

INSERT INTO `cadastroadm` (`id_Adm`, `nome`, `email`, `senha`, `foto`) VALUES
(1, 'Vitória Martins', 'vihmartins330@gmail.com', '2525', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id_professor` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `responsaveis`
--

CREATE TABLE `responsaveis` (
  `id_responsavel` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `responsaveis`
--

INSERT INTO `responsaveis` (`id_responsavel`, `usuario_id`) VALUES
(46, 56);

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

CREATE TABLE `turma` (
  `idTurma` int(11) NOT NULL,
  `nome_turma` varchar(45) NOT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `turno` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `cpf`, `perfil`, `senha`) VALUES
(56, 'João Lucas Barreto ', 'joao.pereira@email.com', '666.666.666-66', 'responsavel', '0000');

--
-- Acionadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `atualiza_nome_mae` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    UPDATE aluno
    SET nome_mae = NEW.nome -- Substitua 'nome_completo' pelo nome correto da coluna da tabela 'usuarios'
    WHERE id_responsavel = (
        SELECT id_responsavel
        FROM responsaveis
        WHERE usuario_id = NEW.id_usuario
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `atualizar_nome_responsavel` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    -- Atualiza o nome do responsável na tabela aluno com base no id_responsavel
    UPDATE aluno
    SET nome_mae = NEW.nome  -- Supondo que o nome do responsável vai para o campo nome_mae
    WHERE id_responsavel = NEW.id_usuario;  -- Atualiza o registro do aluno que possui este responsável
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `professor_para_responsavel` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.perfil = 'responsavel' AND OLD.perfil = 'professor' THEN
        -- Insere na tabela responsavel
        INSERT INTO responsaveis (usuario_id) VALUES (NEW.id_usuario);
        
        -- Remove da tabela professor, se necessário
        DELETE FROM professores WHERE usuario_id = NEW.id_usuario;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `responsavel_para_professor` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.perfil = 'professor' AND OLD.perfil = 'responsavel' THEN
        -- Insere na tabela professor
        INSERT INTO professores (usuario_id) VALUES (NEW.id_usuario);
        
        -- Remove da tabela responsavel, se necessário
        DELETE FROM responsaveis WHERE usuario_id = NEW.id_usuario;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `fk_responsavel_id` (`id_responsavel`);

--
-- Índices de tabela `cadastroadm`
--
ALTER TABLE `cadastroadm`
  ADD PRIMARY KEY (`id_Adm`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id_professor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD PRIMARY KEY (`id_responsavel`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

--
-- Índices de tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`idTurma`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `cadastroadm`
--
ALTER TABLE `cadastroadm`
  MODIFY `id_Adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  MODIFY `id_responsavel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `idTurma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis` (`id_responsavel`);

--
-- Restrições para tabelas `professores`
--
ALTER TABLE `professores`
  ADD CONSTRAINT `professores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD CONSTRAINT `responsaveis_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; -->
