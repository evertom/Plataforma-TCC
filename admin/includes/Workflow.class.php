<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');

class Workflow extends Conexao {
    private $data = array();
    public function __construct() {
        $this->erro = '';
    }
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'], E_USER_NOTICE);
        return null;
    }

    public function getCompleteEvents() {
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            $id = $this->idGrupo;
            $stmt = $this->select("SELECT * FROM workflow a WHERE a.idGrupo = $id ORDER BY a.idWorkflow DESC ;");

            if (count($stmt)) {
                parent::desconectar();
                return $stmt;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    
    public function getUserNames($id) {
        try {
             if (parent::getPDO() == null) {parent::conectar();}

            $stmt = $this->pdo->query("SELECT uid, username FROM users WHERE uid = $id ORDER BY username ;");

            if (count($stmt)) {
                parent::desconectar();
                return $stmt;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function checked(){
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            
            if($this->concluido == true){
                $stmt = $this->pdo->prepare('UPDATE workflow SET concluido = :pconcluido, data_conclusao = now() WHERE idWorkflow = :pidWorkflow');
            }
            
            $stmt->bindValue(':pidWorkflow', $this->idWorkflow, PDO::PARAM_INT);
            $stmt->bindValue(':pconcluido', $this->concluido, PDO::PARAM_BOOL);

            if ($stmt->execute()) {
                parent::desconectar();
                return true;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getListName(){
        try {
             if (parent::getPDO() == null) {parent::conectar();}

            $id = $this->idGrupo;
            $stmt = $this->pdo->query("SELECT b.username, c.titulo, a.tipo, c.descricao FROM grupo_has_users a INNER JOIN users b ON a.uid =  b.uid INNER JOIN grupo c ON c.idgrupo = a.idgrupo WHERE a.idgrupo = $id ORDER BY a.tipo;");

            if (count($stmt)) {
                parent::desconectar();
                return $stmt;
            } else {
                parent::desconectar();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getEventWorkflow(){
        try {
            if (parent::getPDO() == null) {parent::conectar();}
            $stmt = $this->select("SELECT * FROM workflow a INNER JOIN grupo b ON a.idGrupo = b.idgrupo WHERE a.idWorkflow = {$this->idWorkflow} LIMIT 1 ;");

            if(count($stmt)){
                parent::desconectar();
                return $stmt;
            }else{
                parent::desconectar();
                return false;
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function insertNextStage(){
        try {
            if(parent::getPDO() == null){parent::conectar();}
            
            $stmt = $this->pdo->prepare("INSERT INTO workflow(idGrupo,participantes, end, nomeEvento, descricao)
                                          VALUES(:pidgrupo,:pparticipantes,:pend,:pnomeEvento,:pdescricao) ;");
            $stmt->bindValue(':pidgrupo', $this->idgrupo, PDO::PARAM_INT);
            $stmt->bindValue(':pparticipantes', $this->participantes, PDO::PARAM_STR);
            $stmt->bindValue(':pend', $this->end, PDO::PARAM_STR);
            $stmt->bindValue(':pnomeEvento', $this->nomeEvento, PDO::PARAM_STR);
            $stmt->bindValue(':pdescricao', $this->descricao, PDO::PARAM_STR);

            if ($stmt->execute()){
                $this->idWorkflow = (int) $this->pdo->lastInsertId();
                parent::desconectar();
                return true;
            }else{
                parent::desconectar();
                return false;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}
?>