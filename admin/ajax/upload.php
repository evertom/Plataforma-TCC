<?php 
require_once '../verifica-logado.php';
require_once '../includes/Upload.class.php';
require_once '../includes/Mensagen.class.php';

$idGrupo = isset($_POST['idgrupo'])? $_POST['idgrupo']: null;
$nome_file = isset($_FILES['file']['name']) ? $_FILES['file']['name']: null; 
$msg = isset($_POST['msg'])? $_POST['msg']: null;
$versao = isset($_POST['versao'])? $_POST['versao']: "centena";
    
if($idGrupo != null && $nome_file != null){ 
    
    $Upload = new Upload();
    
    $Upload->idgrupo = (int) $idGrupo;
    $Upload->nome = $nome_file;
    $Upload->user_id = (int)$id_users;
    $Upload->versao = $versao;
    
    if($Upload->VerifyExtension()){
        
       //caminho temporário do arquivo /* 
       $Upload->tmp = $_FILES['file']['tmp_name']; 
        
        if($Upload->SetUpload()){
            if($msg != null){
                $Mensagem = new Mensagen();
                $Mensagem->msg = $msg;
                $Mensagem->uid = (int)$id_users;
                $Mensagem->idgrupo = (int)$idGrupo;
                $Mensagem->SendMsg();
            }
            
            $res['ok'] = true;
            $res['msg'] = "Upload do arquivo {$Upload->nome} feito com sucesso.";
            echo json_encode($res);
        }else{ 
            $res['ok'] = false;
            $res['msg'] = "Falha ao criar PDF.";
            echo json_encode($res);
        }
    }else{ 
        $res['ok'] = false;
        $res['msg'] = "Somente são aceitos arquivos do tipo 'PDF'...";
        echo json_encode($res);
    }
}else{ 
    $res['ok'] = false;
    $res['msg'] = "'Escolha um arquivo para enviar...";
    echo json_encode($res);
}
?>