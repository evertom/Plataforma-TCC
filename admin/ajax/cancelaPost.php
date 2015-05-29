<?php
	$id = isset($_POST['id']) ? $_POST['id']:"";
	
		require_once('../includes/Conexao.class.php');
			try {
				$pdo = new Conexao(); 
											
				$result = $pdo->select("SELECT message FROM messages WHERE msg_id = ".$id."");
				
				if(count($result)){
					foreach($result as $res){
						$msg = $res['message'];
					}
					echo $msg;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>