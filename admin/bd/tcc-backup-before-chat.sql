-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.17 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para tcc
DROP DATABASE IF EXISTS `tcc`;
CREATE DATABASE IF NOT EXISTS `tcc` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `tcc`;


-- Copiando estrutura para tabela tcc.arquivos
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
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_idgrupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci COMMENT='tabela de arquivos enviados';

-- Copiando dados para a tabela tcc.arquivos: ~6 rows (aproximadamente)
DELETE FROM `arquivos`;
/*!40000 ALTER TABLE `arquivos` DISABLE KEYS */;
INSERT INTO `arquivos` (`idArquivo`, `idgrupo`, `user_id`, `nome`, `caminho`, `dtaEnvio`, `versao_u`, `versao_d`, `versao_c`) VALUES
	(54, 63, 1, '963-150922.pdf', '/GerenciamentoGrupos/63/493dad3e37831d20a809ecb62c337ee2.pdf', '2015-10-02 01:04:33', 2, 0, 0),
	(55, 63, 1, '23-09-2015-PARC115.pdf', '/GerenciamentoGrupos/63/f8c9e3b9d218694d2420808141b960d2.pdf', '2015-10-02 01:04:54', 0, 1, 0),
	(56, 63, 1, '23-09-2015-PARC115.pdf', '/GerenciamentoGrupos/63/72cf6b08c015f7ca1c1b4b2fd197d991.pdf', '2015-10-02 01:05:18', 0, 1, 1),
	(57, 63, 1, 'Inscrição Enem.pdf', '/GerenciamentoGrupos/63/d805b267140e2273559d6ab52bc731ed.pdf', '2015-10-02 01:05:42', 1, 0, 0),
	(58, 63, 12, '963-150922.pdf', '/GerenciamentoGrupos/63/15e615cfe36b7dd8f24002c2e7ccc595.pdf', '2015-10-02 01:52:04', 3, 0, 0),
	(59, 63, 1, 'Inscrição Enem.pdf', '/GerenciamentoGrupos/63/4985a81108fb64bf483583cf387f2146.pdf', '2015-10-06 20:47:00', 2, 0, 0);
