<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');

 class Users extends Conexao{
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
	
    // aqui começa a criar os metodos (function)
	
	public function AddUser(){
			 		
		if(parent::getPDO() == null){
              //caso não tenha conecta-se com o banco de dados
               parent::conectar();
        }
		$foto = "fotoUser/padraoUser.jpg";
		$tipo = 0;
		//preparação para a query com os metodos pdo
		$stmt = $this->pdo->prepare('INSERT INTO users(username, password, email, prontuario, fotouser,tipo) VALUES (:pusername, :ppassword, :pemail, :pprontuario, :pfotouser,:ptipo)');
		$stmt->bindValue(':pusername', $this->nome, PDO::PARAM_STR);
		$stmt->bindValue(':ppassword', sha1(antiInjection($this->senha)), PDO::PARAM_STR);
		$stmt->bindValue(':pemail', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':pprontuario', $this->prontuario, PDO::PARAM_INT);
		$stmt->bindValue(':pfotouser', $foto, PDO::PARAM_STR);
		$stmt->bindValue(':ptipo', $tipo, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
 }
?>