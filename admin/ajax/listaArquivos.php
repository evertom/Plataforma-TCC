<?php
$base = $_SERVER['SERVER_NAME'];
$idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";

require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT * FROM (
                            SELECT *, concat(a.versao_u, '.', a.versao_d, '.', a.versao_c) AS versao FROM arquivos a
                            INNER JOIN users b ON a.user_id = b.uid
                            WHERE a.idgrupo = $idgrupo
                            ORDER BY a.versao_u DESC, a.versao_d DESC, a.versao_c DESC
                        ) retorno
                        GROUP BY nome ORDER BY idArquivo ASC ;");
$pdo->desconectar();

if(count($result)){
    echo "<script type='text/javascript'>
                function openFile(button){
                    var file = $(button).attr('href');
                    $.ajax({
                        url: 'ajax/getOpenFile.php',
                        method: 'POST',
                        dataType: 'HTML',
                        data: {file: file},
                        success: function(data){
                            $('#modal').modal('hide');
                            $('.readerPDF > ').remove();
                            var retorno = $(data);
                            $('.readerPDF').html(retorno).fadeIn();
                        },
                        error: function(msg){
                            $('#modal').modal('hide');
                            $('.readerPDF > ').remove();
                            var retorno = $(msg);
                            $('.readerPDF').html(retorno).fadeIn();
                            console.log(msg);
                        }
                    });
                    return false;
                }
                
                function expandRow(button){
                    var tr = $(button).closest('tr');
                    var i = $(button).find('i');
                    if($(i).hasClass('fa-arrow-circle-up')){
                        $(i).removeClass('fa-arrow-circle-up');
                        $(i).addClass('fa-arrow-circle-down');
                        
                    }else{
                        $(i).addClass('fa-arrow-circle-up');
                        $(i).removeClass('fa-arrow-circle-down');
                    }
                    $(tr).next().toggle('slow');
                }
                
                function deleteFile(button){
                    var tr = $(button).closest('tr');
                    var id_file = $(tr).attr('value');
                    var href = 'ajax/deleteFile.php';
                    var post = {id_file: id_file};
                    
                    var message = 'Tem certeza que deseja excluir este arquivo?';
                        message += '<br>Sugerimos que você faça um bakcup, baixando o arquivo para sua máquina, pois o procedimento de exclusão de arquivos é definitivo.';            

                    showAlert('confirm',{
                        type: BootstrapDialog.TYPE_DANGER, 
                        title: 'COFIRMAÇÃO', 
                        message: message
                    },
                    {
                        method: 'POST', 
                        type: 'POST', 
                        url: href, 
                        data: post,
                        cache: false,
                        after_function: function(data, dialogRef){
                            if(data.ok === true){
                                dialogRef.getModalBody().html(data.msg);
                                dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                                $(tr).remove();
                            }else{
                                dialogRef.getModalBody().html(data.msg);
                            }
                        }
                    });
                    return false;
                }


          </script>";
    echo '<div style="margin: 10px;">';
    echo            '<table class="table table-responsive">
                        <thead>
                            <tr>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">#</th>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">Data</th>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">Tipo</th>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">Nome</th>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">Versão</th>
                                <th style="text-align:center;vertical-align: middle;display: table-cell;">Editor</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>';

                        foreach($result as $res){
                         
                            $sub_files = getSubFiles($res['nome'], $res['idArquivo']);
                            
                            $btn_arrow = ($sub_files != "") ? '<button onclick="expandRow($(this)); return false;" type="button" class="btn btn-small btn-info"><i class="fa fa-arrow-circle-down"></i></button>' : "";
                            
                            echo '<tr value="'.$res['idArquivo'].'">
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['idArquivo'].'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.date("d-m-Y H:i:s", strtotime($res['dtaEnvio'])).'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;"><i title="PDF" style="color:red;" class="fa fa-2x fa-file-pdf-o"></i></td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['nome'].'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['versao'].'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['username'].'</td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                        <button href="'.$res['caminho'].'" onclick="openFile($(this)); return false;" type="button" class="btn btn-warning">Abrir <i class="fa fa-eye"></i></button>
                                    </td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                        <button onclick="deleteFile($(this)); return false;" type="button" class="btn btn-danger">Excluir <i class="fa fa-trash-o"></i></button>
                                    </td>
                                    <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                        '.$btn_arrow.'
                                    </td>
                                  </tr>';
                            
                            echo $sub_files;
                        }
            echo ' </tbody>
                 </table>';
            echo '</div>';
}else{
    echo '<div style="margin: 10px;">';
    echo    '<table class="table table-responsive table-striped table-hover">
               <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Versao</th>
                        <th>Editor</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" style="text-align:center;vertical-align: middle;display: table-cell;">Nenhum upload de arquivos até este momento.</td>
                    </tr>
                </tbody>';
    echo '</div>';
}
?>
<?php 

    function getSubFiles($name_file, $arquivo_id){
        require_once '../includes/Conexao.class.php';
        $pdo = new Conexao();

        $resultado = $pdo->select("SELECT *, concat(a.versao_u, '.', a.versao_d, '.', a.versao_c) AS versao FROM arquivos a
                                    INNER JOIN users b ON a.user_id = b.uid
                                    WHERE a.nome = '$name_file' AND a.idArquivo <> $arquivo_id
                                    ORDER BY a.versao_u DESC, a.versao_d DESC, a.versao_c DESC;");
        $pdo->desconectar();
        
        $html = "";
        
        if(count($resultado)){
            $html .= '<tr style="display: none;">
                       <td colspan="9">
                        <table class="table table-responsive table-border">
                         <tbody>';
            
            foreach ($resultado as $res){
                $html.='<tr value="'.$res['idArquivo'].'">
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['idArquivo'].'</td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">'.date("d-m-Y H:i:s", strtotime($res['dtaEnvio'])).'</td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;"><i title="PDF" style="color:red;" class="fa fa-2x fa-file-pdf-o"></i></td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['nome'].'</td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['versao'].'</td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">'.$res['username'].'</td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                <button href="'.$res['caminho'].'" onclick="openFile($(this)); return false;" type="button" class="btn btn-warning">Abrir <i class="fa fa-eye"></i></button>
                            </td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">
                                <button onclick="deleteFile($(this)); return false;" type="button" class="btn btn-danger">Excluir <i class="fa fa-trash-o"></i></button>
                            </td>
                            <td style="text-align:center;vertical-align: middle;display: table-cell;">
                            </td>
                        </tr>';
            }
            
            $html .= ' </tbody>
                      </table>
                     </td>
                    </tr>';
        }
        
        return $html;
    }