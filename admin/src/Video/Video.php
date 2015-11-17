<?php
namespace Video;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\ConnectionInterface;

class Video implements WampServerInterface {
    
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();
    protected $controlerSession = array();

    public function onSubscribe(ConnectionInterface $conn, $topic) {
        try{
            //Inserindo novos topicos.
            $exist = array_search($topic, $this->subscribedTopics, TRUE);
            if($exist === false){
                array_push($this->subscribedTopics, $topic);
                sort($this->subscribedTopics);
                printf("NOVO TOPICO CRIADO: %s " . "\n", $topic->__toString());
            }
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    public function onUnSubscribe(ConnectionInterface $conn, $topic){
        try{
            //Retirando do controle de topico.
            $key = array_search($topic,$this->subscribedTopics, TRUE);
            if($key !== false){
                unset($this->subscribedTopics[$key]);
                printf("TOPICO RETIRADO: %s" . "\n", $topic->__toString());
            }
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible){
        try{
            $dados = json_decode($event);
            if($dados !== null){
                switch($topic->__toString()){
                    case "online":
                        $this->publishOnline($topic, $dados, $conn);
                    break;
                    case "conectar":
                        $this->publishConectar($topic, $dados, $conn);
                    break;
                    case "changeStatus":
                        $this->publishChangeStatus($topic, $dados, $conn);
                    break;
                }
            }
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params){
        try{
            $data = json_decode($params[0]);
            if($topic->__toString() == "sendIceCandidate"){
                $this->sendIceCandidate($topic, $data);
            }else{
                if(isset($data->read)){
                    if($data->read == false){
                        $this->sendMessage($topic, $data);
                    }else{
                        $this->sendReadMessage($topic, $data);
                    }
                }else{
                    if(isset($data->estabelishConection)){
                        $this->estabelishConectionToCall($topic, $data);
                    }else{
                        if($data->message != "recebendo"){
                            $this->sendResponseToCall($topic, $data);
                        }
                    }
                }
            }
            
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO CALL: %s " . "\n", $e->getMessage());
        }
    }

    public function onOpen(ConnectionInterface $conn){
        try{
            printf("CONEXAO ABERTA #ID %d"."\n", $conn->resourceId);
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    public function onClose(ConnectionInterface $conn){
        try{
            $this->publishDesconectar($conn);
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e){
        printf("Erro ao estabelecer conexao: %s", $e->getMessage());
    }
   
    private function sendReadMessage($topic, $data){
        $exclude = array();
        foreach($this->controlerSession as $session){
            if($data->sessionId_to != $session['sessionId']){
                array_push($exclude, $session['conn']->WAMP->sessionId);
            }
        }
        $topic->broadcast(json_encode($data), $exclude);
    }
    
    private function sendIceCandidate($topic, $data){
        $exclude = array();
        /*
        foreach($this->controlerSession as $session){
            if($data->sessionId != $session['sessionId']){
                array_push($exclude, $session['conn']->WAMP->sessionId);
            }
        }*/
        $topic->broadcast(json_encode($data), $exclude);
    }
    
    private function sendMessage($topic, $data){
        $exclude = array();
        foreach($this->controlerSession as $session){
            if($data->sessionId_to != $session['sessionId']){
                array_push($exclude, $session['conn']->WAMP->sessionId);
            }
        }
        $topic->broadcast(json_encode($data), $exclude);
    }
    
    private function sendResponseToCall($topic, $data){
        $exclude = array();
        foreach($this->controlerSession as $session){
            if($data->sessionId_to != $session['sessionId']){
                array_push($exclude, $session['conn']->WAMP->sessionId);
            }
        }
        $topic->broadcast(json_encode($data), $exclude);
    }
    
    
    private function estabelishConectionToCall($topic, $data){
        $exclude = array();
        foreach($this->controlerSession as $session){
            if($data->sessionId_to != $session['sessionId'] && $data->sessionId_from != $session['sessionId']){
                array_push($exclude, $session['conn']->WAMP->sessionId);
            }
        }
        $topic->broadcast(json_encode($data), $exclude);
    }

    private function publishOnline($topic, $dados, $conn){
        try{
            $aux = array($this->controlerSession);
            $topic->broadcast(json_encode($aux));
        }catch(Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    private function publishConectar($topic, $dados, $conn){
        try{
            
            $repet = false;
            foreach($this->controlerSession as $key => $value){
                if($value['userId'] == $dados->conectar->userId){
                    $oldSessionId = $value['sessionId'];
                    $repet = true;
                    break;
                }
            }
            
            array_push($this->controlerSession, 
                array(
                    'sessionId' => $conn->resourceId, 
                    'userId' => $dados->conectar->userId,
                    'status' => $dados->conectar->status,
                    'conn' => $conn
                )
            );
            sort($this->controlerSession);
            $aux = array(
                'sessionId' => $conn->resourceId, 
                'userId' => $dados->conectar->userId,
                'status' => $dados->conectar->status
            );
            
            $topic->broadcast(json_encode($aux));
            
            if($repet){
                $this->publishOnError($conn, $oldSessionId, $dados->conectar->userId);
            }
            
            
        }catch(Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    private function publishChangeStatus($topic, $dados, $conn){
        try{    
            foreach($this->controlerSession as $key => $value){
                if($value['sessionId'] == $conn->resourceId){
                    $this->controlerSession[$key]['status'] = $dados->status->status;
                    printf("CONEXAO #ID %d MUDOU PARA STATUS: %s " . "\n", $conn->resourceId, $dados->status->status);
                    break;
                }
            }
            $aux = array(
                'sessionId' => $conn->resourceId,
                'userId' => $dados->status->userId,
                'status' => $dados->status->status
            );
            $topic->broadcast(json_encode($aux));
        }catch(Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    private function publishDesconectar($conn){
        try{
            foreach($this->controlerSession as $key => $value ){
                if($conn->resourceId == $value['sessionId']){
                    $userId = $value['userId'];
                    unset($this->controlerSession[$key]);
                    break;
                }
            }
            sort($this->controlerSession);
            $aux = array(
                "desconectar" =>
                    array(
                        'sessionId' => $conn->resourceId, 
                        'userId' => $userId,
                        "status" => "offline",
                    )
            );
            foreach($this->subscribedTopics as $topic){
                if ($topic->__toString() === "desconectar"){
                    $topic->broadcast(json_encode($aux));
                    printf("FECHADA CONEXAO #ID %d" . "\n", $conn->resourceId);
                    break;
                }
            }
        }catch(\Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
    private function publishOnError($conn, $oldSessionId, $userId){
        try{
            $aux = array(
                "onError" =>
                    array(
                        'sessionId' => $conn->resourceId, 
                        'oldSessionId' => $oldSessionId,
                        'userId' => $userId,
                        "status" => "online",
                    )
            );
            foreach($this->subscribedTopics as $topic){
                if ($topic->__toString() === "onError"){
                    $topic->broadcast(json_encode($aux));
                    printf("ON ERROR -> CONEXAO #ID %d" . "\n", $oldSessionId);
                    printf("NOVA CONEXAO #ID %d PARA ACERTO DO ON ERROR" . "\n", $conn->resourceId);
                    break;
                }
            }
        }catch(Ratchet\Wamp\Exception $e){
            printf("ERRO: %s " . "\n", $e->getMessage());
        }
    }
    
}