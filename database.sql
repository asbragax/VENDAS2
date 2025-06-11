-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2025 às 12:20
-- Versão do servidor: 10.11.10-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u196872095_janaina`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `apagar`
--

CREATE TABLE `apagar` (
  `id` bigint(50) NOT NULL,
  `fornecedor` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `vencimento` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `data_pag` date DEFAULT NULL,
  `forma_pag` int(11) DEFAULT NULL,
  `tipo_pag` int(1) DEFAULT NULL,
  `conta_pag` varchar(30) DEFAULT NULL,
  `prestacao` int(11) NOT NULL DEFAULT 1,
  `valorprestacao` int(11) NOT NULL,
  `arquivo_nota` varchar(255) DEFAULT NULL,
  `arquivo_boleto` varchar(255) DEFAULT NULL,
  `arquivo_recibo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `apagar_parcela`
--

CREATE TABLE `apagar_parcela` (
  `id` bigint(60) NOT NULL,
  `id_apagar` bigint(50) NOT NULL,
  `num` int(4) NOT NULL,
  `valor` int(11) NOT NULL,
  `vencimento` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `arquivo_recibo` varchar(255) DEFAULT NULL,
  `forma_pag` int(1) DEFAULT NULL,
  `conta_pag` varchar(30) DEFAULT NULL,
  `data_pag` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conta_caixa`
--

CREATE TABLE `conta_caixa` (
  `id` varchar(30) NOT NULL,
  `id_reduzido` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `natureza` char(2) NOT NULL DEFAULT 'd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conta_receita`
--

CREATE TABLE `conta_receita` (
  `id_auto` int(10) UNSIGNED NOT NULL,
  `id` varchar(30) NOT NULL,
  `id_reduzido` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `natureza` char(2) NOT NULL DEFAULT 'c'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `crediario_pagamento`
--

CREATE TABLE `crediario_pagamento` (
  `id` bigint(50) NOT NULL,
  `id_crediario` bigint(20) NOT NULL,
  `data_pag` date DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `forma_pag` int(2) DEFAULT NULL,
  `valor_pag` int(11) NOT NULL DEFAULT 0,
  `juros` int(11) NOT NULL DEFAULT 0,
  `observacao` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cnpj` varchar(25) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `rua` varchar(150) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(150) DEFAULT NULL,
  `cidade` varchar(150) DEFAULT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `members`
--

CREATE TABLE `members` (
  `id` char(23) NOT NULL,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `nivel` tinyint(3) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `img` varchar(4) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 1,
  `mod_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estrutura para tabela `member_login`
--

CREATE TABLE `member_login` (
  `id_member` varchar(35) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel`
--

CREATE TABLE `nivel` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel_acesso`
--

CREATE TABLE `nivel_acesso` (
  `id_nivel` int(11) NOT NULL,
  `financeiro` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `aula` int(11) NOT NULL,
  `calendario` int(11) NOT NULL,
  `relatorios` int(11) NOT NULL,
  `membro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota`
--

CREATE TABLE `nota` (
  `id_auto` bigint(20) UNSIGNED NOT NULL,
  `id` varchar(60) NOT NULL,
  `data` date NOT NULL,
  `fornecedor` int(11) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `numero` varchar(100) DEFAULT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `flag` int(1) NOT NULL DEFAULT 0,
  `user` varchar(35) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `user_mod` varchar(35) DEFAULT NULL,
  `time_mod` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_produto`
--

CREATE TABLE `nota_produto` (
  `id` bigint(20) NOT NULL,
  `id_nota` varchar(60) NOT NULL,
  `id_produto` varchar(50) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `grade` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_produto_grade`
--

CREATE TABLE `nota_produto_grade` (
  `nota` varchar(60) NOT NULL,
  `id` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id` varchar(35) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `apelido` varchar(50) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL DEFAULT 'm',
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(80) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `user` varchar(35) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_mod` varchar(35) DEFAULT NULL,
  `time_mod` timestamp NULL DEFAULT NULL,
  `id_auto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_crediario`
--

CREATE TABLE `pessoa_crediario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pessoa` varchar(50) NOT NULL,
  `id_venda` varchar(50) NOT NULL,
  `id_pag` int(2) NOT NULL DEFAULT 0,
  `pag` int(2) DEFAULT 0,
  `valor` int(11) NOT NULL DEFAULT 0,
  `valor_pag` int(11) NOT NULL DEFAULT 0,
  `parcelado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `texto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `prevenda`
--

CREATE TABLE `prevenda` (
  `id` varchar(60) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `valor_compra` int(11) NOT NULL DEFAULT 0,
  `comissao` int(1) NOT NULL DEFAULT 0,
  `valor_comissao` int(11) NOT NULL DEFAULT 0,
  `data` date DEFAULT NULL,
  `forma_pag` tinyint(2) DEFAULT NULL,
  `pag` tinyint(1) DEFAULT 0,
  `desconto` int(11) DEFAULT 0,
  `cliente` varchar(100) NOT NULL,
  `vendedor` varchar(50) NOT NULL,
  `entrega` tinyint(1) NOT NULL DEFAULT 0,
  `endereco` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `user` varchar(35) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_mod` varchar(35) DEFAULT NULL,
  `time_mod` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `prevenda_produto`
--

CREATE TABLE `prevenda_produto` (
  `id` bigint(20) NOT NULL,
  `id_venda` varchar(60) NOT NULL,
  `id_produto` varchar(50) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `tamanho` varchar(30) NOT NULL,
  `valor_unit` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `cor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` varchar(50) NOT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `estoque` int(11) NOT NULL,
  `valor_compra` int(11) NOT NULL,
  `valor_venda` int(11) NOT NULL,
  `valor_atacado` int(11) NOT NULL DEFAULT 0,
  `sociedade` int(1) NOT NULL DEFAULT 0,
  `grade` int(2) NOT NULL DEFAULT 0,
  `categoria` int(11) NOT NULL DEFAULT 0,
  `gender` varchar(1) NOT NULL DEFAULT 'f',
  `user` varchar(35) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `usermod` varchar(35) DEFAULT NULL,
  `timemod` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_cor`
--

CREATE TABLE `produto_cor` (
  `id` varchar(50) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_foto`
--

CREATE TABLE `produto_foto` (
  `id_produto` varchar(50) NOT NULL,
  `id_foto` bigint(20) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `main` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_grade`
--

CREATE TABLE `produto_grade` (
  `id` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id` bigint(60) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `valor_compra` int(11) NOT NULL DEFAULT 0,
  `comissao` int(1) NOT NULL DEFAULT 0,
  `valor_comissao` int(11) NOT NULL DEFAULT 0,
  `data` date DEFAULT NULL,
  `forma_pag` tinyint(2) DEFAULT NULL,
  `pag` tinyint(1) DEFAULT 0,
  `desconto` int(11) DEFAULT 0,
  `cliente` varchar(100) NOT NULL,
  `vendedor` varchar(50) NOT NULL,
  `entrega` tinyint(1) NOT NULL DEFAULT 0,
  `endereco` varchar(255) DEFAULT NULL,
  `prevenda` tinyint(1) DEFAULT 0,
  `sociedade` int(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `user` varchar(35) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_mod` varchar(35) DEFAULT NULL,
  `time_mod` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda_pagamento`
--

CREATE TABLE `venda_pagamento` (
  `id` bigint(20) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda_produto`
--

CREATE TABLE `venda_produto` (
  `id` bigint(20) NOT NULL,
  `id_venda` bigint(20) NOT NULL,
  `id_produto` varchar(50) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `tamanho` varchar(30) NOT NULL,
  `valor_unit` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `valor_compra` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `apagar`
--
ALTER TABLE `apagar`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `apagar_parcela`
--
ALTER TABLE `apagar_parcela`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_apagar` (`id_apagar`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conta_caixa`
--
ALTER TABLE `conta_caixa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conta_receita`
--
ALTER TABLE `conta_receita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_auto` (`id_auto`);

--
-- Índices de tabela `crediario_pagamento`
--
ALTER TABLE `crediario_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Índices de tabela `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_auto` (`id_auto`);

--
-- Índices de tabela `nota_produto`
--
ALTER TABLE `nota_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nota_produto_grade`
--
ALTER TABLE `nota_produto_grade`
  ADD PRIMARY KEY (`nota`,`id`,`tipo`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_auto` (`id_auto`);

--
-- Índices de tabela `pessoa_crediario`
--
ALTER TABLE `pessoa_crediario`
  ADD PRIMARY KEY (`id_pessoa`,`id_venda`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `prevenda`
--
ALTER TABLE `prevenda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `prevenda_produto`
--
ALTER TABLE `prevenda_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto_cor`
--
ALTER TABLE `produto_cor`
  ADD PRIMARY KEY (`id`,`cor`);

--
-- Índices de tabela `produto_foto`
--
ALTER TABLE `produto_foto`
  ADD PRIMARY KEY (`id_foto`);

--
-- Índices de tabela `produto_grade`
--
ALTER TABLE `produto_grade`
  ADD PRIMARY KEY (`id`,`tipo`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `venda_pagamento`
--
ALTER TABLE `venda_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `apagar`
--
ALTER TABLE `apagar`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `apagar_parcela`
--
ALTER TABLE `apagar_parcela`
  MODIFY `id` bigint(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conta_receita`
--
ALTER TABLE `conta_receita`
  MODIFY `id_auto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `crediario_pagamento`
--
ALTER TABLE `crediario_pagamento`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nota`
--
ALTER TABLE `nota`
  MODIFY `id_auto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nota_produto`
--
ALTER TABLE `nota_produto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_auto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoa_crediario`
--
ALTER TABLE `pessoa_crediario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `prevenda_produto`
--
ALTER TABLE `prevenda_produto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto_foto`
--
ALTER TABLE `produto_foto`
  MODIFY `id_foto` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` bigint(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda_pagamento`
--
ALTER TABLE `venda_pagamento`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
