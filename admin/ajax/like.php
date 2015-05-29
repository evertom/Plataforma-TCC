<?php
	$idmsg = 	isset($_POST['idmsg']) ? $_POST['idmsg']:"";
	$iduser = 	isset($_POST['iduser']) ? $_POST['iduser']:"";

	require_once('../includes/Administracao.class.php');
	require_once('../includes/Conexao.class.php');
	
	$pdo = new Conexao();
	$result = $pdo->select("SELECT * FROM likes WHERE uid = ".$iduser." AND msg_id = ".$idmsg."");
	
	if(count($result)){
		try {
			$Administracao = new Administracao(); 
			
			$Administracao->idmsg = $idmsg;
			$Administracao->iduser = $iduser;
			
			$result = $Administracao->Unlike();
			if($result != false){
				echo $result;
			}else{
				$result = 0;
				echo $result;
			}
		}catch (PDOException $e){
			echo json_encode($e->getMessage());
		}
		
	}else{
		try {
			$Administracao = new Administracao(); 
			
			$Administracao->idmsg = $idmsg;
			$Administracao->iduser = $iduser;
			
			$result = $Administracao->InsertLike();
			if($result != false){
				echo $result;
			}else{
				$res['msg'] = false;
				echo json_encode($res);
			}
		}catch (PDOException $e){
			echo json_encode($e->getMessage());
		}
	}
?>