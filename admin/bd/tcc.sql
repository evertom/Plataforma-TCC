-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Nov-2015 às 16:55
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tcc`
--
CREATE DATABASE IF NOT EXISTS `tcc` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tcc`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

DROP TABLE IF EXISTS `arquivos`;
CREATE TABLE IF NOT EXISTS `arquivos` (
  `idArquivo` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nome` varchar(300) COLLATE utf32_unicode_ci NOT NULL,
  `caminho` varchar(300) COLLATE utf32_unicode_ci NOT NULL,
  `dtaEnvio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `versao_u` smallint(6) NOT NULL DEFAULT '0',
  `versao_d` smallint(6) NOT NULL DEFAULT '0',
  `versao_c` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idArquivo`),
  KEY `idgrupo` (`idgrupo`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci COMMENT='tabela de arquivos enviados' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atadefesa`
--

DROP TABLE IF EXISTS `atadefesa`;
CREATE TABLE IF NOT EXISTS `atadefesa` (
  `idAtaDefesa` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NOT NULL,
  `titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `prof1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `prof2` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `prof3` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `dia` date NOT NULL,
  `hora` time NOT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0=não visto / 1=aprovado / 2=reprovado',
  `nota` decimal(10,2) DEFAULT '0.00',
  `disponibilizar` int(11) DEFAULT '0' COMMENT '0=não / 1=sim',
  `arqFinal` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idAtaDefesa`),
  KEY `idgrupo` (`idgrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `atadefesa`
--

INSERT INTO `atadefesa` (`idAtaDefesa`, `idgrupo`, `titulo`, `prof1`, `prof2`, `prof3`, `dia`, `hora`, `status`, `nota`, `disponibilizar`, `arqFinal`) VALUES
(1, 13, 'Plataforma de Gerenciamento de TCC', 'Ana Giancoli', 'Eliane Andreoli', 'Flavio César Amate', '2015-12-10', '19:00:00', 1, '10.00', 1, 'GerenciamentoGrupos/ArquivoFinal/plataforma-de-gerenciamento-de-tcc.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

DROP TABLE IF EXISTS `avisos`;
CREATE TABLE IF NOT EXISTS `avisos` (
  `idavisos` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8_unicode_ci,
  `data` date DEFAULT NULL,
  `visto` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `de` int(11) NOT NULL,
  PRIMARY KEY (`idavisos`),
  KEY `fk_avisos_users1_idx1` (`uid`),
  KEY `fk_avisos_users2_idx` (`de`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`idavisos`, `descricao`, `data`, `visto`, `uid`, `de`) VALUES
(10, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-11-11', '1', 12, 4),
(11, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-11', '1', 4, 12),
(12, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-11', '0', 6, 12),
(13, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-11', '1', 7, 12),
(14, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-11-11', '1', 4, 12),
(15, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-11-11', '0', 6, 12),
(16, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-11-11', '1', 7, 12),
(17, 'O evento ''Aprovar'' com entrega prevista para 11-11-2015 foi adicionado, confira no cronograma!!!', '2015-11-11', '0', 6, 4),
(18, 'O evento ''Aprovar'' com entrega prevista para 11-11-2015 foi adicionado, confira no cronograma!!!', '2015-11-11', '1', 7, 4),
(19, 'O evento ''Aprovar'' com entrega prevista para 11-11-2015 foi adicionado, confira no cronograma!!!', '2015-11-11', '1', 12, 4),
(20, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-11-17', '1', 12, 9),
(21, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 8, 12),
(22, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 9, 12),
(23, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 17, 12),
(24, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 8, 12),
(25, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 9, 12),
(26, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-11-17', '0', 17, 12),
(27, 'O evento ''zcisn'' com entrega prevista para 02-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '0', 6, 4),
(28, 'O evento ''zcisn'' com entrega prevista para 02-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '1', 7, 4),
(29, 'O evento ''zcisn'' com entrega prevista para 02-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '1', 12, 4),
(30, 'O evento ''mxoscjz'' com entrega prevista para 31-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '0', 6, 4),
(31, 'O evento ''mxoscjz'' com entrega prevista para 31-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '1', 7, 4),
(32, 'O evento ''mxoscjz'' com entrega prevista para 31-12-2015 foi adicionado, confira no cronograma!!!', '2015-11-18', '1', 12, 4),
(33, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '1', 4, 12),
(34, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '0', 6, 12),
(35, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '0', 7, 12),
(36, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema', '2015-11-25', '0', 4, 12),
(37, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema', '2015-11-25', '0', 6, 12),
(38, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema', '2015-11-25', '0', 7, 12),
(39, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '0', 4, 12),
(40, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '0', 6, 12),
(41, 'Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema e disponibilizou o arquivo na plataforma para consulta.', '2015-11-25', '0', 7, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `msg_id_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `created` int(11) DEFAULT '1269249260',
  PRIMARY KEY (`com_id`),
  KEY `fk_comments_messages1_idx1` (`msg_id_fk`),
  KEY `fk_comments_users1_idx1` (`uid_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=116 ;

--
-- Extraindo dados da tabela `comments`
--

INSERT INTO `comments` (`com_id`, `comment`, `msg_id_fk`, `uid_fk`, `ip`, `created`) VALUES
(1, 'My first comment ', 1, 4, '127.0.0.1', 1305209833),
(26, 'Must watch ', 51, 6, '127.0.0.1', 1305483460),
(31, 'by Lee Tao', 59, 6, '127.0.0.1', 1305485714),
(53, 'agora parece que foi', 68, 4, '127.0.0.1', 1421373754),
(64, 'haha', 94, 6, '127.0.0.1', 1421375625),
(67, 'Parabéns, vc é o melhor do  melhor do mundo !! haha', 98, 6, '127.0.0.1', 1421377101),
(68, 'Obrigado, um dia te ensino *--* ', 98, 4, '127.0.0.1', 1421402450),
(69, 'Obrigado amigo <3', 98, 6, '127.0.0.1', 1421402490),
(70, 'da hora mesmo !!!', 99, 6, '127.0.0.1', 1421673796),
(71, 'lindo :D', 99, 7, '127.0.0.1', 1421674045),
(72, 'Parabéns manow (Y) muito bacana... haha', 99, 8, '127.0.0.1', 1421674945),
(77, 'Bacana haha', 99, 9, '127.0.0.1', 1427734173),
(78, 'Oi gata haha', 102, 10, '127.0.0.1', 1427734246),
(81, 'Botafogo meu amor, minha vidaaaa.. HAHA', 109, 17, '127.0.0.1', 1427927682),
(85, 'Aiii que tdooo, conte mais sobre esse seu sonho...', 112, 6, '127.0.0.1', 1428416301),
(86, 'Sé loko', 109, 6, '127.0.0.1', 1428416645),
(87, 'Pode fica pra outra semana...', 108, 6, '127.0.0.1', 1428416786),
(90, 'Hummmm, que isso digo.... HAHAHA', 112, 4, '127.0.0.1', 1428417320),
(93, 'HAHAHAHAHA', 108, 4, '127.0.0.1', 1428426661),
(94, 'Lokão haha', 104, 4, '127.0.0.1', 1428427125),
(100, '*--------* vlw minha gente <3', 99, 4, '127.0.0.1', 1428558221),
(105, 'Nosso grupo é o melhor do melhor do mundo... HAHAHAHA', 126, 4, '127.0.0.1', 1428559206),
(110, 'Paga pau em florzinha hahaha', 126, 7, '127.0.0.1', 1428785793),
(113, 'kjk', 125, 4, '127.0.0.1', 1432680365),
(114, 'oi gatinhaaa, casa comigo !!??? :D', 127, 15, '127.0.0.1', 1433370930);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronograma`
--

DROP TABLE IF EXISTS `cronograma`;
CREATE TABLE IF NOT EXISTS `cronograma` (
  `idcronograma` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NOT NULL,
  `aprovado` tinyint(1) NOT NULL DEFAULT '0',
  `analisando` tinyint(1) NOT NULL DEFAULT '0',
  `revisando` tinyint(1) NOT NULL DEFAULT '0',
  `enviado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idcronograma`),
  UNIQUE KEY `idgrupo` (`idgrupo`),
  KEY `idgrupo_2` (`idgrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `cronograma`
--

INSERT INTO `cronograma` (`idcronograma`, `idgrupo`, `aprovado`, `analisando`, `revisando`, `enviado`) VALUES
(1, 13, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `desistenciaaluno`
--

DROP TABLE IF EXISTS `desistenciaaluno`;
CREATE TABLE IF NOT EXISTS `desistenciaaluno` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `motivo` int(11) NOT NULL,
  `dataDesistencia` date NOT NULL,
  `descricao` text COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`idDesistencia`),
  KEY `idUsers` (`idUsers`),
  KEY `idGrupo` (`idGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `desistenciaprof`
--

DROP TABLE IF EXISTS `desistenciaprof`;
CREATE TABLE IF NOT EXISTS `desistenciaprof` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `dataDesistencia` date NOT NULL,
  `motivo` int(11) NOT NULL,
  PRIMARY KEY (`idDesistencia`),
  KEY `idUsers` (`idUsers`),
  KEY `idGrupo` (`idGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `idEvento` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `participantes` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT '1',
  `nomeEvento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `idcronograma` int(11) NOT NULL,
  `idTipoEvento` int(11) NOT NULL,
  `concluido` tinyint(1) NOT NULL DEFAULT '0',
  `data_conclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`idEvento`),
  KEY `idGrupo` (`idGrupo`,`idcronograma`),
  KEY `idcronograma` (`idcronograma`),
  KEY `idTipoEvento` (`idTipoEvento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`idEvento`, `idGrupo`, `participantes`, `start`, `end`, `allday`, `nomeEvento`, `descricao`, `idcronograma`, `idTipoEvento`, `concluido`, `data_conclusao`) VALUES
(1, 13, '7,12,6,4', '2015-11-11 00:00:00', '2015-11-11 00:00:00', 1, 'Aprovar', 'Aprovação', 1, 3, 0, NULL),
(2, 13, '7,12,6,4', '2015-11-25 00:00:00', '2015-12-02 00:00:00', 1, 'zcisn', 'sndijwisjz', 1, 3, 0, NULL),
(3, 13, '7,6,4', '2015-12-15 00:00:00', '2015-12-31 00:00:00', 1, 'mxoscjz', 'nscinsfc', 1, 4, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `idgrupo` int(11) NOT NULL AUTO_INCREMENT,
  `dataCriacao` date NOT NULL,
  `titulo` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `objetivoGeral` text COLLATE utf8_unicode_ci,
  `objetivoEspecifico` text COLLATE utf8_unicode_ci,
  `justificativa` text COLLATE utf8_unicode_ci,
  `tipodePesquisa` text COLLATE utf8_unicode_ci,
  `metodologia` text COLLATE utf8_unicode_ci,
  `resultadoEsperado` text COLLATE utf8_unicode_ci,
  `fraselema` text COLLATE utf8_unicode_ci,
  `aceito` int(1) NOT NULL DEFAULT '0' COMMENT 'representa se o professor aceitou ou não orientar esse grupo',
  `visto` int(1) NOT NULL DEFAULT '0' COMMENT 'representa se o professor visualizou o requerimento',
  `recusado` int(1) NOT NULL DEFAULT '0' COMMENT 'representa se o professor recusou ou não o grupo',
  `revisando` int(1) NOT NULL DEFAULT '0' COMMENT 'representa se a requisicao esta sendo reavaliada para maiores informações',
  `preProjeto` int(1) NOT NULL DEFAULT '0' COMMENT 'utilizado para controle de tela, para forçar o aluno a cadastrar o pre projeto',
  `cronograma` int(1) NOT NULL DEFAULT '0' COMMENT 'utilizado no controle de tela para forçar o aluno a cadastrar o cronograma apos o pre projeto',
  PRIMARY KEY (`idgrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`idgrupo`, `dataCriacao`, `titulo`, `descricao`, `objetivoGeral`, `objetivoEspecifico`, `justificativa`, `tipodePesquisa`, `metodologia`, `resultadoEsperado`, `fraselema`, `aceito`, `visto`, `recusado`, `revisando`, `preProjeto`, `cronograma`) VALUES
(13, '2015-11-11', 'Plataforma de Gerenciamento de TCC', 'Plataforma de Gerenciamento de TCC', 'hhhhldomowdms', 'h', 'h', 'haaaa', 'h', 'h', 'Você ainda não possui uma Frase Lema, dê um duplo clique aqui, e faça sua frase.', 1, 1, 0, 0, 0, 0),
(14, '2015-11-17', 'Cloud', 'cloud', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_has_users`
--

DROP TABLE IF EXISTS `grupo_has_users`;
CREATE TABLE IF NOT EXISTS `grupo_has_users` (
  `idgrupo` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `tipo` int(1) NOT NULL COMMENT 'representa o tipo do individuou 1=aluno,2=orientador,3=coorientador',
  PRIMARY KEY (`idgrupo`,`uid`),
  KEY `fk_grupo_has_users_users1_idx` (`uid`),
  KEY `fk_grupo_has_users_grupo_idx` (`idgrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `grupo_has_users`
--

INSERT INTO `grupo_has_users` (`idgrupo`, `uid`, `tipo`) VALUES
(13, 4, 1),
(13, 6, 1),
(13, 7, 1),
(13, 12, 2),
(14, 8, 1),
(14, 9, 1),
(14, 12, 2),
(14, 17, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `likecomment`
--

DROP TABLE IF EXISTS `likecomment`;
CREATE TABLE IF NOT EXISTS `likecomment` (
  `idLikeComment` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  PRIMARY KEY (`idLikeComment`),
  KEY `uid` (`uid`),
  KEY `Com_id` (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Extraindo dados da tabela `likecomment`
--

INSERT INTO `likecomment` (`idLikeComment`, `uid`, `com_id`) VALUES
(26, 4, 114);

-- --------------------------------------------------------

--
-- Estrutura da tabela `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `idlikes` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  PRIMARY KEY (`idlikes`),
  KEY `uid` (`uid`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Extraindo dados da tabela `likes`
--

INSERT INTO `likes` (`idlikes`, `uid`, `msg_id`) VALUES
(21, 6, 128),
(24, 6, 127),
(25, 6, 120),
(27, 17, 128),
(28, 17, 120),
(30, 12, 128),
(31, 8, 128),
(32, 9, 128),
(33, 9, 127),
(34, 15, 128),
(35, 4, 125),
(36, 17, 127),
(41, 4, 127),
(52, 4, 128),
(59, 4, 130);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `idMensagens` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text COLLATE utf8_unicode_ci,
  `data` datetime DEFAULT CURRENT_TIMESTAMP,
  `_from` int(11) DEFAULT NULL,
  `_to` int(11) DEFAULT NULL,
  `_read` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`idMensagens`),
  KEY `_from` (`_from`),
  KEY `_to` (`_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=128 ;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`idMensagens`, `msg`, `data`, `_from`, `_to`, `_read`) VALUES
(109, 'tom ???', '2015-10-25 00:48:21', 4, 6, 1),
(110, 'oi manolo', '2015-10-25 00:48:27', 6, 4, 1),
(111, 'fala ai', '2015-10-25 00:48:29', 6, 4, 1),
(112, 'ficou bonito', '2015-10-26 16:06:03', 4, 6, 1),
(113, 'pode cre', '2015-10-26 16:07:56', 6, 4, 1),
(114, 'tempo real', '2015-10-26 16:08:03', 6, 4, 1),
(115, 'ola mundo', '2015-10-26 16:08:07', 4, 6, 1),
(116, 'oiii', '2015-10-26 17:45:17', 4, 6, 1),
(117, 'tdo bem?', '2015-10-26 17:45:21', 4, 6, 1),
(118, 'onde você está?', '2015-10-26 17:45:22', 4, 6, 1),
(119, 'oiee', '2015-10-26 17:45:27', 6, 4, 1),
(120, 'Tdo bem sim e vc?', '2015-11-17 21:56:30', 6, 4, 0),
(121, 'estou no IFSP', '2015-11-17 21:57:50', 6, 4, 0),
(122, 'estudando para prova...', '2015-11-17 21:58:02', 6, 4, 0),
(123, 'Anna você fez o TCC?', '2015-11-17 21:58:26', 4, 7, 1),
(124, 'pelo amor de deus...', '2015-11-17 21:58:34', 4, 7, 1),
(125, 'estou terminando, falta só mais alguns detalhes...', '2015-11-17 21:59:06', 7, 4, 1),
(126, 'Marcio vamos jogar bolaa??', '2015-11-17 22:00:05', 4, 9, 0),
(127, 'acorda', '2015-11-25 09:08:17', 7, 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `uid_fk` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `created` int(11) DEFAULT '1269249260',
  PRIMARY KEY (`msg_id`),
  KEY `ip` (`ip`),
  KEY `fk_messages_users1_idx` (`uid_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=132 ;

--
-- Extraindo dados da tabela `messages`
--

INSERT INTO `messages` (`msg_id`, `message`, `uid_fk`, `ip`, `created`) VALUES
(1, 'Hello', 4, '127.0.0.1', 1305209778),
(2, 'My little blog http://9lessons.info', 4, '127.0.0.1', 1305209846),
(51, 'Thought of You http://vimeo.com/14803194', 4, '127.0.0.1', 1305483243),
(59, 'SEEDLING http://vimeo.com/22912215', 4, '127.0.0.1', 1305485602),
(64, 'teste certo', 4, '127.0.0.1', 1421328675),
(65, 'defefe', 4, '127.0.0.1', 1421329017),
(68, 'httt', 4, '127.0.0.1', 1421335189),
(94, 'Hello Word ! Vamos testar nosso post, comente... rsrs', 6, '127.0.0.1', 1421374355),
(98, 'Rede social em funcionamento !!!', 4, '127.0.0.1', 1421377059),
(99, 'Mano ta ficando legal...', 4, '127.0.0.1', 1421673651),
(101, 'ola mundo', 4, '127.0.0.1', 1426285015),
(102, 'oi', 11, '127.0.0.1', 1426290855),
(104, 'Que das hora...', 9, '127.0.0.1', 1427734186),
(106, 'Olá mundo...', 12, '127.0.0.1', 1427754496),
(108, 'Artigo pra semana que vem pessoal...', 14, '127.0.0.1', 1427771332),
(109, 'Vaiii curinthiaaaaa... haha', 15, '127.0.0.1', 1427919100),
(112, 'Sonhei com pepinosss.... hummmm', 8, '127.0.0.1', 1427983735),
(115, 'Ta froids', 11, '127.0.0.1', 1428001032),
(116, 'Pelo amor de deus...', 6, '127.0.0.1', 1428416837),
(120, 'Bootstrap é oque há... rsrsrs Ta fununciando mlk <3', 4, '127.0.0.1', 1428421557),
(125, 'Pessoal, vamos fazer as gravações aqui pro meu tcc pooww.. hahahahahahahahahahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahah', 18, '127.0.0.1', 1428429789),
(126, 'Facebook do IFSP HAHAHA kkkk', 15, '127.0.0.1', 1428454260),
(127, '#Partiu Paratti haha', 7, '127.0.0.1', 1428785816),
(128, 'Eu sou um gordinho gostoso, gordinhoo gostosoooo haha', 9, '127.0.0.1', 1428791672),
(130, 'Intro JS success... :D', 12, '::1', 1441809367);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoevento`
--

DROP TABLE IF EXISTS `tipoevento`;
CREATE TABLE IF NOT EXISTS `tipoevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black',
  `textcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `tipoevento`
--

INSERT INTO `tipoevento` (`id`, `nome`, `imagem`, `color`, `textcolor`) VALUES
(1, 'Pesquisas', '<i class=''fa fa-search''></i>', '#87CEEB', '#FFF'),
(2, 'Reunião', '<i class=''fa fa-users''></i>', '#FF8C00', '#FFF'),
(3, 'Aprovação', '<i class=''fa fa-check-square''></i>', '#00FF7F', '#FFF'),
(4, 'Monografia', '<i class=''fa fa-pencil-square''></i>', '#EEAEEE', '#FFF'),
(5, 'Revisão', '<i class=''fa fa-eye''></i>', '#FF3030', '#FFF'),
(6, 'Produção/Programação', '<i class=''fa fa-file-code-o''></i>', '#000', '#FFF'),
(7, 'Comissão de Ética', '<i class=''fa fa-paperclip''></i>', '#E6E6FA', '#FFF'),
(8, 'Outros', '<i class=''fa fa-asterisk''></i>', '#1E90FF', '#FFF'),
(9, 'Banca Final', '<i class=''fa fa-graduation-cap''></i>', '#1A731A', '#FFF');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nick` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(44) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `prontuario` int(11) DEFAULT NULL,
  `fotouser` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `horario` datetime DEFAULT NULL,
  `limite` datetime DEFAULT NULL,
  `descricao` text CHARACTER SET latin1,
  `cargo` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` int(2) DEFAULT '0',
  `primeiroacesso` int(11) DEFAULT '0' COMMENT '0 = primeiro acesso',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`uid`, `username`, `nick`, `password`, `email`, `prontuario`, `fotouser`, `horario`, `limite`, `descricao`, `cargo`, `tipo`, `primeiroacesso`) VALUES
(2, '---', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@admin.com', NULL, 'fotoUser/padraoUser.jpg', '2014-09-30 21:45:15', '2015-09-30 21:45:17', 'admin', 'Admin', 0, 0),
(3, '---', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@admin.com', NULL, 'fotoUser/padraoUser.jpg', '2015-09-30 21:46:15', '2015-09-30 21:46:17', 'admin', 'Admin', 0, 0),
(4, 'Leonardo Bueno Martins', 'Leozinho', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'leo.piracaia@hotmail.com', 1262751, 'fotoUser/thumbnail_1446131811.jpg', '2015-11-25 15:18:16', '2015-11-25 15:20:16', 'Programador Júnior, Formando em Análise e Desenvolvimento de Sistemas', 'Admin', 0, 1),
(6, 'Everton de Paula', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'everton.projetos@gmail.com', 0, 'fotoUser/thumbnail_1443387799.jpg', '2015-11-17 21:57:18', '2015-11-17 21:59:18', 'teste', 'Aluno', 0, 1),
(7, 'Ana carolina', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ana@hotmail.com', 0, 'fotoUser/thumbnail_1427733717.jpg', '2015-11-25 09:06:50', '2015-11-25 09:08:50', 'teste', 'Aluno', 0, 0),
(8, 'Rodrigo Adolfo', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rodrigo@hotmail.com', 0, 'fotoUser/thumbnail_1427733865.jpg', '2015-09-30 21:30:11', '2015-09-30 21:32:11', 'teste', 'Aluno', 0, 0),
(9, 'Marcio Vianna', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcio@hotmail.com', 111111111, 'fotoUser/thumbnail_1427734132.jpg', '2015-11-17 20:57:27', '2015-11-17 20:59:27', 'teste', 'Aluno', 0, 0),
(10, 'Marcos Martins', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcosevmartins@gmail.com', 22222222, 'fotoUser/thumbnail_1427734208.jpg', '2015-08-10 14:38:58', '2015-08-10 14:40:58', 'Programador e Analista de Sistemas', 'Aluno', 0, 0),
(11, 'Claudia Martins', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'claubmartins@gmail.com', 3333333, 'fotoUser/thumbnail_1427733083.jpg', '2015-08-10 22:24:48', '2015-08-10 22:26:48', 'teste', 'Aluno', 0, 0),
(12, 'Ana Giancoli', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'paulagiancoli@gmail.com', 1234567, 'fotoUser/thumbnail_1446131849.jpg', '2015-11-25 16:33:36', '2015-11-25 16:35:36', 'teste', 'Professor', 1, 1),
(14, 'Jefferson de Souza', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jeff@hotmail.com', 1234567, 'fotoUser/thumbnail_1427771298.jpg', '2015-03-30 19:28:05', '2015-03-30 19:30:05', 'Prof. Dr. Jefferson de Souza Pinto\r\nDoutor em Engenharia Mecânica - DEF/FEM/UNICAMP\r\nPós-doutor em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nPós-doutorando em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nInstituto Federal de São Paulo - Campus Bragança Paulista', 'Professor', 1, 0),
(15, 'João Paulo', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'joaolds@gmail.com', 1234567, 'fotoUser/thumbnail_1427919145.jpg', '2015-08-11 21:12:12', '2015-08-11 21:14:12', 'I''M GAY', 'Aluno', 0, 0),
(17, 'Mauro Mazzola', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mauro@hotmail.com', 1234567, 'fotoUser/thumbnail_1427919031.jpg', '2015-09-30 21:59:53', '2015-09-30 22:01:53', NULL, 'Aluno', 0, 0),
(18, 'André Lemme', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'andre@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920239.png', '2015-04-15 18:52:49', '2015-04-15 18:54:49', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Engenharia de Software - ESWI2, Projeto de Sistemas II - PS2I6, Gerencia de Projetos - GPSIIP3, Treinamento Professor', 'Professor', 1, 0),
(19, 'Wilson Vendramel', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'vendramel@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920193.png', '2015-06-03 15:04:10', '2015-06-03 15:06:10', 'Professor e Coordenador ADS Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Análise Orientada a Objetos - AOOI3, Arquitetura de Software - ASWI4, Qualidade de Software - QSWI5, Treinamento Professor, Alunos ADS', 'Coordenador ADS', 1, 0),
(20, 'André Panhan', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'apanhan@gmail.com', 1234567, 'fotoUser/thumbnail_1427930009.png', '2015-08-11 21:08:47', '2015-08-11 21:10:47', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Desenvolvimento para Web II - DW2A6, Programação Orientada a Objetos - POOI4, Treinamento Professor', 'Professor', 1, 0),
(21, 'Luciano Bernardes', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'luciano@hotmail.com', 1234567, 'fotoUser/thumbnail_1427930133.png', '2015-04-15 19:53:26', '2015-04-15 19:55:26', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Segurança e Auditoria de Sistemas - SEGA6, Linguagem de Programação I - LP1I1, Serviços de Rede - SSRI5, Eletiva I - EL1I5, Treinamento Professor', 'Professor', 1, 0),
(22, 'Marcel Zacarias', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcel@hotmail.com', 111111111, 'fotoUser/thumbnail_1428453049.jpg', '2015-04-07 21:31:57', '2015-04-07 21:33:57', NULL, 'Aluno', 0, 0),
(23, 'Eliane Andreoli', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eliane@hotmail.com', 1234567, 'fotoUser/thumbnail_1428721478.jpg', '2015-04-11 00:05:20', '2015-04-11 00:07:20', 'Professora de Português e Inglês', 'Professor', 1, 0),
(24, 'Rosalvo Soares C. Filho', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rosalvo@hotmail.com', 123456, 'fotoUser/thumbnail_1429109792.jpg', '2015-04-15 11:56:49', '2015-04-15 11:58:49', 'Professor de Redes de Computadores', 'Professor', 1, 0),
(25, 'Ana Cristina Gobbo César', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anacristina@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109742.jpg', '2015-09-30 21:58:57', '2015-09-30 22:00:57', 'Professora de TCC', 'Professor', 1, 0),
(26, 'Bianca Maria Pedrosa', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bianca@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109829.jpg', '2015-04-15 11:57:30', '2015-04-15 11:59:30', 'Professora de WEB', 'Professor', 1, 0),
(27, 'Flavio César Amate', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'flavio@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109684.jpg', '2015-09-30 22:03:22', '2015-09-30 22:05:22', 'Professor de Matemática', 'Professor', 1, 0),
(30, 'João Antunes Pereira da Cunha ', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jj@gmail.com', 1231231, 'fotoUser/padraoUser.jpg', '2015-09-30 22:02:42', '2015-09-30 22:04:42', NULL, NULL, 0, 0),
(31, 'Josefino', 'fininho', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'josefino@hotmail.com', 123455, 'fotoUser/padraoUser.jpg', NULL, NULL, NULL, NULL, 0, 0),
(32, 'Josué', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jos@hotmail.com', 1234567, 'fotoUser/padraoUser.jpg', '2015-11-12 08:27:20', '2015-11-12 08:29:20', 'Teste', 'Aluno', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `workflow`
--

DROP TABLE IF EXISTS `workflow`;
CREATE TABLE IF NOT EXISTS `workflow` (
  `idWorkflow` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) DEFAULT NULL,
  `participantes` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end` datetime NOT NULL,
  `data_conclusao` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `concluido` tinyint(4) NOT NULL DEFAULT '0',
  `nomeEvento` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idWorkflow`),
  KEY `idGrupo` (`idGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_idgrupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `atadefesa`
--
ALTER TABLE `atadefesa`
  ADD CONSTRAINT `FK_atadefesa_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `FK_avisos_users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_avisos_users2` FOREIGN KEY (`de`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_msg_id` FOREIGN KEY (`msg_id_fk`) REFERENCES `messages` (`msg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`uid_fk`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `cronograma`
--
ALTER TABLE `cronograma`
  ADD CONSTRAINT `idgrupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `desistenciaaluno`
--
ALTER TABLE `desistenciaaluno`
  ADD CONSTRAINT `FK_desistenciaaluno_grupo` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_desistenciaaluno_users` FOREIGN KEY (`idUsers`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `desistenciaprof`
--
ALTER TABLE `desistenciaprof`
  ADD CONSTRAINT `FK_desistenciaprof_users` FOREIGN KEY (`idUsers`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_desistenciaprof_grupo` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `FK_evento_tipoevento` FOREIGN KEY (`idTipoEvento`) REFERENCES `tipoevento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idcronograma`) REFERENCES `cronograma` (`idcronograma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `grupo_has_users`
--
ALTER TABLE `grupo_has_users`
  ADD CONSTRAINT `FK_grupo_has_users_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_grupo_has_users_users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `likecomment`
--
ALTER TABLE `likecomment`
  ADD CONSTRAINT `fk_coments` FOREIGN KEY (`com_id`) REFERENCES `comments` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments` FOREIGN KEY (`Com_id`) REFERENCES `comments` (`com_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_msg` FOREIGN KEY (`msg_id`) REFERENCES `messages` (`msg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `Fk_users_udi` FOREIGN KEY (`uid_fk`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `workflow`
--
ALTER TABLE `workflow`
  ADD CONSTRAINT `fk_idGrupo_workflow` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
