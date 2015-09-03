<?php
$base = $_SERVER['SERVER_NAME'];
$idUser = isset($_POST['idUser']) ? $_POST['idUser'] : "";

require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$idgrupo = $pdo->select("SELECT g.idgrupo FROM grupo_has_users g WHERE g.uid = {$idUser}");

$result = $pdo->select("SELECT * FROM arquivos a WHERE a.idgrupo = {$idgrupo[0]['idgrupo']} ORDER BY a.dtaEnvio DESC");

if(count($result)){
    echo '<div class="panel panel-default">
            <div class="panel-heading">
                Meus PDF
            </div>
            <!-- /.panel-heading -->
           
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
                        <tbody>';

                        foreach($result as $res){
                             echo ' 
                                <tr>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['idArquivo'].'</td>
                                    <td><img src="img/pdf.png" width="40px"/></td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['nome'].'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                        <a href="'.$res['caminho'].'" target="blanck">
                                        <input type="button" class="btn btn-warning" value="Abrir PDF"/></a>
                                    </td>
                                </tr>';
                        }
                
                                    
    echo '              </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            
        </div>
        <!-- /.panel -->';
}else{
    echo ' <div class="alert alert-danger">'
                    . 'Você ainda não enviou arquivos no sistema...'
                . '</div>'; 
}

