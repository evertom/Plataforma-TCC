<?php
require_once('Conexao.class.php');
class Wall_Updates extends Conexao{
	private $data = array();
	public function __construct(){
		$this->erro = '';
	}
	public function __set($name, $value){
		$this->data[$name] = $value;
	}
	public function __get($name){
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}	
		$trace = debug_backtrace();
		trigger_error(
			'Undefined property via __get(): ' . $name .
			' in ' . $trace[0]['file'] .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
	}
	
	
	public function Updates($uid){
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT M.msg_id, M.uid_fk, M.message, M.created, U.username, U.fotouser FROM messages M, users U  WHERE M.uid_fk = U.uid order by M.msg_id desc ");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);     
				//desconecta do banco de dados
				parent::desconectar();
				return $resultado;
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		  
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return null;
		}
	}
	
	public function UpdatesAjax($uid,$inicio,$qntd){
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT M.msg_id, M.uid_fk, M.message, M.created, U.username, U.fotouser FROM messages M, users U  WHERE M.uid_fk = U.uid order by M.msg_id desc LIMIT $inicio,$qntd");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);     
				//desconecta do banco de dados
				parent::desconectar();
				return $resultado;
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		  
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return null;
		}
	}
	
	//Selecionando usuarios
	   public function UsersSelect(){
	   
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT * FROM users ORDER BY uid DESC LIMIT 0,3");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);     
				//desconecta do banco de dados
				parent::desconectar();
				return $resultado;
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}
	}
	
	
	//Comments
	   public function Comments($msg_id){
	   
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT C.msg_id_fk, C.com_id, C.uid_fk, C.comment, C.created, U.username, U.fotouser FROM comments C, users U WHERE C.uid_fk=U.uid and C.msg_id_fk='$msg_id' order by C.com_id asc ");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);     
				//desconecta do banco de dados
				parent::desconectar();
				return $resultado;
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}
	}
	
	//Avatar Image
	public function Gravatar($uid) 
	{
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
			
			$pdo = new Conexao(); 
			$result = $pdo->select("SELECT fotouser FROM users WHERE uid = '$uid'");
								
			if(count($result)){
				foreach ($result as $res) { 
					$data = $res['fotouser'];
				}
			}
			//desconecta do banco de dados
			parent::desconectar();
			return $data;;
			
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return null;
		}
	}
	
	//Avatar update
	public function AtualizaThumb() 
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparação para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE users SET fotouser = :pfotouser WHERE uid = :puid');
		$stmt->bindValue(':pfotouser', $this->thumb, PDO::PARAM_STR);
		$stmt->bindValue(':puid', $this->uid, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
			
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return null;
		}
	}
	
	//Insert Update
	public function Insert_Update($uid, $update) 
	{
		$time=time();
		$ip=$_SERVER['REMOTE_ADDR'];
	   
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT msg_id,message FROM messages WHERE uid_fk='$uid' order by msg_id desc limit 1");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);   
				
				if ($update!=$resultado['message']) {
					//query a ser feita no banco de dados, usando PDO
					$retorno2 = $this->pdo->prepare("INSERT INTO `messages` (message, uid_fk, ip,created) VALUES ('$update', '$uid', '$ip','$time')");
					
					if($retorno2->execute()){
												
						$retorno3 = $this->pdo->prepare("SELECT M.msg_id, M.uid_fk, M.message, M.created, U.username FROM messages M, users U where M.uid_fk= U.uid and M.uid_fk = '$uid' order by M.msg_id desc limit 1");	
						
						if($retorno3->execute()){
							
							$resultfinal = $retorno3->fetchAll(PDO::FETCH_ASSOC); 
							//desconecta do banco de dados
							parent::desconectar();
							return $resultfinal;
						}
					}
				}		
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}
    }
	
	//Delete update
	public function Delete_Update($uid, $msg_id){
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
			echo "<script>alert('chego aki comm');</script>";
			
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("DELETE FROM `comments` WHERE msg_id_fk = '$msg_id'");
			
			if($retorno->execute()){
				$retorno2 = $this->pdo->prepare("DELETE FROM `messages` WHERE msg_id = '$msg_id' and uid_fk='$uid'");
				if($retorno2->execute()){
					//desconecta do banco de dados
					parent::desconectar();
					return true;
				}	
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				return false;
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}    
    }
	
	//Insert Comments
	public function Insert_Comment($uid,$msg_id,$comment) 
	{
	
	   	$time=time();
		$ip=$_SERVER['REMOTE_ADDR'];
		
		try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
		  
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("SELECT com_id,comment FROM `comments` WHERE uid_fk='$uid' and msg_id_fk='$msg_id' order by com_id desc limit 1 ");
			
			if($retorno->execute()){
				// preenche o combo
				$resultado = $retorno->fetchAll(PDO::FETCH_ASSOC);   
				
				if ($comment!=$resultado['comment']) {
					//query a ser feita no banco de dados, usando PDO
					$retorno2 = $this->pdo->prepare("INSERT INTO `comments` (comment, uid_fk,msg_id_fk,ip,created) VALUES ('$comment', '$uid','$msg_id', '$ip','$time')");
					
					if($retorno2->execute()){
						$retorno3 = $this->pdo->prepare("SELECT C.com_id, C.uid_fk, C.comment, C.msg_id_fk, C.created, U.username FROM comments C, users U where C.uid_fk=U.uid and C.uid_fk='$uid' and C.msg_id_fk='$msg_id' order by C.com_id desc limit 1");	
						
						if($retorno3->execute()){
							$resultfinal = $retorno3->fetchAll(PDO::FETCH_ASSOC); 
							return $resultfinal;
							//desconecta do banco de dados
							parent::desconectar();
						}
					}
				}		
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				//atribui um valor de erro para a variável    
				//retorna falso para a aplicação, houve algum tipo de erro
				return $this->erro = 'Erro ao atualizar, entre em contato com o administrador !';
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}       
    }
	
	//Delete Comments
	public function Delete_Comment($uid, $com_id){
	    try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
			
			//query a ser feita no banco de dados, usando PDO
			$retorno = $this->pdo->prepare("DELETE FROM comments WHERE com_id = '$com_id'");
			
			if($retorno->execute()){
				return true;	
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				return false;
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}         
    }
	
	//Atualiza hora
	public function UpdateHora($atual,$expira,$uid){
	    try{
			//verifica se há conexão com o banco de dados
			if(parent::getPDO() == null){
				//caso não tenha conecta-se com o banco de dados
				parent::conectar();
			}
			
			//query a ser feita no banco de dados, usando PDO
			//$stmt = $this->pdo->prepare("UPDATE users SET horario = time(now()), limite = ADDTIME(time(now()), '00:02:00')  WHERE uid = :puid");
			$stmt = $this->pdo->prepare("UPDATE users SET horario = :phorario, limite = :plimite WHERE uid = :puid");
			$stmt->bindValue(':phorario', $atual, PDO::PARAM_STR);
			$stmt->bindValue(':plimite', $expira, PDO::PARAM_STR);
			$stmt->bindValue(':puid', $uid, PDO::PARAM_INT);
					
			if($stmt->execute()){
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				return true;	
			}else{
				//caso haja erro na query deconecta do banco de dados
				parent::desconectar();
				return false;
			}
		}catch( PDOException $e ){
			echo $e->getMessage ();
			return null;
		}         
    }
}
?>
