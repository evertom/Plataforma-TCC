<?php
	@session_start();
	ob_start();
	$myId = $_SESSION['id_login'];
	
	require_once("../../includes/Conexao.class.php");
	
	$pdo = new Conexao();
	
	$acao = $_POST['acao'];
	
	switch($acao){
		case 'inserir':
			$para = $_POST['para'];
			$mensagem = strip_tags($_POST['mensagem']);
			$nome = $_SESSION['user'];
			
			$insert['id_de'] = $myId;
			$insert['id_para'] = $para;
			$insert['mensagem'] = $mensagem;
	
			$inserir = $pdo->insert($insert, 'mensagens');
			if($inserir){
				echo '<li><span>'.$nome.' disse:</span><p>'.$mensagem.'</p></li>';
			}
		break;
		
		case 'verificar':
			$ids = (isset($_POST['ids'])) ? $_POST['ids'] : '';
			$users = (isset($_POST['users'])) ? $_POST['users'] : '';
			$retorno = array();
			
			if($ids == ''){
				if(isset($retorno['mensagens']))
					$retorno['mensagens'] == '';
			}else{
				foreach($ids as $indice => $id){
					$stmt = $pdo->select("SELECT * FROM mensagens WHERE id_de = $myId AND id_para = $id OR id_de = $id AND id_para = $myId");
					
					$mensagem = '';
					foreach($stmt as $ft){
						$temp = $ft['id_de'];
						$stmt2 = $pdo->select("SELECT uid,username FROM `users` WHERE uid=$temp ;");
							foreach($stmt2 as $name){
								if($_SESSION['id_login'] == $name['uid']){
									$mensagem .= '<li><span id="meuUser"><h3>'.$name['username'].'</h3> disse:</span><br/><p>'.$ft['mensagem'].'</p></li>';
									
								}else{
									$mensagem .= '<li><span id="outroUser"><h4>'.$name['username'].'</h4> disse:</span><br/><p>'.$ft['mensagem'].'</p></li>';
								}
							}
					}
					$retorno['mensagens'][$id] = $mensagem;
				}
			}
		
			$stmt = $pdo->select("SELECT id_de FROM `mensagens` WHERE id_para = $myId AND lido = 0 GROUP BY id_de");
						
			if(!count($stmt)){
				if(isset($retorno['nao_lidos']))
					$retorno['nao_lidos'] == '';
			}else{
				foreach($stmt as $user){
					$retorno['nao_lidos'][] = $user['id_de'];
				}
			}
			$retorno = json_encode($retorno);
			echo $retorno;
		break;
		
		case 'mudar_status':
			$user = $_POST['user'];
			$lido['lido'] = '1';
			$mudar_st = $pdo->update( $lido, "mensagens" , "id_de=$user AND id_para=$myId");
		break;
	}
?>