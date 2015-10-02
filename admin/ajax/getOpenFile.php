<?php
$base = "http:". DIRECTORY_SEPARATOR ."". DIRECTORY_SEPARATOR ."localhost". DIRECTORY_SEPARATOR ."Plataforma-TCC". DIRECTORY_SEPARATOR ."admin"; //$_SERVER['SERVER_NAME'];
$file = isset($_POST['file']) ? $_POST['file'] : null;

require_once '../includes/Conexao.class.php';

$html = "<script type='text/javascript'>
            
            function closeWindow(i){
                var div = $(i).parents('div.readerPDF');
                $(div).fadeOut();
                return false;
            }
        </script>";

$html .= "<div class='container-fluid'>
            <div class='row'>
                <div class='col-xs-12 col-sm-12 col-md-12'>
                    <div class='panel panel-red'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>Leitura de Arquivo</h3>
                            <div style='position: relative;text-align: right;margin-top: -1%;'>
                                <i title='Fechar Janela' onclick='closeWindow($(this));' style='color: #0E0D0D; cursor: pointer;' class='fa fa-times-circle fa-2x'></i>
                            </div>
                        </div>
                        <div class='panel-body' style='background-color:#494949; padding:0px!important;'>";
            

if($file != null){
        $html .= "          <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12'>
                                    <div class='framePDF'>
                                        <iframe a_blank allowfullscreen webkitallowfullscreen width='100%' height='535' frameborder='0' src='$base". DIRECTORY_SEPARATOR ."ViewerJS". DIRECTORY_SEPARATOR ."#..$file'></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
}else{
    $html .= "              <span class='label label-important'>Sem arquivo para ser aberto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
}

echo $html;