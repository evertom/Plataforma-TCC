<?php
	$idgrupo = 		isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	$objGeral = 		isset($_POST['objGeral']) ? $_POST['objGeral']:"";
	$objEspec = 		isset($_POST['objEspec']) ? $_POST['objEspec']:"";
	$justificativa = 	isset($_POST['justificativa']) ? $_POST['justificativa']:"";
	$tipoPesquisa = 	isset($_POST['tipoPesquisa']) ? $_POST['tipoPesquisa']:"";
	$metodologia = 		isset($_POST['metodologia']) ? $_POST['metodologia']:"";
	$resultados = 		isset($_POST['resultados']) ? $_POST['resultados']:"";
	$acao = 			isset($_POST['acao']) ? $_POST['acao']:"";
	
	if($acao == "inserir"){
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
								
				$Administracao->objGeral = $objGeral;
				$Administracao->objEspec = $objEspec;
				$Administracao->justificativa = $justificativa;
				$Administracao->tipoPesquisa = $tipoPesquisa;
				$Administracao->metodologia = $metodologia;
				$Administracao->resultados = $resultados;
				$Administracao->idgrupo = $idgrupo;
				
				$result = $Administracao->InserePreProjeto();
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
	}
?>