<?php 
require_once '../verifica-logado.php';
require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$idGrupo = $pdo->select("SELECT g.idgrupo,gr.titulo FROM grupo_has_users g INNER JOIN grupo gr ON gr.idgrupo = g.idgrupo WHERE g.uid = {$id_users}");
$idprof = $pdo->select("SELECT g.uid FROM grupo_has_users g WHERE g.idgrupo = {$idGrupo[0]['idgrupo']} AND g.tipo = 2 ");
        
$pasta = "../GerenciamentoGrupos/{$idGrupo[0]['idgrupo']}/"; 
$pastaBD = "/GerenciamentoGrupos/{$idGrupo[0]['idgrupo']}/"; 
/* formatos permitidos */
$permitidos = array(".pdf"); 
if(isset($_POST)){ 
    $nome_imagem = isset($_FILES['file']['name']) ? $_FILES['file']['name']:""; 
   
    /* pega a extensão do arquivo */ 
    $ext = strtolower(strrchr($nome_imagem,".")); 
    /* verifica se a extensão está entre as extensões permitidas */ 
    if(in_array($ext,$permitidos)){ 
 
        $nome_atual = $idGrupo[0]['idgrupo']."_".md5(uniqid(time())).$ext; 
        //nome que dará ao arquivo 
        $tmp = $_FILES['file']['tmp_name']; 
        //caminho temporário do arquivo /* 

        if(move_uploaded_file($tmp,$pasta.$nome_atual)){
            $dados['idgrupo'] = $idGrupo[0]['idgrupo'];
            $dados['caminho'] = $pastaBD.$nome_atual;
            $dados['nome'] = $nome_atual;
            $dados['dtaEnvio'] = date('Y-m-d H:i:s');
            $tabela = "arquivos";
            
            $result = $pdo->insert($dados,$tabela);
             
            $tabela = "avisos";
            $dadosA['descricao'] = "O Grupo: ".$idGrupo[0]['titulo'].", enviou sua monografia para avaliação da etapa concluida, confira...";
            $dadosA['data'] = date('Y-m-d');
            $dadosA['visto'] = 0;
            $dadosA['uid'] = $idprof[0]['uid'];
            $dadosA['de'] = $id_users;
           
            $resultA = $pdo->insert($dadosA,$tabela);

            echo '<div class="panel panel-default">
                    <div class="panel-heading">
                        Envio de Arquivo PDF
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Nome do Arquivo</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;vertical-align: middle;display: table-cell;">1</td>
                                        <td><img src="img/pdf.png" width="50px"/></td>
                                        <td style="text-align:center;vertical-align: middle;display: table-cell;">'. $nome_atual.'</td>
                                        <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                            <a href="admin/'.$pasta.$nome_atual.'" target="blanck">
                                            <input type="button" class="btn btn-warning" value="Abrir PDF"/></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->';
            //imprime a foto na tela 
        }else{ 
            echo ' <div class="alert alert-danger">'
                . 'Falha ao criar <b>PDF</b>...'
            . '</div>';
        } 
    }else{ 
        echo ' <div class="alert alert-danger">'
                . 'Somente são aceitos arquivos do tipo <b>PDF</b>...'
            . '</div>';
    }
}else{ 
     echo ' <div class="alert alert-danger">'
                    . 'Escolha um arquivo para enviar...'
                . '</div>'; 
    exit; 
} 