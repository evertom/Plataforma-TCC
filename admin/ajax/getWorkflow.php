<?php
    
    require_once('../verifica-logado.php');
    require_once('../includes/Workflow.class.php');
    require_once('../includes/Mensagen.class.php');
    require_once '../includes/Upload.class.php';
    
    date_default_timezone_set("America/Sao_Paulo");
    
    $operation = isset($_POST['operation']) ? $_POST['operation']:"";
    $idGrupo = 	isset($_POST['idGrupo']) ? $_POST['idGrupo']:"";
    $idWorkflow = isset($_POST['idWorkflow']) ? $_POST['idWorkflow']:"";
    $file = isset($_FILES['file']['name']) ? $_FILES['file']['name']: null; 
    
    
    if($operation == "getWorkflow"){
        try {
            $Workflow = new Workflow(); 
            $Workflow->idGrupo = (int)$idGrupo;

            $result = $Workflow->getListName();

            $html = "";

            if(count($result)){
                $names = "";
                foreach($result as $res){
                    $titulo = $res['titulo'];
                    $descricao = $res['descricao'];
                    if($res['tipo'] == 1){
                        $names .= "<h4>Aluno: <small>";
                    }else if($res['tipo'] == 2){
                        $names .= "<h4>Orientador: <small>";
                    }else{
                        $names .= "<h4>Co-Orientador: <small>";
                    }
                    $names .= $res['username']."</small></h4>";
                }
            }

            $html .= "<div class='page-header'>
                        <h1>Workflow do TCC</h1>
                        <h3>$titulo <small>$descricao</small></h3>
                        $names
                    </div>";

            $resultado = $Workflow->getCompleteEvents();

            if($resultado){

                $html .= "<ul class='timeline'>";

                $index = 1;
                $desabled = "disabled";
                
                foreach($resultado as $res){

                    $arrayIdusers = explode("," , $res['participantes']);
                    $arrayIntegrantes = "";
                    
                    foreach($arrayIdusers as $id){
                        if($id == $id_users){
                            $desabled = "";
                        }

                        $integrantes = $Workflow->getUserNames($id);
                        if($id == $id_users){
                            $readOnly = "";
                        }
                        if(count($integrantes)){
                            foreach($integrantes as $pegaUsers){
                                $arrayIntegrantes .= $pegaUsers['username']." ; ";
                            }
                        }
                    }

                    $class = "";					

                    if(rand(1, 2) == 2){
                        $class = "class='timeline-inverted'";
                    }

                    $end = date('Y-m-d', strtotime($res['end']));

                    $situacao= "";
                    $dataConcluido= "";

                    if($res['concluido'] == 1 ){
                        $desabledC = "disabled";
                        $desabledN = "";
                        $situacao = "<div style='color: #26DC42;float: right!important;width: 25px;position: relative!important;right: 10px;'><i title='Evento já entregue.' class='fa fa-2x fa-check-circle'></i></div>";
                        $dataConcluido = "<small class='text-muted'><i class='glyphicon glyphicon-time'></i> Concluido ".date("d-m-Y H:i:s", strtotime($res['data_conclusao']))."</small>";
                        $color = "#26DC42";
                    }else if(strtotime($end) > strtotime(date('Y-m-d'))){
                        $situacao = "<div style='color: #FFDF12; float: right!important;width: 25px;position: relative!important;right: 10px;'><i title='Evento em andamento.' class='fa fa-2x fa-exclamation'></i></div>";
                        $color = "#FFDF12";
                        $desabledC = "";
                        $desabledN = "disabled";
                    }else{
                        $situacao = "<div style='color: #FF5274; float: right!important;width: 25px;position: relative!important;right: 10px;'><i title='Evento em atraso.' class='fa fa-2x fa-exclamation-triangle'></i></div>";
                        $color = "#FF5274";
                        $desabledC = "";
                        $desabledN = "disabled";
                    }

                    $html .= "<li $class>
                                <div class='timeline-badge' style='background-color: $color;'><i class='fa fa-flag'></i></div>
                                    <div class='timeline-panel'>
                                        <div class='timeline-heading'>
                                            <h4 class='timeline-title'>".$res['nomeEvento']."</h4>$situacao
                                                <p>
                                                    <small class='text-muted'><i class='glyphicon glyphicon-time'></i> Data ".date("d-m-Y", strtotime($res['start']))."</small>
                                                    <br/><small class='text-muted'><i class='glyphicon glyphicon-time'></i> Limite ".date("d-m-Y", strtotime($res['end']))."</small>
                                                    <br/>$dataConcluido
                                                </p>
                                        </div>
                                    <div class='timeline-body'>
                                        <hr></hr>
                                        <p><i class='fa fa-bookmark'></i> ".$res['descricao']."</p>
                                        <hr></hr>
                                        <p><i class='fa fa-users'></i> ".$arrayIntegrantes."</p>";
                                        if($index == 1){
                                            $html .= "<hr></hr>
                                            <div style='text-align: right;'>
                                                <button class='btn btn-danger' onclick='openFiles();'>arquivos <i class='fa fa-folder-open'></i></button>
                                                <button $desabled $desabledC  class='btn btn-success' onclick='openDone(".$res['idWorkflow'].");'>finalizar <i class='fa fa-check-circle'></i></button>
                                                <button $desabled $desabledN class='btn btn-primary' onclick='openNext();'>próxima <i class='fa fa-arrow-circle-right'></i></button>
                                            </div>";
                                        }
                          $html .= "</div>
                                </div>	
                        </li>";
                    $index++;
                }
            $html .= "</ul>";
            }else{
                $disebled = "";
                if($tipo_users != 1){
                    $disebled = "disabled='true'";
                }
                $html .= "<center><button onclick='openStartEvent();' $disebled class='btn btn-block btn-primary'>iniciar atividades</button></center>";
            }
            echo $html;
        }catch (PDOException $e){
            echo json_encode($e->getMessage());
        }
    }
    
    if($operation == "finalizar"){
        try{
            $Workflow = new Workflow(); 
            $Workflow->idWorkflow = (int)$idWorkflow;
            $Workflow->concluido = true;
            $result = $Workflow->checked();
            if($result != false){
                $resultado = $Workflow->getEventWorkflow();
                $Mensagem = new Mensagen();
                $Mensagem->uid = (int)$id_users;
                $Mensagem->idgrupo = (int)$idGrupo;
                $Mensagem->msg = "Concluída atividade '{$resultado[0]['nomeEvento']}' do Grupo '{$resultado[0]['titulo']}' em ".date("d-m-Y H:i:s").". Confira mais no menu workflow.";
                
                if($Mensagem->SendMsg()){
                    $res['ok'] = true;
                    $res['msg'] = $Mensagem->msg;
                    echo json_encode($res);
                }else{
                    $res['ok'] = true;
                    $res['msg'] = "Atualizado com successo, porém não foi possível enviar uma mensagem de evento concluído para os outros participantes. Confira mais no menu workflow.";
                    echo json_encode($res);
                }
            }else{
                $res['ok'] = false;
                $res['msg'] = "Ocorreu uma falha ao tentar finalizar esta tarefa.";
                echo json_encode($res);
            }
        }catch (PDOException $e){
            $res['ok'] = false;
            $res['msg'] = $e->getMessage();
            echo json_encode($res);
        }        
    }
    
    if($operation == "next"){
        try{
            $Workflow = new Workflow(); 
            $Workflow->idgrupo = (int)$idGrupo;
            $Workflow->end = isset($_POST['end'])? date("Y-m-d", strtotime($_POST['end'])) :"";
            $Workflow->nomeEvento = isset($_POST['nomeEvento'])? trim($_POST['nomeEvento']) :"";
            $Workflow->participantes = isset($_POST['participantes'])? trim($_POST['participantes']) :"";
            $Workflow->descricao = isset($_POST['descricao'])? trim($_POST['descricao']) :"";
                
            if($Workflow->insertNextStage()){
                $arquivo = "";
                if($idGrupo != null && $file != null){ 
                    $Upload = new Upload();
                    $Upload->idgrupo = $idGrupo;
                    $Upload->nome = $file;
                    $Upload->user_id = (int) $id_users;
                    $Upload->versao = isset($_POST['versao'])? $_POST['versao']: "centena";
                    if($Upload->VerifyExtension()){
                       //caminho temporário do arquivo /* 
                       $Upload->tmp = $_FILES['file']['tmp_name']; 
                        if($Upload->SetUpload()){
                            $arquivo = "Realizado updload de arquivo '$file' .";
                        }else{
                            $arquivo = "Erro ao tentar subir arquivo '$file' .";
                        }
                    }else{
                        $arquivo = "Erro ao tentar subir arquivo '$file'. Devido sua extensão.";
                    }
                }else{
                    $arquivo = "Sem upload de arquivos.";
                }
                
                $resultado = $Workflow->getEventWorkflow();
                $Mensagem = new Mensagen();
                $Mensagem->uid = (int)$id_users;
                $Mensagem->idgrupo = (int)$idGrupo;
                $Mensagem->msg = "Próxima atividade '{$resultado[0]['nomeEvento']}' do Grupo '{$resultado[0]['titulo']}' foi adicionada em ".date("d-m-Y H:i:s").".$arquivo Confira mais no menu workflow.";
                
                if($Mensagem->SendMsg()){
                    $res['ok'] = true;
                    $res['msg'] = $Mensagem->msg;
                    echo json_encode($res);
                }else{
                    $res['ok'] = true;
                    $res['msg'] = "Inserido com successo, porém não foi possível enviar uma mensagem de evento adicionado para os outros participantes.";
                    echo json_encode($res);
                }
            }else{
                $res['ok'] = false;
                $res['msg'] = "Ocorreu uma falha ao tentar adicionar nova tarefa.";
                echo json_encode($res);
            }
        }catch (PDOException $e){
            $res['ok'] = false;
            $res['msg'] = $e->getMessage();
            echo json_encode($res);
        }        
    }
    
?>