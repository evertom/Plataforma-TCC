<?php

/* Chat em ajax X-Chat
   Autor do Chat: Hedi Carlos Minin
   http://www.xlinkweb.com.br

  chat x-chat em ajax vers�o xq 1.0
  Demonstra��o e download em: 
  
 */

//classe para conex�o com o banco de dados
//Hedi Carlos Minin
class Mysql{
	//em php 5 utiliza-se private ao inv�s de var
	var $servidor = 'localhost';
	var $banco = 'tcc';
	var $usuario = 'root';
	var $senha = '';
	
	var $conexao;
	var $consulta;
	var $resultado;
	var $total_registros = 0;
	//metodo construtor
	function Mysql(){
    }
	//conectar no banco de dados
	function Conecta(){
		$this->conexao = @mysql_connect($this->servidor,$this->usuario,$this->senha); //varaivel link desntro desta classa recebera a conex�o
		if(!$this->conexao){
			echo 'Falha na conex�o com o banco de dados<br>';
			exit();
		}elseif(!mysql_select_db($this->banco,$this->conexao)){
			echo 'Falha ao selecionar o banco de dados<br>';
			exit();
		}
	}
	//realizar consulta sql
	function Consulta($query){
		$this->Conecta();
		$this->consulta = $query;
		if($this->resultado = @mysql_query($this->consulta)){
			$this->Desconecta();
			return $this->resultado;
		}else{
			$this->Desconecta();
			echo 'Erro ao realizar consulta';
			exit();
		}
	
	}
	//total de registros
	function Totalreg($query){
		$this->total_registros = $this->Consulta($query);
		$this->total_registros = mysql_fetch_array($this->total_registros);
		return $this->total_registros[0];
	}
	//fechar a conex�o
	function Desconecta(){
		return mysql_close($this->conexao);
	}
}
?>