<?php
require_once('Conexao.class.php');
date_default_timezone_set("America/Sao_Paulo");

class Upload extends Conexao {
    
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

    public function VerifyExtension(){
        try{
            /* formatos permitidos */
            $this->permitidos = array(".pdf"); 
            /* pega a extensão do arquivo */ 
            $this->ext = strtolower(strrchr($this->nome,".")); 

            /* verifica se a extensão está entre as extensões permitidas */ 
            if(in_array($this->ext,$this->permitidos)){ 
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function DeleteFile(){
        try{
            if(parent::getPDO() == null){ parent::conectar();}
            $resultado = $this->select("SELECT * FROM arquivos a WHERE a.idArquivo = {$this->idArquivo} LIMIT 1 ;");
            parent::desconectar();
            
            if(count($resultado)){
                $this->pasta = "../{$resultado[0]['caminho']}";
                if(unlink($this->pasta)){
                    $this->tabela = "arquivos";
                    $stmt = $this->delete($this->tabela, "idArquivo={$this->idArquivo}");
                    if($stmt > 0){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                parent::desconectar();
                return false;
            }
        }catch(Exception $e){
            $e->getMessage();
            parent::desconectar();
            return false;
        }
    }
    
    public function SetUpload(){
        try{
            $this->pasta = "../GerenciamentoGrupos/{$this->idgrupo}/"; 
            $this->pastaBD = "/GerenciamentoGrupos/{$this->idgrupo}/"; 

            //nome que dará ao arquivo 
            $this->nome_mdr = md5(uniqid(time())).$this->ext; 

            if(move_uploaded_file($this->tmp,$this->pasta.$this->nome_mdr)){
                $this->tabela = "arquivos";
                
                $dados = $this->Versionamento();
                $dados['idgrupo'] = $this->idgrupo;
                $dados['user_id'] = $this->user_id;
                $dados['caminho'] = $this->pastaBD.$this->nome_mdr;
                $dados['nome'] = $this->nome;
                $dados['dtaEnvio'] = date('Y-m-d H:i:s');
                
                if($this->insert($dados,$this->tabela)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function Versionamento(){
        try {
            if(parent::getPDO() == null){ parent::conectar();}
            
            $resultado = $this->select("SELECT * FROM arquivos a WHERE a.nome = '{$this->nome}' ORDER BY a.versao_u DESC, a.versao_d DESC, a.versao_c DESC LIMIT 1 ;");
            parent::desconectar();
            
            if(count($resultado)){
                if($this->versao == "centena"){
                    $dados['versao_c'] = $resultado[0]['versao_c'] + 1;
                    $dados['versao_d'] = $resultado[0]['versao_d'];
                    $dados['versao_u'] = $resultado[0]['versao_u'];
                }else if($this->versao == "dezena"){
                    $dados['versao_d'] = $resultado[0]['versao_d'] + 1;
                    $dados['versao_c'] = $resultado[0]['versao_c'];
                    $dados['versao_u'] = $resultado[0]['versao_u'];
                }else if($this->versao == "unidade"){
                    $dados['versao_u'] = $resultado[0]['versao_u'] + 1;
                    $dados['versao_d'] = $resultado[0]['versao_d'];
                    $dados['versao_c'] = $resultado[0]['versao_c'];
                }else{
                    return false;
                }
            }else{
                if($this->versao == "centena"){
                    $dados['versao_c'] = 1;
                    $dados['versao_d'] = 0;
                    $dados['versao_u'] = 0;
                }else if($this->versao == "dezena"){
                    $dados['versao_d'] = 1;
                    $dados['versao_c'] = 0;
                    $dados['versao_u'] = 0;
                }else if($this->versao == "unidade"){
                    $dados['versao_u'] = 1;
                    $dados['versao_c'] = 0;
                    $dados['versao_d'] = 0;
                }else{
                    return false;
                }
            }
            return $dados;
        }catch(Exception $e){
            $e->getMessage();
            parent::desconectar();
            return false;
        }
    }
    
    
    public function VerifyPermisionUser(){
        try {
            if(parent::getPDO() == null){ parent::conectar();}
            $resultado = $this->select("SELECT * FROM arquivos a WHERE a.idArquivo = {$this->idArquivo} LIMIT 1 ;");
            parent::desconectar();
            
            if(count($resultado)){
                if($resultado[0]['user_id'] == $this->user_id){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch(Exception $e){
            $e->getMessage();
            parent::desconectar();
            return false;
        }
        
    }
}
?>
