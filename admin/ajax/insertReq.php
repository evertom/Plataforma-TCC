<?php
	$pront1 = 		isset($_POST['pront1']) ? $_POST['pront1']:"";
	$pront2 = 		isset($_POST['pront2']) ? $_POST['pront2']:2;
	$pront3 = 		isset($_POST['pront3']) ? $_POST['pront3']:3;
	$titulo = 		isset($_POST['titulo']) ? $_POST['titulo']:"";
	$descri = 		isset($_POST['descri']) ? $_POST['descri']:"";
	$user = 		isset($_POST['user']) ? $_POST['user']:"";
	$orientador = 	isset($_POST['orientador']) ? $_POST['orientador']:"";
	$coorient = 	isset($_POST['coorient']) ? $_POST['coorient']:"";
	$acao = 		isset($_POST['acao']) ? $_POST['acao']:"";
	
	if($acao == "inserir"){
		require_once('../includes/Administracao.class.php');
			try {
				$Administracao = new Administracao(); 
				
				$Administracao->pront1 = $pront1;
				$Administracao->pront2 = $pront2;
				$Administracao->pront3 = $pront3;
				$Administracao->titulo = $titulo;
				$Administracao->orientador = $orientador;
				$Administracao->coorient = $coorient;
				$Administracao->user = $user;
				$Administracao->descri = $descri;

				$result = $Administracao->RequerimentoProf();
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