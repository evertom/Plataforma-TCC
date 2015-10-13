<?php 
$tempovida = time(); //tempo atual
$tempo_usu = time() + 30;//tempo em que o usuario fica no banco de dados
$tempo_msg = time() + 180;//tempo em que as mensagens ficam no banco de dados
//tabelas
$tabela_msg = 'chat_msg';
$tabela_usu = 'chat_usu';
//configura��es gerais
$rodape = '';
$titulo = '';
$maxusu = 20;

//funcoes
function sql_inject($campo){
	$campo = get_magic_quotes_gpc() == 0 ? addslashes($campo) : $campo;
	$campo = strip_tags($campo);
	return preg_replace("@(--|\#|\*|;|=)@s", "", $campo); 
}
?>