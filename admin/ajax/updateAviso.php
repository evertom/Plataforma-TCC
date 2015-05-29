<?php
	//dados vindo do ajax da pag icms_substituicao
	$user = 		isset($_POST['user']) ? $_POST['user']:"";
	
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
								
				$Administracao->id = $user;
			
				$result = $Administracao->UpdateAviso();
				if($result != false){
					return true;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>