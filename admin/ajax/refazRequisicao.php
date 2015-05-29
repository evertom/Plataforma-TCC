<?php
	$idgrupo = 		isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	$idUser =	 	isset($_POST['idUser']) ? $_POST['idUser']:"";
	$idProf =	 	isset($_POST['idProf']) ? $_POST['idProf']:"";
	$texto =	 	isset($_POST['texto']) ? $_POST['texto']:"";

	require_once('../includes/Administracao.class.php');
		try {
			$Administracao = new Administracao(); 
			
			$Administracao->idgrupo = $idgrupo;
			$Administracao->idProf = $idProf;
			$Administracao->idUser = $idUser;
			$Administracao->texto = $texto;

			$result = $Administracao->RefazRequisicao();
			if($result != false){
				$res['msg'] = true;
				echo json_encode($res);
			}else{
				$res['msg'] = false;
				echo json_encode($res);
			}
		}catch (PDOException $e){
			echo json_encode($e->getMessage());
		}
	
?>