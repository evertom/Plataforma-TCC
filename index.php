<?php
	$atual = (isset($_GET['pg'])) ? $_GET['pg'] : 'home';

	if($atual == 'index'){
		$atual = 'home';
	}
		 
	if(file_exists($atual.'.php')){
		
		$pagina = (file_exists($atual.'.php')) ? $atual : 'erro';

	}else{
		$pagina = (file_exists($atual.'.php')) ? $atual : 'erro';
	}
	
	require_once("{$pagina}.php");
?>