-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Set-2022 às 09:27
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `food`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'pizza', 'pizza', 1, '2022-09-02 03:31:07', '2022-09-02 03:31:07', NULL),
(2, 'bebidas', 'bebidas', 1, '2022-09-04 16:07:41', '2022-09-04 16:07:41', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entregadores`
--

CREATE TABLE `entregadores` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `cnh` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(240) NOT NULL,
  `imagem` varchar(240) DEFAULT NULL,
  `veiculo` varchar(240) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `entregadores`
--

INSERT INTO `entregadores` (`id`, `nome`, `cpf`, `cnh`, `email`, `telefone`, `endereco`, `imagem`, `veiculo`, `placa`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'antonio ', '618.263.273-98', '99647575743', 'antoniodaleo@outlook.com', '(85) 9886-0128', 'rua araujo torreao', NULL, 'chevrolet', 'IAI-6179', 1, '2022-09-11 17:29:43', '2022-09-12 17:29:37', NULL),
(2, 'antonio daleo ', '790.385.210-81', '19481123906', 'antoniodaleoa@outlook.com', '(85) 8860-1287', 'rua joao', '1663022655_33ebcd35a99461e37953.jpg', 'ASTON MARTIN', 'HUV-8522', 1, '2022-09-12 19:26:02', '2022-09-12 19:44:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `extras`
--

CREATE TABLE `extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `extras`
--

INSERT INTO `extras` (`id`, `nome`, `slug`, `preco`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'catupirys', 'catupirys', '1.00', 'creama de catupiry', 1, '2022-09-02 03:37:09', '2022-09-03 21:21:56', NULL),
(3, 'ketchup', 'ketchup', '1.00', 'Bustina de ketcvup de 10gr\r\n', 1, '2022-09-05 19:59:23', '2022-09-05 19:59:48', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`id`, `nome`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Dinheiro', 1, '2022-09-08 20:06:58', '2022-09-08 20:06:58', NULL),
(2, 'Cartão de credito', 1, '2022-09-11 06:16:55', '2022-09-11 17:15:40', NULL),
(3, 'Pix', 1, '2022-09-11 06:46:10', '2022-09-11 17:15:19', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidas`
--

CREATE TABLE `medidas` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `medidas`
--

INSERT INTO `medidas` (`id`, `nome`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'pizza grande 40 ', 'pizza grande 20 fatias', 1, '2022-09-04 05:47:56', '2022-09-08 03:11:21', NULL),
(2, 'pizza media 8s fatias', 'pizza de 88', 1, '2022-09-04 08:41:47', '2022-09-04 08:56:28', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(2, '2022-08-31-193833', 'App\\Database\\Migrations\\CriaTabelaUsuarios', 'default', 'App', 1661975566, 1),
(5, '2022-09-01-225623', 'App\\Database\\Migrations\\CriaTabelaCategorias', 'default', 'App', 1662100228, 2),
(6, '2022-09-02-062718', 'App\\Database\\Migrations\\CriaTabelaExtra', 'default', 'App', 1662100228, 2),
(7, '2022-09-02-063632', 'App\\Database\\Migrations\\CriaTabelaExtra', 'default', 'App', 1662100614, 3),
(8, '2022-09-04-084614', 'App\\Database\\Migrations\\CriaTabelaMedidas', 'default', 'App', 1662281252, 4),
(9, '2022-09-04-121725', 'App\\Database\\Migrations\\CriaTabelaProdutos', 'default', 'App', 1662294383, 5),
(10, '2022-09-04-215924', 'App\\Database\\Migrations\\CriaTabelaProdutosExtras', 'default', 'App', 1662329020, 6),
(11, '2022-09-05-230127', 'App\\Database\\Migrations\\CriaTabelaProdutosEspecificacoes', 'default', 'App', 1662419177, 7),
(12, '2022-09-08-224900', 'App\\Database\\Migrations\\CriaTabelaFormasPagamento', 'default', 'App', 1662677531, 8),
(13, '2022-09-11-202227', 'App\\Database\\Migrations\\CriaTabelaEntregadores', 'default', 'App', 1662928125, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(5) UNSIGNED NOT NULL,
  `categoria_id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ingredientes` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `imagem` varchar(200) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `slug`, `ingredientes`, `ativo`, `imagem`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 1, 'Margherita', 'margherita', 'Molho de tomate, mussarela, manjericão', 1, '1662318125_c61f48821917b8182fce.jpg', '2022-09-04 09:29:28', '2022-09-04 16:02:05', NULL),
(2, 1, 'Bresaola e Rucola', 'bresaola-e-rucola', 'Pizza com bresaola, rucola, mussarela, e manjericão ', 1, '1662318355_8e436440464de69df068.jpg', '2022-09-04 11:03:17', '2022-09-04 16:07:22', NULL),
(3, 2, 'Coca-Cola', 'coca-cola', 'Latina de coca cola de 300ml', 1, '', '2022-09-04 16:08:35', '2022-09-08 18:07:13', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_especificacoes`
--

CREATE TABLE `produtos_especificacoes` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `medida_id` int(5) UNSIGNED NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `customizavel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_extras`
--

CREATE TABLE `produtos_extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `extra_id` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos_extras`
--

INSERT INTO `produtos_extras` (`id`, `produto_id`, `extra_id`) VALUES
(1, 1, 1),
(5, 2, 3),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `ativacao_hash` varchar(64) DEFAULT NULL,
  `reset_hash` varchar(64) DEFAULT NULL,
  `reset_expira_em` datetime DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `telefone`, `is_admin`, `ativo`, `password_hash`, `ativacao_hash`, `reset_hash`, `reset_expira_em`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Antonio Daleo', 'antoniodaleo@outlook.com', '618.263.273-98', '(85) 9891-1899', 1, 1, '$2y$10$Jjqh1ayF3gg5fp0CrXt1C.0Hy05ptaM9vP4Dr65r8mBdFQGE0jYAW', NULL, 'ba2bde2732abad0699a842d6b1f00af2619d82fd1c0b381ab3d6bfbaee0d0547', '2022-09-01 21:47:45', '2022-08-30 17:43:55', '2022-09-01 19:47:45', NULL),
(2, 'Letycia Lobato', 'letylobato@gmail.com', '393.109.653-04', '(85) 9891-1892', 0, 1, '$2y$10$jMIhzTQKnHR/3SMgrnjc/uKI9AZmingS/al3mrMbUWDPGqXCGsleG', NULL, NULL, NULL, '2022-08-29 17:44:30', '2022-08-31 20:16:42', NULL),
(3, 'Gabriel Daleo ', 'gabrieldaleo@gmail.com', '547.314.740-27', '(85) 9886-7123', 0, 1, '$2y$10$wvkoF70QaO6lo/6lgEX8Xep.h9ezLE/AdgxJpwWkEWFzcs4DNlm0K', NULL, NULL, NULL, '2022-08-31 20:17:55', '2022-09-01 19:23:28', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `entregadores`
--
ALTER TABLE `entregadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnh` (`cnh`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`);

--
-- Índices para tabela `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `produtos_categoria_id_foreign` (`categoria_id`);

--
-- Índices para tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_especificacoes_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_especificacoes_medida_id_foreign` (`medida_id`);

--
-- Índices para tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_extras_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_extras_extra_id_foreign` (`extra_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `ativacao_hash` (`ativacao_hash`),
  ADD UNIQUE KEY `reset_hash` (`reset_hash`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `entregadores`
--
ALTER TABLE `entregadores`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Limitadores para a tabela `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD CONSTRAINT `produtos_especificacoes_medida_id_foreign` FOREIGN KEY (`medida_id`) REFERENCES `medidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_especificacoes_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD CONSTRAINT `produtos_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_extras_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
