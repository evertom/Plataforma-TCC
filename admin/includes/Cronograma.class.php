<?php	
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');
class Cronograma extends Conexao{
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
	
	public function insertCronograma(){
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$stmt = $this->pdo->prepare('INSERT INTO cronograma(idgrupo,aprovado, analisando, revisando, enviado) VALUES(:pidgrupo,:paprovado,:panalisando,:previsando,:penviado)');
			$stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
			$stmt->bindValue(':paprovado', $this->aprovado, PDO::PARAM_BOOL);
			$stmt->bindValue(':panalisando', $this->analisando, PDO::PARAM_BOOL);
			$stmt->bindValue(':previsando', $this->revisando, PDO::PARAM_BOOL);
			$stmt->bindValue(':penviado', $this->enviado, PDO::PARAM_BOOL);
			
			if($stmt->execute()){
				$this->idCronograma = (int)$this->pdo->lastInsertId();
				$stmt = $this->pdo->prepare('UPDATE grupo SET cronograma = 0 where idgrupo = :pidgrupo');
				$stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
				$stmt->execute();
			
			parent::desconectar();
				
				if($this->insertEvento()){
					parent::desconectar();
					return true;
				}else{
					parent::desconectar();
					return false;
				}
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return false;
		}
	}
	
	public function insertEvento() 
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$stmt = $this->pdo->prepare('INSERT INTO evento(idGrupo, participantes, start, end, allday, nomeEvento, descricao, idcronograma, idTipoEvento, concluido)
			VALUES(:pidgrupo,:pparticipantes,:pstart,:pend,:pallday,:pnomeEvento,:pdescricao,:pidcronograma, :pidTipoEvento, :pisClonclusion)');
			$stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
			$stmt->bindValue(':pparticipantes', $this->participantes, PDO::PARAM_STR);
			$stmt->bindValue(':pstart', $this->start, PDO::PARAM_STR);
			$stmt->bindValue(':pend', $this->end, PDO::PARAM_STR); 
			$stmt->bindValue(':pallday', $this->allday, PDO::PARAM_BOOL);
			$stmt->bindValue(':pnomeEvento', $this->nomeEvento, PDO::PARAM_STR);
			$stmt->bindValue(':pdescricao', $this->descricao, PDO::PARAM_STR);
			$stmt->bindValue(':pidcronograma', $this->idCronograma, PDO::PARAM_INT);
			$stmt->bindValue(':pidTipoEvento', $this->idTipoEvento, PDO::PARAM_INT);
			$stmt->bindValue(':pisClonclusion', $this->isClonclusion, PDO::PARAM_BOOL);
			
			if($stmt->execute()){
				$this->msg = "O evento ".$this->nomeEvento." com entrega prevista para ".date('d-m-Y',strtotime($this->end))." foi adicionado, confira no cronograma!!!";
				$this->sendMsg();
				parent::desconectar();
				return true;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return false; 
		}
	}
	
	public function deleteCronograma()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
		
			$stmt = $this->pdo->prepare('DELETE FROM evento WHERE idEvento = :pidEvento');
			$stmt->bindValue(':pidEvento', $this->idEvento, PDO::PARAM_INT);
			
