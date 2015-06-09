-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Jun-2015 às 04:18
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`idavisos`, `descricao`, `data`, `visto`, `uid`, `de`) VALUES
(1, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-06-08', '1', 12, 1),
(2, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-06-08', '0', 1, 12),
(3, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-06-08', '0', 6, 12),
(4, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-06-08', '0', 7, 12),
(5, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-06-08', '0', 1, 12),
(6, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-06-08', '0', 6, 12),
(7, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-06-08', '0', 7, 12),
(8, 'O(a) Professor(a) Ana Giancoli desfez parceria com seu grupo pelo seguinte motivo: hahahahahahahahahahahahha', '2015-06-08', '0', 1, 12),
(9, 'O(a) Professor(a) Ana Giancoli desfez parceria com seu grupo pelo seguinte motivo: hahahahahahahahahahahahha', '2015-06-08', '0', 6, 12),
(10, 'O(a) Professor(a) Ana Giancoli desfez parceria com seu grupo pelo seguinte motivo: hahahahahahahahahahahahha', '2015-06-08', '0', 7, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=115 ;

--
-- Extraindo dados da tabela `comments`
--

INSERT INTO `comments` (`com_id`, `comment`, `msg_id_fk`, `uid_fk`, `ip`, `created`) VALUES
(1, 'My first comment ', 1, 1, '127.0.0.1', 1305209833),
(26, 'Must watch ', 51, 6, '127.0.0.1', 1305483460),
(31, 'by Lee Tao', 59, 6, '127.0.0.1', 1305485714),
(53, 'agora parece que foi', 68, 1, '127.0.0.1', 1421373754),
(64, 'haha', 94, 6, '127.0.0.1', 1421375625),
(67, 'Parabéns, vc é o melhor do  melhor do mundo !! haha', 98, 6, '127.0.0.1', 1421377101),
(68, 'Obrigado, um dia te ensino *--* ', 98, 1, '127.0.0.1', 1421402450),
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
(90, 'Hummmm, que isso digo.... HAHAHA', 112, 1, '127.0.0.1', 1428417320),
(93, 'HAHAHAHAHA', 108, 1, '127.0.0.1', 1428426661),
(94, 'Lokão haha', 104, 1, '127.0.0.1', 1428427125),
(100, '*--------* vlw minha gente <3', 99, 1, '127.0.0.1', 1428558221),
(105, 'Nosso grupo é o melhor do melhor do mundo... HAHAHAHA', 126, 1, '127.0.0.1', 1428559206),
(110, 'Paga pau em florzinha hahaha', 126, 7, '127.0.0.1', 1428785793),
(111, 'Booooraa haha', 127, 6, '127.0.0.1', 1429231831),
(112, 'pode cre!!!!', 120, 6, '127.0.0.1', 1431035669),
(113, 'kjk', 125, 1, '127.0.0.1', 1432680365),
(114, 'oi gatinhaaa, casa comigo !!??? :D', 127, 15, '127.0.0.1', 1433370930);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronograma`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `cronograma`
--

INSERT INTO `cronograma` (`idcronograma`, `idgrupo`, `aprovado`, `analisando`, `revisando`, `enviado`) VALUES
(21, 40, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `desistenciaaluno`
--

CREATE TABLE IF NOT EXISTS `desistenciaaluno` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `motivo` int(11) NOT NULL,
  `dataDesistencia` date NOT NULL,
  `descricao` text COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`idDesistencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `desistenciaaluno`
--

INSERT INTO `desistenciaaluno` (`idDesistencia`, `idUsers`, `idGrupo`, `motivo`, `dataDesistencia`, `descricao`) VALUES
(4, 1, 39, 1, '2015-06-08', 'Porque eu cansei de voces, seus lixos, cocos estrumes de bosta de vaca HAHAHA beijos me liga...');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desistenciaprof`
--

CREATE TABLE IF NOT EXISTS `desistenciaprof` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `dataDesistencia` date NOT NULL,
  `motivo` int(11) NOT NULL,
  PRIMARY KEY (`idDesistencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `desistenciaprof`
--

INSERT INTO `desistenciaprof` (`idDesistencia`, `idUsers`, `idGrupo`, `descricao`, `dataDesistencia`, `motivo`) VALUES
(5, 12, 43, 'hahahahahahahahahahahahha', '2015-06-08', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

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
  PRIMARY KEY (`idEvento`),
  KEY `idGrupo` (`idGrupo`,`idcronograma`),
  KEY `idcronograma` (`idcronograma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=124 ;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`idEvento`, `idGrupo`, `participantes`, `start`, `end`, `allday`, `nomeEvento`, `descricao`, `idcronograma`, `idTipoEvento`, `concluido`) VALUES
(121, 40, '9,19', '2015-06-03 00:00:00', '2015-06-17 00:00:00', 1, 'teste', 'sdhusdus', 21, 3, 1),
(122, 40, '9', '2015-06-04 00:00:00', '2015-06-05 00:00:00', 1, 'knsics', 'kxks', 21, 4, 0),
(123, 40, '2,3,9,19', '2015-06-03 15:00:00', '2015-06-03 16:00:00', 0, 'uened', 'nxsid', 21, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`idgrupo`, `dataCriacao`, `titulo`, `descricao`, `objetivoGeral`, `objetivoEspecifico`, `justificativa`, `tipodePesquisa`, `metodologia`, `resultadoEsperado`, `fraselema`, `aceito`, `visto`, `recusado`, `revisando`, `preProjeto`, `cronograma`) VALUES
(40, '2015-06-03', 'ishduwdhws', 'ncuscus', 'h', 'h', 'h', 'h', 'h', 'h', NULL, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_has_users`
--

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
(40, 2, 1),
(40, 3, 1),
(40, 9, 1),
(40, 19, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `idlikes` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  PRIMARY KEY (`idlikes`),
  KEY `uid` (`uid`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Extraindo dados da tabela `likes`
--

INSERT INTO `likes` (`idlikes`, `uid`, `msg_id`) VALUES
(6, 2, 128),
(7, 3, 128),
(21, 6, 128),
(24, 6, 127),
(25, 6, 120),
(27, 17, 128),
(28, 17, 120),
(29, 1, 128),
(30, 12, 128),
(31, 8, 128),
(32, 9, 128),
(33, 9, 127),
(34, 15, 128);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `mensagem` varchar(255) CHARACTER SET latin1 NOT NULL,
  `data` datetime NOT NULL,
  `lido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `id_de`, `id_para`, `mensagem`, `data`, `lido`) VALUES
(1, 3, 1, 'OlÃ¡ fabio, tudo bem?', '2013-09-11 08:07:00', 1),
(2, 1, 4, 'dddd', '2015-01-16 08:29:14', 0),
(3, 1, 3, 'hg', '2015-01-16 08:46:22', 1),
(4, 1, 3, 'vai indo mano e vc?', '2015-01-16 08:47:09', 1),
(5, 3, 1, 'haha', '2015-01-16 13:20:22', 1),
(6, 3, 1, 'bom tbm', '2015-01-16 13:20:31', 1),
(7, 3, 1, 'kkk', '2015-01-16 13:20:36', 1),
(8, 3, 1, 'tttt', '2015-01-16 13:35:47', 1),
(9, 1, 3, 'legal', '2015-01-16 13:39:03', 0),
(10, 1, 6, 'ola amigo', '0000-00-00 00:00:00', 1),
(11, 1, 6, 'fala cmg pelo amor de deus', '0000-00-00 00:00:00', 1),
(12, 6, 1, 'to falando mano', '0000-00-00 00:00:00', 1),
(13, 6, 1, 'hahaha', '0000-00-00 00:00:00', 1),
(14, 6, 7, 'ee', '0000-00-00 00:00:00', 1),
(15, 6, 8, 'ee', '0000-00-00 00:00:00', 1),
(16, 8, 1, 'pq esse merda ta zuada ?', '0000-00-00 00:00:00', 1),
(17, 8, 6, 'que lixo', '0000-00-00 00:00:00', 1),
(18, 1, 8, 'consegui arrumar mano relaxa ai', '0000-00-00 00:00:00', 1),
(19, 1, 8, 'hahaha', '0000-00-00 00:00:00', 1),
(20, 1, 6, 'eee', '0000-00-00 00:00:00', 1),
(21, 1, 6, 'd', '0000-00-00 00:00:00', 1),
(22, 1, 6, 'dcdccd', '0000-00-00 00:00:00', 1),
(23, 6, 1, 'haha', '0000-00-00 00:00:00', 1),
(24, 1, 6, 's', '0000-00-00 00:00:00', 1),
(25, 1, 7, 'oi ana', '0000-00-00 00:00:00', 1),
(26, 1, 6, 'oi', '0000-00-00 00:00:00', 1),
(27, 6, 1, 'oi pra vc tbm', '0000-00-00 00:00:00', 1),
(28, 1, 6, 's', '0000-00-00 00:00:00', 1),
(29, 1, 6, 'hashahshahas', '0000-00-00 00:00:00', 1),
(30, 1, 6, 'ola', '0000-00-00 00:00:00', 1),
(31, 21, 6, 'Oi seu viado', '0000-00-00 00:00:00', 1),
(32, 1, 8, 'ei man', '0000-00-00 00:00:00', 1),
(33, 1, 8, 'blz?', '0000-00-00 00:00:00', 1),
(34, 1, 11, 'oi mãe', '0000-00-00 00:00:00', 1),
(35, 1, 11, 'o', '0000-00-00 00:00:00', 1),
(36, 1, 11, 'como vc ta maãe', '0000-00-00 00:00:00', 1),
(37, 11, 1, 'to bem', '0000-00-00 00:00:00', 1),
(38, 1, 6, 'bo', '0000-00-00 00:00:00', 1),
(39, 1, 7, 'oiiii', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `uid_fk` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `created` int(11) DEFAULT '1269249260',
  PRIMARY KEY (`msg_id`),
  KEY `ip` (`ip`),
  KEY `fk_messages_users1_idx` (`uid_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=129 ;

--
-- Extraindo dados da tabela `messages`
--

INSERT INTO `messages` (`msg_id`, `message`, `uid_fk`, `ip`, `created`) VALUES
(1, 'Hello', 1, '127.0.0.1', 1305209778),
(2, 'My little blog http://9lessons.info', 1, '127.0.0.1', 1305209846),
(51, 'Thought of You http://vimeo.com/14803194', 1, '127.0.0.1', 1305483243),
(59, 'SEEDLING http://vimeo.com/22912215', 1, '127.0.0.1', 1305485602),
(64, 'teste certo', 1, '127.0.0.1', 1421328675),
(65, 'defefe', 1, '127.0.0.1', 1421329017),
(68, 'httt', 1, '127.0.0.1', 1421335189),
(94, 'Hello Word ! Vamos testar nosso post, comente... rsrs', 6, '127.0.0.1', 1421374355),
(98, 'Rede social em funcionamento !!!', 1, '127.0.0.1', 1421377059),
(99, 'Mano ta ficando legal...', 1, '127.0.0.1', 1421673651),
(101, 'ola mundo', 1, '127.0.0.1', 1426285015),
(102, 'oi', 11, '127.0.0.1', 1426290855),
(104, 'Que das hora...', 9, '127.0.0.1', 1427734186),
(106, 'Olá mundo...', 12, '127.0.0.1', 1427754496),
(108, 'Artigo pra semana que vem pessoal...', 14, '127.0.0.1', 1427771332),
(109, 'Vaiii curinthiaaaaa... haha', 15, '127.0.0.1', 1427919100),
(112, 'Sonhei com pepinosss.... hummmm', 8, '127.0.0.1', 1427983735),
(115, 'Ta froids', 11, '127.0.0.1', 1428001032),
(116, 'Pelo amor de deus...', 6, '127.0.0.1', 1428416837),
(120, 'Bootstrap é oque há... rsrsrs Ta fununciando mlk <3', 1, '127.0.0.1', 1428421557),
(125, 'Pessoal, vamos fazer as gravações aqui pro meu tcc pooww.. hahahahahahahahahahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahahahahaha hahahahahah', 18, '127.0.0.1', 1428429789),
(126, 'Facebook do IFSP HAHAHA kkkk', 15, '127.0.0.1', 1428454260),
(127, '#Partiu Paratti haha', 7, '127.0.0.1', 1428785816),
(128, 'Eu sou um gordinho gostoso, gordinhoo gostosoooo haha', 9, '127.0.0.1', 1428791672);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoevento`
--

CREATE TABLE IF NOT EXISTS `tipoevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black',
  `textcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

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
(8, 'Outros', '<i class=''fa fa-asterisk''></i>', '#1E90FF', '#FFF');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 NOT NULL,
  `password` varchar(44) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `prontuario` int(11) NOT NULL,
  `fotouser` varchar(100) CHARACTER SET latin1 NOT NULL,
  `horario` datetime NOT NULL,
  `limite` datetime NOT NULL,
  `descricao` text CHARACTER SET latin1,
  `cargo` varchar(100) CHARACTER SET latin1 NOT NULL,
  `tipo` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`, `prontuario`, `fotouser`, `horario`, `limite`, `descricao`, `cargo`, `tipo`) VALUES
(1, 'Leonardo Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'leo.piracaia@hotmail.com', 1262751, 'fotoUser/thumbnail_1427732986.jpg', '2015-06-08 23:11:37', '2015-06-08 23:13:37', 'Programador Júnior, Formando em Análise e Desenvolvimento de Sistemas', 'Aluno', 0),
(2, '-----', '123', '-----', 0, 'fotoUser/padraoUser.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Admin', 'Admin', 0),
(3, '-----', '123', '-----', 0, 'fotoUser/padraoUser.jpg', '2015-04-07 00:00:00', '2015-04-07 00:00:00', 'Admin', 'Admin', 0),
(6, 'Everton de Paula', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'everton.projetos@gmail.com', 0, 'fotoUser/thumbnail_1427733642.jpg', '2015-06-02 10:55:11', '2015-06-02 10:57:11', 'teste', 'Aluno', 0),
(7, 'Ana carolina', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ana@hotmail.com', 0, 'fotoUser/thumbnail_1427733717.jpg', '2015-06-02 11:01:24', '2015-06-02 11:03:24', 'teste', 'Aluno', 0),
(8, 'Rodrigo Adolfo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rodrigo@hotmail.com', 0, 'fotoUser/thumbnail_1427733865.jpg', '2015-06-01 18:57:34', '2015-06-01 18:59:34', 'teste', 'Aluno', 0),
(9, 'Marcio Vianna', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcio@hotmail.com', 111111111, 'fotoUser/thumbnail_1427734132.jpg', '2015-06-03 15:05:08', '2015-06-03 15:07:08', 'teste', 'Aluno', 0),
(10, 'Marcos Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcosevmartins@gmail.com', 22222222, 'fotoUser/thumbnail_1427734208.jpg', '2015-04-16 00:33:02', '2015-04-16 00:35:02', 'Programador e Analista de Sistemas', 'Aluno', 0),
(11, 'Claudia Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'claubmartins@gmail.com', 3333333, 'fotoUser/thumbnail_1427733083.jpg', '2015-04-02 16:08:10', '2015-04-02 16:10:10', 'teste', 'Aluno', 0),
(12, 'Ana Giancoli', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'paulagiancoli@gmail.com', 1234567, 'fotoUser/thumbnail_1427754341.jpg', '2015-06-08 23:14:24', '2015-06-08 23:16:24', 'teste', 'Professor', 1),
(14, 'Jefferson de Souza', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jeff@hotmail.com', 1234567, 'fotoUser/thumbnail_1427771298.jpg', '2015-03-30 19:28:05', '2015-03-30 19:30:05', 'Prof. Dr. Jefferson de Souza Pinto\r\nDoutor em Engenharia Mecânica - DEF/FEM/UNICAMP\r\nPós-doutor em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nPós-doutorando em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nInstituto Federal de São Paulo - Campus Bragança Paulista', 'Professor', 1),
(15, 'João Paulo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'joaolds@gmail.com', 1234567, 'fotoUser/thumbnail_1427919145.jpg', '2015-06-03 19:35:32', '2015-06-03 19:37:32', NULL, 'Aluno', 0),
(17, 'Mauro Mazzola', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mauro@hotmail.com', 1234567, 'fotoUser/thumbnail_1427919031.jpg', '2015-06-02 10:22:47', '2015-06-02 10:24:47', NULL, 'Aluno', 0),
(18, 'André Lemme', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'andre@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920239.png', '2015-04-15 18:52:49', '2015-04-15 18:54:49', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Engenharia de Software - ESWI2, Projeto de Sistemas II - PS2I6, Gerencia de Projetos - GPSIIP3, Treinamento Professor', 'Professor', 1),
(19, 'Wilson Vendramel', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'vendramel@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920193.png', '2015-06-03 15:04:10', '2015-06-03 15:06:10', 'Professor e Coordenador ADS Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Análise Orientada a Objetos - AOOI3, Arquitetura de Software - ASWI4, Qualidade de Software - QSWI5, Treinamento Professor, Alunos ADS', 'Coordenador ADS', 1),
(20, 'André Panhan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'apanhan@gmail.com', 1234567, 'fotoUser/thumbnail_1427930009.png', '2015-04-02 20:28:43', '2015-04-02 20:30:43', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Desenvolvimento para Web II - DW2A6, Programação Orientada a Objetos - POOI4, Treinamento Professor', 'Professor', 1),
(21, 'Luciano Bernardes', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'luciano@hotmail.com', 1234567, 'fotoUser/thumbnail_1427930133.png', '2015-04-15 19:53:26', '2015-04-15 19:55:26', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Segurança e Auditoria de Sistemas - SEGA6, Linguagem de Programação I - LP1I1, Serviços de Rede - SSRI5, Eletiva I - EL1I5, Treinamento Professor', 'Professor', 1),
(22, 'Marcel Zacarias', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcel@hotmail.com', 111111111, 'fotoUser/thumbnail_1428453049.jpg', '2015-04-07 21:31:57', '2015-04-07 21:33:57', NULL, 'Aluno', 0),
(23, 'Eliane Andreoli', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eliane@hotmail.com', 1234567, 'fotoUser/thumbnail_1428721478.jpg', '2015-04-11 00:05:20', '2015-04-11 00:07:20', 'Professora de Português e Inglês', 'Professor', 1),
(24, 'Rosalvo Soares C. Filho', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rosalvo@hotmail.com', 123456, 'fotoUser/thumbnail_1429109792.jpg', '2015-04-15 11:56:49', '2015-04-15 11:58:49', 'Professor de Redes de Computadores', 'Professor', 1),
(25, 'Ana Cristina Gobbo César', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anacristina@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109742.jpg', '2015-04-15 11:55:59', '2015-04-15 11:57:59', 'Professora de TCC', 'Professor', 1),
(26, 'Bianca Maria Pedrosa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bianca@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109829.jpg', '2015-04-15 11:57:30', '2015-04-15 11:59:30', 'Professora de WEB', 'Professor', 1),
(27, 'Flavio César Amate', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'flavio@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109684.jpg', '2015-04-15 11:55:06', '2015-04-15 11:57:06', 'Professor de Matemática', 'Professor', 1);

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `cronograma_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idcronograma`) REFERENCES `cronograma` (`idcronograma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `grupo_has_users`
--
ALTER TABLE `grupo_has_users`
  ADD CONSTRAINT `FK_grupo_has_users_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_grupo_has_users_users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
