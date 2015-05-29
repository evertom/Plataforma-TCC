<?php
	$id1 = 		isset($_POST['id1']) ? $_POST['id1']:"";
	$id2 = 		isset($_POST['id2']) ? $_POST['id2']:"";
	$id3 = 		isset($_POST['id3']) ? $_POST['id3']:"";
	$idgrupo = 	isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	$idprof = 	isset($_POST['idprof']) ? $_POST['idprof']:"";
	
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
								
				$Administracao->id1 = $id1;
				$Administracao->id2 = $id2;
				$Administracao->id3 = $id3;
				$Administracao->idgrupo = $idgrupo;
				$Administracao->idprof = $idprof;
			
				$result = $Administracao->MaisDetalhes();
				if($result != false){
					return true;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>