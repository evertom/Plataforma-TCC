<?php
	$idgrupo = 		isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	$idAluno1 = 	isset($_POST['idAluno1']) ? $_POST['idAluno1']:"";
	$idAluno2 = 	isset($_POST['idAluno2']) ? $_POST['idAluno2']:"";
	$idAluno3 = 	isset($_POST['idAluno3']) ? $_POST['idAluno3']:"";
	$idProf = 		isset($_POST['idProf']) ? $_POST['idProf']:"";
	
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
								
				$Administracao->idgrupo = $idgrupo;
				$Administracao->idAluno1 = $idAluno1;
				$Administracao->idAluno2 = $idAluno2;
				$Administracao->idAluno3 = $idAluno3;
				$Administracao->idProf = $idProf;
			
				$result = $Administracao->UpdateVistoGrupo();
				if($result != false){
					return true;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>