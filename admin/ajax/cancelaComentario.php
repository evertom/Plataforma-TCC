<?php
	$id = isset($_POST['id']) ? $_POST['id']:"";
	
		require_once('../includes/Conexao.class.php');
			try {
				$pdo = new Conexao(); 
											
				$result = $pdo->select("SELECT comment FROM comments WHERE com_id = ".$id."");
				
				if(count($result)){
					foreach($result as $res){
						$msg = $res['comment'];
					}
					echo $msg;
				}else{
					return false;
				}
			}catch (PDOException $e){
				return false;
			}
?>