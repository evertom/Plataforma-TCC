<?php
	// Conexão
	require_once('Conexao.class.php');
	require_once('../verifica-logado.php');

	// Recuperando informações
	$ultimo = (int) $_POST['ultimo'];
				
	$pdo = new Conexao(); 
	$resultado = $pdo->select("SELECT * FROM users WHERE uid < ".$ultimo." AND uid != ".$_SESSION['id_login']." ORDER BY uid DESC LIMIT 0,1");
	$pdo->desconectar();
								 
	if(count($resultado)){
		foreach ($resultado as $res) {
			echo '<p lang="'.$res['uid'].'"><span class="type" id="'.$res['uid'].'"></span><a href="javascript:void(0);" nome="'.$res['username'].'" id="'.$res['uid'].'" class="comecar">'.$res['username'].'</a></p>';
		}
	}
?>