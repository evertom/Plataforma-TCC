<?php

require('class.mysql.php');
require('config.inc.php');

session_start();
ob_start(); // Inicia o fluxo

header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');

$nick = $_SESSION['usu_nick'];

$sql = new Mysql;
//mostra que usuario saiu do bate papo
$sql->Consulta("INSERT INTO $tabela_msg (reservado,usuario,cor,msg,falacom,tempo)VALUES('0','$nick','#006699','saiu da sala.','Todos','$tempo_msg')");
$sql->Consulta("INSERT INTO historico (usuario,msg)VALUES('$nick','saiu da sala.')");
//deleta usuario do banco pois nao esta mais online
$sql->Consulta("DELETE FROM $tabela_usu  WHERE nick = '" . $nick . "'");

//conta quantos usuarios ainda estao no chat
$result = $sql->Consulta("SELECT count(nick) as 'soma' FROM chat_usu");
//recebe contagem
$contagem = mysql_fetch_assoc($result);
$total = $contagem['soma'];

if ($total == 0) {
    header('Location:impPdf.php');
} else {
    header('Location:exit.php');
}
?>