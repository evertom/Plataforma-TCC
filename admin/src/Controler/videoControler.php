<?php
/* 
 * Este é o Controler do chat, ele é responsavel pelos update e selects no banco de dados
 * 
 */
require_once("../../includes/Conexao.class.php");

/**
 * varibel que traz o id do usuario no bando de dados
 */
$userId = isset($_POST['userId'])? $_POST['userId'] : null;

/**
 * varibel que traz o id do usuario no bando de dados
 */
session_start();
$grupoId = isset($_SESSION['grupo_id']) ? $_SESSION['grupo_id'] : $_SESSION['grupo_id'] ;

/**
 *variavel que indica ao switch o processo que deva ser realizado no banco de dados; 
 */
$process = isset($_POST['process'])? $_POST['process'] : null;



switch($process){
    
    case "selectUsers": 
        $pdo = new Conexao();
        //Aqui lista todos os integrantes do chat, neste caso todos cadastrados, pode ser feito regras de amizades aqui
        //Por exemplo so carrega os amigos de tal usuario atráves do $idUser;
        $retorno = $pdo->select("SELECT * FROM grupo_has_users a
                                   INNER JOIN users b ON a.uid = b.uid
                                   WHERE a.idgrupo =  {$grupoId}
                                   ORDER BY b.nick");
        
        $dados = array();
        if(count($retorno)){
            foreach($retorno as $res){
                //Aqui retorna a quantidade de mensagens ainda não lida para o usuário
                $msgNotRead = $pdo->select("SELECT COUNT(*) AS msgNotRead FROM mensagens a 
                                            WHERE a._read = false AND  a._from = {$res['uid']} 
                                            AND a._to = {$userId} ;");
                array_push($dados, array(
                   "userId" => $res['uid'],
                   "nome" => $res['username'],
                   "nick" => ($res['nick'] != null) ? $res['nick'] : "",
                   "msgNotRead" => $msgNotRead[0]['msgNotRead']
                ));
            }
            $pdo->desconectar();
            echo json_encode($dados);
        }else{
            $pdo->desconectar();
            echo json_encode(array());
        }
    break;
    
    case "getMessages": 
        $pdo = new Conexao();
        
        $from = isset($_POST['from'])?$_POST['from']:null;
        $qtdMessage = isset($_POST['qtdMessages'])?$_POST['qtdMessages']:null;
        
        //Aqui lista-se as ultimas mensagens recebidas
        $retorno = $pdo->select("SELECT * FROM mensagens a 
                                WHERE ( a._from = {$from} AND a._to = {$userId} )
                                OR ( a._from = {$userId} AND a._to = {$from} )
                                ORDER BY a.idMensagens DESC LIMIT {$qtdMessage};");
        $pdo->desconectar();
        $dados = array();
        if(count($retorno)){
            foreach($retorno as $res){
                array_push($dados, array(
                   "from" => $res['_from'],
                   "data" => date("d-m-Y H:i", strtotime($res['data'])),
                   "message" => $res['msg'],
                   "read" => (bool)$res['_read'],
                ));
            }
            $reverse = array_reverse($dados);
            echo json_encode($reverse);
        }else{
            echo json_encode(array());
        }
    break;
    
    case "saveMessage": 
        $pdo = new Conexao();
        
        $from = isset($_POST['from'])? $_POST['from']:null;
        $to = isset($_POST['to'])?  $_POST['to']:null;
        $message = isset($_POST['message'])? $_POST['message'] :null;
        
        $arr = array(
                "_from" => $from,
                "_to"   => $to,
                "msg"   => $message
        );
        
        $set = $pdo->insert($arr, "mensagens");
        $pdo->desconectar();
        
        if($set){
            $ret['ok'] = true;
            echo json_encode($ret);
        }else{
            $ret['ok'] = false;
            echo json_encode($ret);
        }
    break;
    
    case "setReadMessage": 
        $pdo = new Conexao();
        
        $from = isset($_POST['from'])? $_POST['from']:null;
        $to = isset($_POST['to'])?  $_POST['to']:null;
        
        $arr['_read'] = true;
        
        $where = "( _from = {$from} AND _to = {$to} );";
        $set = $pdo->update($arr,"mensagens",$where);
        $pdo->desconectar();
        
        if($set){
            $ret['ok'] = true;
            echo json_encode($ret);
        }else{
            $ret['ok'] = false;
            $ret['where'] = $where;
            echo json_encode($ret);
        }
    break;
 }