/*!40000 ALTER TABLE `arquivos` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.atadefesa
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
  `status` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  PRIMARY KEY (`idAtaDefesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.atadefesa: ~0 rows (aproximadamente)
DELETE FROM `atadefesa`;
/*!40000 ALTER TABLE `atadefesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `atadefesa` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.avisos
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
  KEY `fk_avisos_users2_idx` (`de`),
  CONSTRAINT `FK_avisos_users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_avisos_users2` FOREIGN KEY (`de`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=300 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.avisos: ~96 rows (aproximadamente)
DELETE FROM `avisos`;
/*!40000 ALTER TABLE `avisos` DISABLE KEYS */;
INSERT INTO `avisos` (`idavisos`, `descricao`, `data`, `visto`, `uid`, `de`) VALUES
	(1, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-09-02', '1', 12, 1),
	(2, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-02', '1', 1, 12),
	(3, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-02', '1', 6, 12),
	(4, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-02', '1', 7, 12),
	(5, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-02', '1', 1, 12),
	(6, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-02', '1', 6, 12),
	(7, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-02', '1', 7, 12),
	(8, 'O evento pesmismd com entrega prevista para 09-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 6, 1),
	(9, 'O evento pesmismd com entrega prevista para 09-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 7, 1),
	(10, 'O evento pesmismd com entrega prevista para 09-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 12, 1),
	(11, 'O evento smdx com entrega prevista para 16-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 6, 1),
	(12, 'O evento smdx com entrega prevista para 16-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 7, 1),
	(13, 'O evento smdx com entrega prevista para 16-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-02', '1', 12, 1),
	(14, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-09-03', '1', 12, 9),
	(17, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-03', '1', 9, 12),
	(20, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-03', '1', 9, 12),
	(23, 'O evento nc jc com entrega prevista para 10-09-2015 foi adicionado, confira no cronograma!!!', '2015-09-03', '1', 12, 9),
	(24, 'O Grupo: Gerenciamento de TCC, enviou sua monografia para avaliação da etapa concluida, confira...', '2015-09-03', '1', 12, 12),
	(25, 'O Grupo: Gerenciamento de TCC, enviou sua monografia para avaliação da etapa concluida, confira...', '2015-09-03', '1', 12, 1),
	(26, 'O Grupo: Gerenciamento de TCC, enviou sua monografia para avaliação da etapa concluida, confira...', '2015-09-03', '1', 12, 1),
	(27, 'O Grupo: cmskcskcs, enviou sua monografia para avaliação da etapa concluida, confira...', '2015-09-03', '1', 12, 9),
	(28, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: Vocês mandaram muito bem meninos....', '2015-09-03', '1', 1, 12),
	(29, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: Vocês mandaram muito bem meninos....', '2015-09-03', '1', 6, 12),
	(30, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: Vocês mandaram muito bem meninos....', '2015-09-03', '1', 7, 12),
	(33, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: quero mais empenho', '2015-09-03', '1', 9, 12),
	(34, 'O Grupo: Gerenciamento de TCC, enviou sua monografia para avaliação da etapa concluida, confira...', '2015-09-09', '1', 12, 7),
	(35, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: <b>fico bom</b>', '2015-09-09', '1', 1, 12),
	(36, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: <b>fico bom</b>', '2015-09-09', '1', 6, 12),
	(37, 'O professor enviou as seguintes considerações ao Grupo sobre a monografia: <b>fico bom</b>', '2015-09-09', '0', 7, 12),
	(38, 'O evento Everton com entrega prevista para 29-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-26', '1', 1, 6),
	(39, 'O evento Everton com entrega prevista para 29-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-26', '0', 7, 6),
	(40, 'O evento Everton com entrega prevista para 29-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-26', '1', 12, 6),
	(41, 'O evento Pesquisa Poetica com entrega prevista para 29-11-2015 foi atualizado, confira no cronograma!!!', '2015-09-28', '1', 1, 6),
	(42, 'O evento Pesquisa Poetica com entrega prevista para 29-11-2015 foi atualizado, confira no cronograma!!!', '2015-09-28', '0', 7, 6),
	(43, 'O evento Pesquisa Poetica com entrega prevista para 29-11-2015 foi atualizado, confira no cronograma!!!', '2015-09-28', '1', 12, 6),
	(47, 'Vejam isso pelo amor de deus.', '2015-09-29', '1', 1, 6),
	(48, 'Vejam isso pelo amor de deus.', '2015-09-29', '0', 7, 6),
	(49, 'Vejam isso pelo amor de deus.', '2015-09-29', '1', 12, 6),
	(50, 'O evento Fazer Monografia com entrega prevista para 15-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 1, 12),
	(51, 'O evento Fazer Monografia com entrega prevista para 15-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 6, 12),
	(52, 'O evento Fazer Monografia com entrega prevista para 15-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '0', 7, 12),
	(53, 'O evento Fazer isso pelo amor de deus com entrega prevista para 27-12-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 1, 12),
	(54, 'O evento Fazer isso pelo amor de deus com entrega prevista para 27-12-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 6, 12),
	(55, 'O evento Fazer isso pelo amor de deus com entrega prevista para 27-12-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '0', 7, 12),
	(56, 'O evento eita pelo com entrega prevista para 02-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 1, 12),
	(57, 'O evento eita pelo com entrega prevista para 02-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '1', 6, 12),
	(58, 'O evento eita pelo com entrega prevista para 02-11-2015 foi adicionado, confira no cronograma!!!', '2015-09-29', '0', 7, 12),
	(146, 'Próxima atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:09:11.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-09-30', '1', 1, 12),
	(147, 'Próxima atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:09:11.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-09-30', '1', 6, 12),
	(148, 'Próxima atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:09:11.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-09-30', '0', 7, 12),
	(149, 'Concluída atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' em 30-09-2015 21:22:06. Confira mais no menu workflow.', '2015-09-30', '1', 1, 12),
	(150, 'Concluída atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' em 30-09-2015 21:22:06. Confira mais no menu workflow.', '2015-09-30', '1', 6, 12),
	(151, 'Concluída atividade \'Verificar o arquivo\' do Grupo \'Gerenciamento de TCC\' em 30-09-2015 21:22:06. Confira mais no menu workflow.', '2015-09-30', '0', 7, 12),
	(152, 'Próxima atividade \'Verificar TEXTOS DE JUCA CHAVEZ\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:25:11.Realizado updload de arquivo \'23-09-2015-PARC115.pdf\' . Confira mais no menu workflow.', '2015-09-30', '1', 1, 12),
	(153, 'Próxima atividade \'Verificar TEXTOS DE JUCA CHAVEZ\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:25:11.Realizado updload de arquivo \'23-09-2015-PARC115.pdf\' . Confira mais no menu workflow.', '2015-09-30', '1', 6, 12),
	(154, 'Próxima atividade \'Verificar TEXTOS DE JUCA CHAVEZ\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 30-09-2015 21:25:11.Realizado updload de arquivo \'23-09-2015-PARC115.pdf\' . Confira mais no menu workflow.', '2015-09-30', '0', 7, 12),
	(155, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-09-30', '1', 25, 17),
	(156, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '0', 2, 25),
	(157, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '0', 3, 25),
	(158, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '1', 17, 25),
	(159, 'Diante de sua solicita&ccedil;&atilde;o ao Professor para Orienta&ccedil;&atilde;o do TCC, o mesmo solicita um maior detalhamento do projeto em si, para uma melhor avalia&ccedil;&atilde;o de sua proposta para poder aceitar ou n&atilde;o orient&aacute;-los, clique no link a seguir para melhorar sua proposta do Projeto para o que professor possa avalia-lo com maior riqueza nos detalhamentos e crit&eacute;rio, Obrigado. <a href="refazProposta.php?idgrupo=66"><i class="fa fa-refresh"></i> Refazer Proposta</a>', '2015-09-30', '0', 2, 25),
	(160, 'Diante de sua solicita&ccedil;&atilde;o ao Professor para Orienta&ccedil;&atilde;o do TCC, o mesmo solicita um maior detalhamento do projeto em si, para uma melhor avalia&ccedil;&atilde;o de sua proposta para poder aceitar ou n&atilde;o orient&aacute;-los, clique no link a seguir para melhorar sua proposta do Projeto para o que professor possa avalia-lo com maior riqueza nos detalhamentos e crit&eacute;rio, Obrigado. <a href="refazProposta.php?idgrupo=66"><i class="fa fa-refresh"></i> Refazer Proposta</a>', '2015-09-30', '0', 3, 25),
	(161, 'Diante de sua solicita&ccedil;&atilde;o ao Professor para Orienta&ccedil;&atilde;o do TCC, o mesmo solicita um maior detalhamento do projeto em si, para uma melhor avalia&ccedil;&atilde;o de sua proposta para poder aceitar ou n&atilde;o orient&aacute;-los, clique no link a seguir para melhorar sua proposta do Projeto para o que professor possa avalia-lo com maior riqueza nos detalhamentos e crit&eacute;rio, Obrigado. <a href="refazProposta.php?idgrupo=66"><i class="fa fa-refresh"></i> Refazer Proposta</a>', '2015-09-30', '1', 17, 25),
	(163, 'Diante de seu requerimento para maiores informa&ccedil;&otilde;es sobre a descri&ccedil;&atilde;o do Projeto de TCC deste presente grupo, o mesmo foi revisado e reescrito para uma nova an&aacute;lise e aprova&ccedil;&atilde;o', '2015-09-30', '1', 25, 17),
	(164, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '0', 2, 25),
	(165, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '0', 3, 25),
	(166, 'Sua Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o ao professor foi Visualizada, e est&aacute; sendo analisada mediante sua descri&ccedil;&atilde;o do projeto e disponibilidade do mesmo.', '2015-09-30', '1', 17, 25),
	(167, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-30', '0', 2, 25),
	(168, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-30', '0', 3, 25),
	(169, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o aceita.', '2015-09-30', '1', 17, 25),
	(170, 'Requisi&ccedil;&atilde;o de Orienta&ccedil;&atilde;o solicitada.', '2015-09-30', '1', 27, 30),
	(264, 'Ola como vão', '2015-10-02', '1', 6, 1),
	(265, 'Ola como vão', '2015-10-02', '0', 7, 1),
	(266, 'Ola como vão', '2015-10-02', '1', 12, 1),
	(267, 'Cascata', '2015-10-02', '1', 6, 1),
	(268, 'Cascata', '2015-10-02', '0', 7, 1),
	(269, 'Cascata', '2015-10-02', '1', 12, 1),
	(270, 'Verifiquem', '2015-10-02', '1', 6, 1),
	(271, 'Verifiquem', '2015-10-02', '0', 7, 1),
	(272, 'Verifiquem', '2015-10-02', '1', 12, 1),
	(273, 'O que??', '2015-10-02', '1', 6, 1),
	(274, 'O que??', '2015-10-02', '0', 7, 1),
	(275, 'O que??', '2015-10-02', '1', 12, 1),
	(276, 'Minha inscrição no enem', '2015-10-02', '1', 6, 1),
	(277, 'Minha inscrição no enem', '2015-10-02', '0', 7, 1),
	(278, 'Minha inscrição no enem', '2015-10-02', '1', 12, 1),
	(279, 'Próxima atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:47:24.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '1', 1, 12),
	(280, 'Próxima atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:47:24.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '1', 6, 12),
	(281, 'Próxima atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:47:24.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '0', 7, 12),
	(282, 'Concluída atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:51:22. Confira mais no menu workflow.', '2015-10-02', '1', 1, 12),
	(283, 'Concluída atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:51:22. Confira mais no menu workflow.', '2015-10-02', '1', 6, 12),
	(284, 'Concluída atividade \'Fazer tudo isso\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:51:22. Confira mais no menu workflow.', '2015-10-02', '0', 7, 12),
	(285, 'Próxima atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:52:04.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-10-02', '1', 1, 12),
	(286, 'Próxima atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:52:04.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-10-02', '1', 6, 12),
	(287, 'Próxima atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:52:04.Realizado updload de arquivo \'963-150922.pdf\' . Confira mais no menu workflow.', '2015-10-02', '0', 7, 12),
	(288, 'Concluída atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:53:34. Confira mais no menu workflow.', '2015-10-02', '1', 1, 12),
	(289, 'Concluída atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:53:34. Confira mais no menu workflow.', '2015-10-02', '1', 6, 12),
	(290, 'Concluída atividade \'Eita pelo\' do Grupo \'Gerenciamento de TCC\' em 02-10-2015 01:53:34. Confira mais no menu workflow.', '2015-10-02', '0', 7, 12),
	(291, 'Próxima atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:54:22.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '1', 1, 12),
	(292, 'Próxima atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:54:22.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '1', 6, 12),
	(293, 'Próxima atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' foi adicionada em 02-10-2015 01:54:22.Sem upload de arquivos. Confira mais no menu workflow.', '2015-10-02', '0', 7, 12),
	(294, 'Concluída atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' em 06-10-2015 20:38:03. Confira mais no menu workflow.', '2015-10-06', '1', 1, 12),
	(295, 'Concluída atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' em 06-10-2015 20:38:03. Confira mais no menu workflow.', '2015-10-06', '1', 6, 12),
	(296, 'Concluída atividade \'Eita Pelo 2\' do Grupo \'Gerenciamento de TCC\' em 06-10-2015 20:38:03. Confira mais no menu workflow.', '2015-10-06', '0', 7, 12),
	(297, 'asdjadsaposhdadsihpasd', '2015-10-06', '1', 6, 1),
	(298, 'asdjadsaposhdadsihpasd', '2015-10-06', '0', 7, 1),
	(299, 'asdjadsaposhdadsihpasd', '2015-10-06', '0', 12, 1);
/*!40000 ALTER TABLE `avisos` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.comments
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
  KEY `fk_comments_users1_idx1` (`uid_fk`),
  CONSTRAINT `FK_msg_id` FOREIGN KEY (`msg_id_fk`) REFERENCES `messages` (`msg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_users` FOREIGN KEY (`uid_fk`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.comments: ~27 rows (aproximadamente)
DELETE FROM `comments`;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
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
	(113, 'kjk', 125, 1, '127.0.0.1', 1432680365),
	(114, 'oi gatinhaaa, casa comigo !!??? :D', 127, 15, '127.0.0.1', 1433370930),
	(115, 'capaz msm', 128, 1, '::1', 1438981717);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.cronograma
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
  KEY `idgrupo_2` (`idgrupo`),
  CONSTRAINT `cronograma_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.cronograma: ~2 rows (aproximadamente)
DELETE FROM `cronograma`;
/*!40000 ALTER TABLE `cronograma` DISABLE KEYS */;
INSERT INTO `cronograma` (`idcronograma`, `idgrupo`, `aprovado`, `analisando`, `revisando`, `enviado`) VALUES
	(2, 63, 0, 1, 0, 1),
	(3, 64, 0, 1, 0, 1);
/*!40000 ALTER TABLE `cronograma` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.desistenciaaluno
DROP TABLE IF EXISTS `desistenciaaluno`;
CREATE TABLE IF NOT EXISTS `desistenciaaluno` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `motivo` int(11) NOT NULL,
  `dataDesistencia` date NOT NULL,
  `descricao` text COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`idDesistencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- Copiando dados para a tabela tcc.desistenciaaluno: ~0 rows (aproximadamente)
DELETE FROM `desistenciaaluno`;
/*!40000 ALTER TABLE `desistenciaaluno` DISABLE KEYS */;
/*!40000 ALTER TABLE `desistenciaaluno` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.desistenciaprof
DROP TABLE IF EXISTS `desistenciaprof`;
CREATE TABLE IF NOT EXISTS `desistenciaprof` (
  `idDesistencia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `dataDesistencia` date NOT NULL,
  `motivo` int(11) NOT NULL,
  PRIMARY KEY (`idDesistencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.desistenciaprof: ~0 rows (aproximadamente)
DELETE FROM `desistenciaprof`;
/*!40000 ALTER TABLE `desistenciaprof` DISABLE KEYS */;
/*!40000 ALTER TABLE `desistenciaprof` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.evento
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
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idcronograma`) REFERENCES `cronograma` (`idcronograma`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.evento: ~0 rows (aproximadamente)
DELETE FROM `evento`;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.grupo
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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.grupo: ~4 rows (aproximadamente)
DELETE FROM `grupo`;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` (`idgrupo`, `dataCriacao`, `titulo`, `descricao`, `objetivoGeral`, `objetivoEspecifico`, `justificativa`, `tipodePesquisa`, `metodologia`, `resultadoEsperado`, `fraselema`, `aceito`, `visto`, `recusado`, `revisando`, `preProjeto`, `cronograma`) VALUES
	(63, '2015-09-02', 'Gerenciamento de TCC', 'Gerenciamento de TCC HUASUHHSAHAUHSAHUUSHAHU SUAHSUHA', 'h', 'h', 'h', 'h', 'h', 'h', NULL, 1, 1, 0, 0, 0, 0),
	(64, '2015-09-03', 'cmskcskcs', 'amsiwnduwnduwnduwnd', 'k', 'k', 'k', 'k', 'k', 'k', NULL, 1, 1, 0, 0, 0, 0),
	(65, '2015-09-30', 'Olaaaaaaa', 'Olaaaaaaaaaaa Pelo amor de deus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0),
	(66, '2015-09-30', 'Space Jam', 'TCC Sobre o brilhante filme Space Jam, o qual fala muito sobre o futuro.\nProfessora é o que é, ou você aceita ou não.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 1, 0),
	(67, '2015-09-30', 'Éééééééééééééé', 'Projeto sobre éééééé.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0);
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.grupo_has_users
DROP TABLE IF EXISTS `grupo_has_users`;
CREATE TABLE IF NOT EXISTS `grupo_has_users` (
  `idgrupo` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `tipo` int(1) NOT NULL COMMENT 'representa o tipo do individuou 1=aluno,2=orientador,3=coorientador',
  PRIMARY KEY (`idgrupo`,`uid`),
  KEY `fk_grupo_has_users_users1_idx` (`uid`),
  KEY `fk_grupo_has_users_grupo_idx` (`idgrupo`),
  CONSTRAINT `FK_grupo_has_users_grupo` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grupo_has_users_users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.grupo_has_users: ~14 rows (aproximadamente)
DELETE FROM `grupo_has_users`;
/*!40000 ALTER TABLE `grupo_has_users` DISABLE KEYS */;
INSERT INTO `grupo_has_users` (`idgrupo`, `uid`, `tipo`) VALUES
	(63, 1, 1),
	(63, 6, 1),
	(63, 7, 1),
	(63, 12, 2),
	(64, 9, 1),
	(64, 12, 2),
	(65, 8, 1),
	(66, 2, 1),
	(66, 3, 1),
	(66, 17, 1),
	(66, 25, 2),
	(67, 2, 1),
	(67, 3, 1),
	(67, 27, 2),
	(67, 30, 1);
/*!40000 ALTER TABLE `grupo_has_users` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.likes
DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `idlikes` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL,
  PRIMARY KEY (`idlikes`),
  KEY `uid` (`uid`),
  KEY `msg_id` (`msg_id`),
  CONSTRAINT `fk_msg` FOREIGN KEY (`msg_id`) REFERENCES `messages` (`msg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.likes: ~15 rows (aproximadamente)
DELETE FROM `likes`;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`idlikes`, `uid`, `msg_id`) VALUES
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
	(34, 15, 128),
	(35, 1, 125),
	(36, 17, 127);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.mensagens
DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `mensagem` varchar(255) CHARACTER SET latin1 NOT NULL,
  `data` datetime NOT NULL,
  `lido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.mensagens: ~41 rows (aproximadamente)
DELETE FROM `mensagens`;
/*!40000 ALTER TABLE `mensagens` DISABLE KEYS */;
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
	(39, 1, 7, 'oiiii', '0000-00-00 00:00:00', 1),
	(40, 1, 7, 'pppp', '0000-00-00 00:00:00', 1),
	(41, 1, 7, 'ola', '0000-00-00 00:00:00', 1);
/*!40000 ALTER TABLE `mensagens` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `uid_fk` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `created` int(11) DEFAULT '1269249260',
  PRIMARY KEY (`msg_id`),
  KEY `ip` (`ip`),
  KEY `fk_messages_users1_idx` (`uid_fk`),
  CONSTRAINT `Fk_users_udi` FOREIGN KEY (`uid_fk`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.messages: ~25 rows (aproximadamente)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
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
	(128, 'Eu sou um gordinho gostoso, gordinhoo gostosoooo haha', 9, '127.0.0.1', 1428791672),
	(130, 'Intro JS success...', 12, '::1', 1441809367);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.tipoevento
DROP TABLE IF EXISTS `tipoevento`;
CREATE TABLE IF NOT EXISTS `tipoevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black',
  `textcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.tipoevento: ~8 rows (aproximadamente)
DELETE FROM `tipoevento`;
/*!40000 ALTER TABLE `tipoevento` DISABLE KEYS */;
INSERT INTO `tipoevento` (`id`, `nome`, `imagem`, `color`, `textcolor`) VALUES
	(1, 'Pesquisas', '<i class=\'fa fa-search\'></i>', '#87CEEB', '#FFF'),
	(2, 'Reunião', '<i class=\'fa fa-users\'></i>', '#FF8C00', '#FFF'),
	(3, 'Aprovação', '<i class=\'fa fa-check-square\'></i>', '#00FF7F', '#FFF'),
	(4, 'Monografia', '<i class=\'fa fa-pencil-square\'></i>', '#EEAEEE', '#FFF'),
	(5, 'Revisão', '<i class=\'fa fa-eye\'></i>', '#FF3030', '#FFF'),
	(6, 'Produção/Programação', '<i class=\'fa fa-file-code-o\'></i>', '#000', '#FFF'),
	(7, 'Comissão de Ética', '<i class=\'fa fa-paperclip\'></i>', '#E6E6FA', '#FFF'),
	(8, 'Outros', '<i class=\'fa fa-asterisk\'></i>', '#1E90FF', '#FFF');
/*!40000 ALTER TABLE `tipoevento` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.users: ~23 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`uid`, `username`, `password`, `email`, `prontuario`, `fotouser`, `horario`, `limite`, `descricao`, `cargo`, `tipo`, `primeiroacesso`) VALUES
	(1, 'Leonardo Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'leo.piracaia@hotmail.com', 1262751, 'fotoUser/thumbnail_1443588915.jpg', '2015-10-06 20:41:33', '2015-10-06 20:43:33', 'Programador Júnior, Formando em Análise e Desenvolvimento de Sistemas', 'Aluno', 0, 1),
	(2, '---', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@admin.com', NULL, 'fotoUser/padraoUser.jpg', '2014-09-30 21:45:15', '2015-09-30 21:45:17', 'admin', 'admin', 0, 0),
	(3, '---', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@admin.com', NULL, 'fotoUser/padraoUser.jpg', '2015-09-30 21:46:15', '2015-09-30 21:46:17', 'admin', 'admin', 0, 0),
	(6, 'Everton de Paula', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'everton.projetos@gmail.com', 0, 'fotoUser/thumbnail_1443387799.jpg', '2015-10-13 14:11:43', '2015-10-13 14:13:43', 'teste', 'Aluno', 0, 1),
	(7, 'Ana carolina', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ana@hotmail.com', 0, 'fotoUser/thumbnail_1427733717.jpg', '2015-09-09 19:25:19', '2015-09-09 19:27:19', 'teste', 'Aluno', 0, 0),
	(8, 'Rodrigo Adolfo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rodrigo@hotmail.com', 0, 'fotoUser/thumbnail_1427733865.jpg', '2015-09-30 21:30:11', '2015-09-30 21:32:11', 'teste', 'Aluno', 0, 0),
	(9, 'Marcio Vianna', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcio@hotmail.com', 111111111, 'fotoUser/thumbnail_1427734132.jpg', '2015-09-03 15:18:27', '2015-09-03 15:20:27', 'teste', 'Aluno', 0, 0),
	(10, 'Marcos Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcosevmartins@gmail.com', 22222222, 'fotoUser/thumbnail_1427734208.jpg', '2015-08-10 14:38:58', '2015-08-10 14:40:58', 'Programador e Analista de Sistemas', 'Aluno', 0, 0),
	(11, 'Claudia Martins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'claubmartins@gmail.com', 3333333, 'fotoUser/thumbnail_1427733083.jpg', '2015-08-10 22:24:48', '2015-08-10 22:26:48', 'teste', 'Aluno', 0, 0),
	(12, 'Ana Giancoli', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'paulagiancoli@gmail.com', 1234567, 'fotoUser/thumbnail_1443294351.jpg', '2015-10-06 20:34:25', '2015-10-06 20:36:25', 'teste', 'Professor', 1, 1),
	(14, 'Jefferson de Souza', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jeff@hotmail.com', 1234567, 'fotoUser/thumbnail_1427771298.jpg', '2015-03-30 19:28:05', '2015-03-30 19:30:05', 'Prof. Dr. Jefferson de Souza Pinto\r\nDoutor em Engenharia Mecânica - DEF/FEM/UNICAMP\r\nPós-doutor em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nPós-doutorando em Engenharia Mecânica - DEMM/FEM/UNICAMP\r\nInstituto Federal de São Paulo - Campus Bragança Paulista', 'Professor', 1, 0),
	(15, 'João Paulo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'joaolds@gmail.com', 1234567, 'fotoUser/thumbnail_1427919145.jpg', '2015-08-11 21:12:12', '2015-08-11 21:14:12', 'I\'M GAY', 'Aluno', 0, 0),
	(17, 'Mauro Mazzola', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mauro@hotmail.com', 1234567, 'fotoUser/thumbnail_1427919031.jpg', '2015-09-30 21:59:53', '2015-09-30 22:01:53', NULL, 'Aluno', 0, 0),
	(18, 'André Lemme', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'andre@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920239.png', '2015-04-15 18:52:49', '2015-04-15 18:54:49', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Engenharia de Software - ESWI2, Projeto de Sistemas II - PS2I6, Gerencia de Projetos - GPSIIP3, Treinamento Professor', 'Professor', 1, 0),
	(19, 'Wilson Vendramel', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'vendramel@hotmail.com', 1234567, 'fotoUser/thumbnail_1427920193.png', '2015-06-03 15:04:10', '2015-06-03 15:06:10', 'Professor e Coordenador ADS Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Análise Orientada a Objetos - AOOI3, Arquitetura de Software - ASWI4, Qualidade de Software - QSWI5, Treinamento Professor, Alunos ADS', 'Coordenador ADS', 1, 0),
	(20, 'André Panhan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'apanhan@gmail.com', 1234567, 'fotoUser/thumbnail_1427930009.png', '2015-08-11 21:08:47', '2015-08-11 21:10:47', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Desenvolvimento para Web II - DW2A6, Programação Orientada a Objetos - POOI4, Treinamento Professor', 'Professor', 1, 0),
	(21, 'Luciano Bernardes', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'luciano@hotmail.com', 1234567, 'fotoUser/thumbnail_1427930133.png', '2015-04-15 19:53:26', '2015-04-15 19:55:26', 'Enquetes - Servidores , Coordenadoria de Extensão - Uso Interno, Coordenação do Curso de ADS, Coordenadoria de Área - Informática, Coordenação de Pesquisa (2015), Segurança e Auditoria de Sistemas - SEGA6, Linguagem de Programação I - LP1I1, Serviços de Rede - SSRI5, Eletiva I - EL1I5, Treinamento Professor', 'Professor', 1, 0),
	(22, 'Marcel Zacarias', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'marcel@hotmail.com', 111111111, 'fotoUser/thumbnail_1428453049.jpg', '2015-04-07 21:31:57', '2015-04-07 21:33:57', NULL, 'Aluno', 0, 0),
	(23, 'Eliane Andreoli', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'eliane@hotmail.com', 1234567, 'fotoUser/thumbnail_1428721478.jpg', '2015-04-11 00:05:20', '2015-04-11 00:07:20', 'Professora de Português e Inglês', 'Professor', 1, 0),
	(24, 'Rosalvo Soares C. Filho', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rosalvo@hotmail.com', 123456, 'fotoUser/thumbnail_1429109792.jpg', '2015-04-15 11:56:49', '2015-04-15 11:58:49', 'Professor de Redes de Computadores', 'Professor', 1, 0),
	(25, 'Ana Cristina Gobbo César', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anacristina@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109742.jpg', '2015-09-30 21:58:57', '2015-09-30 22:00:57', 'Professora de TCC', 'Professor', 1, 0),
	(26, 'Bianca Maria Pedrosa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bianca@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109829.jpg', '2015-04-15 11:57:30', '2015-04-15 11:59:30', 'Professora de WEB', 'Professor', 1, 0),
	(27, 'Flavio César Amate', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'flavio@hotmail.com', 1234567, 'fotoUser/thumbnail_1429109684.jpg', '2015-09-30 22:03:22', '2015-09-30 22:05:22', 'Professor de Matemática', 'Professor', 1, 0),
	(30, 'João Antunes Pereira da Cunha ', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jj@gmail.com', 1231231, 'fotoUser/padraoUser.jpg', '2015-09-30 22:02:42', '2015-09-30 22:04:42', NULL, NULL, 0, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Copiando estrutura para tabela tcc.workflow
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
  KEY `idGrupo` (`idGrupo`),
  CONSTRAINT `fk_idGrupo_workflow` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela tcc.workflow: ~4 rows (aproximadamente)
DELETE FROM `workflow`;
/*!40000 ALTER TABLE `workflow` DISABLE KEYS */;
INSERT INTO `workflow` (`idWorkflow`, `idGrupo`, `participantes`, `start`, `end`, `data_conclusao`, `concluido`, `nomeEvento`, `descricao`) VALUES
	(23, 63, '7,12,6,1', '2015-09-30 21:09:11', '2015-10-05 00:00:00', '2015-10-15 21:22:06', 1, 'Verificar o arquivo', 'Verificar arquivo de como Elaborar um TCC.'),
	(24, 63, '7,12,6', '2015-09-30 21:25:11', '2015-10-20 00:00:00', '2015-10-19 22:09:42', 1, 'Verificar TEXTOS DE JUCA CHAVEZ', 'Por favor façam alguma coisa, por que eu já estou muito nervoso..... \\ /'),
	(25, 63, '7,12,6,1', '2015-10-02 01:47:24', '2015-11-15 00:00:00', '2015-11-20 01:51:22', 1, 'Fazer tudo isso', 'É só fazer mano jow.'),
	(26, 63, '7,12,6,1', '2015-10-02 01:52:04', '2015-11-07 00:00:00', '2015-11-04 01:53:34', 1, 'Eita pelo', 'Fazer sem demora'),
	(27, 63, '7,12,6', '2015-10-02 01:54:22', '2015-12-10 00:00:00', '2015-10-06 20:38:03', 1, 'Eita Pelo 2', 'Fazer novamente tudo.');
/*!40000 ALTER TABLE `workflow` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