			if($stmt->execute()){
				parent::desconectar();
				return true;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function getCompleteEvents()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$id = $this->idGrupo;
			
			$stmt = $this->pdo->query("SELECT * FROM evento a INNER JOIN tipoEvento b ON a.idTipoEvento = b.id WHERE idGrupo = $id ORDER BY a.concluido DESC, a.start ASC");
			
			if(count($stmt)){
				parent::desconectar();
				return $stmt;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
		
	public function updateEvento()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
		
			$stmt = $this->pdo->prepare('UPDATE evento SET participantes = :pparticipantes, start = :pstart, end = :pend, allday = :pallday, nomeEvento = :pnomeEvento, descricao = :pdescricao, idTipoEvento = :pidTipoEvento, concluido = :pisClonclusion, idgrupo = :pidgrupo, idcronograma = :pidcronograma WHERE idEvento = :pidEvento');
			$stmt->bindValue(':pidEvento', $this->idEvento, PDO::PARAM_INT);
			$stmt->bindValue(':pparticipantes', $this->participantes, PDO::PARAM_STR);
			$stmt->bindValue(':pstart', $this->start, PDO::PARAM_STR);
			$stmt->bindValue(':pend', $this->end, PDO::PARAM_STR); 
			$stmt->bindValue(':pallday', $this->allday, PDO::PARAM_BOOL);
			$stmt->bindValue(':pnomeEvento', $this->nomeEvento, PDO::PARAM_STR);
			$stmt->bindValue(':pdescricao', $this->descricao, PDO::PARAM_STR);
			$stmt->bindValue(':pidTipoEvento', $this->idTipoEvento, PDO::PARAM_INT);
			$stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
			$stmt->bindValue(':pidcronograma', $this->idCronograma, PDO::PARAM_INT);
			$stmt->bindValue(':pisClonclusion', $this->isClonclusion, PDO::PARAM_BOOL);
			
			if($stmt->execute()){
				$this->msg = "O evento ".$this->nomeEvento." com entrega prevista para ".date('d-m-Y',strtotime($this->end))." foi atualizado, confira no cronograma!!!";
				$this->sendMsg();
				parent::desconectar();
				return true;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function getUserNames($id)
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$stmt = $this->pdo->query("SELECT uid, username FROM users WHERE uid = $id ORDER BY username ;");
			
			if(count($stmt)){
				parent::desconectar();
				return $stmt;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function getInfoTable()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$id = $this->idEvento;
			
			$stmt = $this->pdo->query("SELECT nomeEvento, descricao FROM evento WHERE idEvento = $id ;");
			
			if(count($stmt)){
				parent::desconectar();
				return $stmt;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function checkedCronograma()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
		
			$stmt = $this->pdo->prepare('UPDATE evento SET concluido = :pisClonclusion WHERE idEvento = :pidEvento');
			$stmt->bindValue(':pidEvento', $this->idEvento, PDO::PARAM_INT);
			$stmt->bindValue(':pisClonclusion', $this->isClonclusion, PDO::PARAM_BOOL);
			
			if($stmt->execute()){
				parent::desconectar();
				return true;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function getListName()
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$id = $this->idGrupo;
			
			$stmt = $this->pdo->query("SELECT b.username, c.titulo, a.tipo, c.descricao FROM grupo_has_users a INNER JOIN users b ON a.uid =  b.uid INNER JOIN grupo c ON c.idgrupo = a.idgrupo WHERE a.idgrupo = $id ORDER BY a.tipo;");
			
			if(count($stmt)){
				parent::desconectar();
				return $stmt;
			}else{
				parent::desconectar();
				return false;
			}
			
		}catch(PDOException $e){
			echo $e->getMessage();
			return false; 
		}
	}
	
	public function sendMsg() 
	{
		try{
			if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
			}
			
			$idgrupo = $this->idgrupo;
			$myid = $this->uid;
			$ok = true;
			
			$stmt = $this->pdo->query("SELECT * FROM grupo_has_users WHERE idgrupo = $idgrupo AND uid <> $myid");
			
			if(count($stmt)){
				foreach($stmt as $res){
					$stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de)
					VALUES(:pmsg, current_date(),0, :puid ,$myid)");
					$stmt2->bindValue(':pmsg', $this->msg, PDO::PARAM_STR);
					$id = (int)$res['uid'];
					$stmt2->bindValue(':puid', $id, PDO::PARAM_INT);
					
					if(!$stmt2->execute()){
						$ok = false;
						parent::desconectar();
						break;
					}
				}
			}else{
				parent::desconectar();
				return false;
			}
			
			if(!$ok){
				return false;
			}else{
				return true;
			}
		}catch ( PDOException $e ) {
			echo $e->getMessage ();
			return false; 
		}
	}
	
}
?>