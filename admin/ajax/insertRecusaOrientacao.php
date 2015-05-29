<?php
	require_once('../verifica-logado.php');
	$id1 = 		isset($_POST['id1']) ? $_POST['id1']:"";
	$id2 = 		isset($_POST['id2']) ? $_POST['id2']:"";
	$id3 = 		isset($_POST['id3']) ? $_POST['id3']:"";
	$idgrupo = 	isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	$idprof = 	isset($_POST['idprof']) ? $_POST['idprof']:"";
	$descri = 	isset($_POST['descri']) ? $_POST['descri']:"";
	$acao = 	isset($_POST['acao']) ? $_POST['acao']:"";
	
	if($acao == "inserir"){
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
				
				$Administracao->id1 = $id1;
				$Administracao->id2 = $id2;
				$Administracao->id3 = $id3;
				$Administracao->idgrupo = $idgrupo;
				$Administracao->idProf = $idprof;
				$Administracao->descri = $descri;

				$result = $Administracao->RecusaOrientacao();
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
	if($acao == "editar"){
		require_once('../class-PDO/class/TabelasDePreco.class.php');
			try {
				$TabelasDePreco = new TabelasDePreco(); 
									
				$result = $TabelasDePreco->UpdateNcmSubs($ncm,$mva,$icms_destino,$uf_origem,$uf_destino);
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
	if($acao == "excluir"){
		require_once('../class-PDO/class/TabelasDePreco.class.php');
			try {
				$TabelasDePreco = new TabelasDePreco(); 
									
				$result = $TabelasDePreco->excluiNcmSubs($ncm,$uf_origem,$uf_destino);
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