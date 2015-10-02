<?php 
require_once '../verifica-logado.php';
require_once '../includes/Upload.class.php';

$idArquivo = isset($_POST['id_file'])? $_POST['id_file']: null;
    
if($idArquivo != null){ 
    
    $Upload = new Upload();
    $Upload->user_id = (int)$id_users;
    $Upload->idArquivo = (int)$idArquivo;
    
    if($Upload->VerifyPermisionUser()){
        
        if($Upload->DeleteFile()){
            $res['ok'] = true;
            $res['msg'] = "O arquivo foi deletado com sucesso.";
            echo json_encode($res);
        }else{ 
            $res['ok'] = false;
            $res['msg'] = "Não foi possível excluir o arquivo, houve um erro de execução no sistema.";
            echo json_encode($res);
        }
    }else{ 
        $res['ok'] = false;
        $res['msg'] = "Somente aquele quem fez o upload do arquivo pode realizar sua exclusão. Você pode conferir pelo campo Editor da tabela.";
        echo json_encode($res);
    }
}else{ 
    $res['ok'] = false;
    $res['msg'] = "É preciso escolher apenas um arquivo para ser excluído.";
    echo json_encode($res);
}
?>