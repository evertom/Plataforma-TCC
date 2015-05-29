<?php
	$texto = 	isset($_POST['texto']) ? $_POST['texto']:"";
	$id = 		isset($_POST['id']) ? $_POST['id']:"";
	
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
								
				$Administracao->texto = $texto;
				$Administracao->id = $id;
			
				$result = $Administracao->UpdatePostFeeds();
				if($result != false){
					return true;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>