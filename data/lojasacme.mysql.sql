-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 18-Fev-2019 às 09:09
-- Versão do servidor: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acme`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` INTEGER NOT NULL,
  `produto_id` INTEGER NOT NULL,
  `valor` double NOT NULL,
  `quantidade` INTEGER NOT NULL,
   PRIMARY KEY (`id`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` text
   PRIMARY KEY (`id`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `valor` double NOT NULL,
  `quantidade` int(11) NOT NULL,
   PRIMARY KEY (`id`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,   
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
   PRIMARY KEY (`id`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Insere alguns produtos
--

INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('extrato de energia volátil',10.45,30);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('pílula de nanicolina',2.99,20);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('marreta biônica',54.89,7);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('peruca de sansão',23.65,10);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('manopla do infinito',278.90,1);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('bateria energética',74.23,7200);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('espada de ébano',199.99,12);
INSERT INTO `produtos` (`nome`,`valor`,`quantidade`) VALUES ('guia do mochileiro das galáxias',32.99,150);
