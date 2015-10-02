<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');

class Mensagen extends Conexao{
    
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
    
    public function SendMsg() {
        try {
            if(parent::getPDO() == null) {parent::conectar();}

            $this->ok = true;
            $stmt = $this->pdo->query("SELECT * FROM grupo_has_users WHERE idgrupo = {$this->idgrupo} AND uid <> {$this->uid}");
            
            if (count($stmt)) {
                foreach ($stmt as $res) {
                    $stmt2 = $this->pdo->prepare("INSERT INTO avisos(descricao, data, visto, uid, de) VALUES(:pmsg, current_date(),0, :pid ,:puid)");
                    $stmt2->bindValue(':puid', $this->uid, PDO::PARAM_INT);
                    $stmt2->bindValue(':pmsg', $this->msg, PDO::PARAM_STR);
                    $this->id = (int)$res['uid'];
                    $stmt2->bindValue(':pid', $this->id, PDO::PARAM_INT);

                    if (!$stmt2->execute()){
                        $this->ok = false;
                        parent::desconectar();
                        break;
                    }
                }
            }else{
                parent::desconectar();
                return false;
            }

            if (!$this->ok) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
?>