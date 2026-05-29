-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2026 às 21:19
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `heartsushi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(56) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `ds_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `ds_image`) VALUES
(1, 'Hot roll supremo', 'hot roll com topping de salmão folhado a ouro', 78.55, '6a19dee066a15_hot-roll.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ds_image` (`ds_image`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- PARA OTIMIZAR E POUPAR TEMPO, AQUI A ESTRUTURA DE DADOS COM OS INSERT DA TABELA

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT,
  `preco` DECIMAL(10,2) NOT NULL,
  `ds_image` VARCHAR(255) DEFAULT 'not_image.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Dados Iniciais Fixos (O segredo para o professor já ver tudo funcionando)
INSERT INTO `produtos` (`nome`, `descricao`, `preco`, `ds_image`) VALUES
('Temaki Especial', 'Salmão em cubos, cream cheese e cebolinha wrapped em alga crocante.', 29.90, 'Hot rol.jpg'),
('Uramaki Filadélfia', 'Roll invertido de arroz com gergelim, recheio de salmão e cream cheese.', 24.50, 'not_image.png'),
('Combinado Omakase', 'Seleção especial do chef com 15 peças variadas de alta qualidade.', 89.90, 'temaki.jpg');