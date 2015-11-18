<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');

class Autentica extends Conexao {

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

    public function Validar_Usuario() {
        $senha = $this->pass;
        $senha = sha1(antiInjection($senha));

        $pdo = new Conexao();
        $resultado = $pdo->select("SELECT uid, username, password, email, fotouser, descricao, prontuario, cargo, tipo "
                . "FROM users WHERE email = '" . $this->email . "' AND password = '$senha' ");

        if (count($resultado)) {
            foreach ($resultado as $res) {
                $_SESSION['id_login'] = $res['uid'];
                $_SESSION['user'] = $res['username'];
                $_SESSION['email_login'] = $res['email'];
                $_SESSION['pass_login'] = $res['password'];
                $_SESSION['fotouser'] = $res['fotouser'];
                $_SESSION['descricao'] = $res['descricao'];
                $_SESSION['cargo'] = $res['cargo'];
                $_SESSION['prontuario'] = $res['prontuario'];
                $_SESSION['tipo'] = $res['tipo'];
                $_SESSION['logado'] = 'S';
                
                $selec_grupo = $pdo->select("SELECT * FROM grupo_has_users a 
                WHERE a.uid =  {$res['uid']}
                ORDER BY a.idgrupo DESC
                LIMIT 1;");
                
                if(count($selec_grupo)){
                    $_SESSION['grupo_id'] = $selec_grupo[0]['idgrupo'];
                }
            }
            
            //Aqui usado para o chat
            $atual = date('Y-m-d H:i:s');
            $expira = date('Y-m-d H:i:s', strtotime('+1 min'));
            $arr['horario'] = $atual;
            $arr['limite'] = $expira;
            $myId = $_SESSION['id_login'];
            $update = $pdo->update($arr, "users", "uid=$myId");
            //Aqui usado para o chat

            $pdo->desconectar();
            return true;
        } else {
            return false;
        }
    }

}
?>