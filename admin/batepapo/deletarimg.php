<?php

$dir = 'img_enviada/';
//$dir ='/home/minin/public_html/chat/img_enviada/';  
$aberto = @opendir($dir);//abre o diretorio 
while($arq = @readdir($aberto)) {//le o diretorio
	if(($arq != '.') && ($arq != '..')) {//desconsidera subdiretorios
		@unlink('img_enviada/'.$arq); //apaga as imagens
	}
}
@closedir($aberto);
?>