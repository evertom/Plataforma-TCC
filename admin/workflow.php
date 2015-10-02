<?php
require_once('verifica-logado.php');
require_once('includes/Conexao.class.php');
date_default_timezone_set("America/Sao_Paulo");
$pdo = new Conexao();
$result = $pdo->select("SELECT idgrupo FROM grupo_has_users WHERE uid = $id_users ORDER BY idgrupo desc;");

if (count($result)) {
    foreach ($result as $res) {
        $idgrupo = $res['idgrupo'];
        $array_grupos = array('id' => $idgrupo);
    }
} else {
    echo "<script type='text/javascript'>location.href='panel.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>

        <title>Admin</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- TimeLine Core CSS -->
        <link href="css/timeline.css" rel="stylesheet"/>

        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

        <!-- Jquery -->
        <script src="js/jquery-2.1.3.js"></script>

        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <script src="fullcalendar-2.3.1/lib/moment.min.js"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>

        <!-- select bootstrap -->
        <link href="js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-select/js/bootstrap-select.min.js"></script>

        <!-- bootstrap-switch-master -->
        <link href="js/bootstrap-switch-master/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-switch-master/js/bootstrap-switch.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>      
        
        <script>
            $(document).ready(function () {
                var IDGRUPO = $("#idgrupo").val();

                Load(IDGRUPO);

                $('#select-idgrupo').on('change', function () {
                    var id = $(this).val();
                    if (id !== null) {
                        var idO;
                        for (var i = 0; i < id.length; i++) {
                            idO = id[i];
                        }
                        IDGRUPO = idO;
                        $("#idgrupo").val(IDGRUPO);
                        Load(IDGRUPO);
                    } else {
                        IDGRUPO = "";
                        $("#idgrupo").val(IDGRUPO);
                        $("#workflow").fadeOut(250);
                    }
                });
            });

            function Load(id) {
                $.ajax
                ({
                    type: "POST", //metodo POST
                    dataType: 'html',
                    url: "ajax/getWorkflow.php",
                    data: {idGrupo: id, operation: "getWorkflow"},
                    success: function (data)
                    {
                        $("#workflow").html(data).fadeIn(100);
                    }
                });
            }
            
            function openStartEvent(){
                var href = "modelos/startWorkflow.php";
                var post = {idgrupo: $("#idgrupo").val()};
                $('.modal-dialog').css({width:'590px'});
                getAjaxPage(href, post);
                $('.modal-title').text("Primeiro fluxo de trabalho");
            }
            
            function openFiles(){
                var href =  "ajax/listaArquivos.php";
                var post = {idgrupo: $("#idgrupo").val()};
                $('.modal-dialog').css({width: '60%'});
                getAjaxPage(href, post);
                $('.modal-title').text("Lista de arquivos já upados pelo grupo.");
            }
            
            function openDone(id){
                var href =  "ajax/getWorkflow.php";
                var post = {idWorkflow: id, operation: "finalizar", idGrupo: $("#idgrupo").val()};
                showAlert('confirm',{
                    type: BootstrapDialog.TYPE_DANGER, 
                    title: 'COFIRMAÇÃO', message:'Tem certeza que deseja concluir esta atividade?'
                },
                {
                    method:'POST', 
                    type: 'POST', // Só ta funcionado com type, deve ser versão de lib jquery
                    url: href, 
                    data: post,
                    cache: false,
                    after_function: function(data, dialogRef){
                        if(data.ok === true){
                            dialogRef.getModalBody().html(data.msg);
                            dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                            Load($("#idgrupo").val());
                        }else{
                            dialogRef.getModalBody().html(data.msg);
                        }
                    }
                });
            }
            
            function openNext(){
                var href = "modelos/startWorkflow.php";
                var post = {idgrupo: $("#idgrupo").val()};
                $('.modal-dialog').css({width:'590px'});
                getAjaxPage(href, post);
                $('.modal-title').text("Definição da próxima atividade.");
            }
            
            function getAjaxPage(href, post){
                $.ajax({
                   url: href,
                   data: post,
                   method: 'POST',
                   dataType: 'HTML',
                   success: function(data){
                       $(".content_ajax > ").remove();
                       var retorno = $(data);
                       $(".content_ajax").html(retorno).fadeIn();
                       $('#modal').modal('show');
                   },
                   error: function(msg){
                       $(".content_ajax > ").remove();
                       var retorno = $(msg);
                       $(".content_ajax").html(retorno).fadeIn();
                       $('#modal').modal('show');
                   }
                });
            }
            
        </script>
        <style>
            .readerPDF{position: fixed;width: 90%;height: 95%;overflow-y: hidden;overflow-x: hidden;left: 5%;top: 2.5%;display: none;z-index: 9999;}
        </style>
    </head>
    <body>
        <div class="readerPDF"></div>
        <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $idgrupo; ?>"/>

        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="modal fade" id="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="top: -5px;position: relative;" aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class='content_ajax'>
                            
                                </div><!-- /.content_ajax -->
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?php
                            if ($tipo_users > 0) {
                                echo '<h4> Selecione o Grupo</h4>'
                                . '<div class="form-group input-group">'
                                    . '<select name="select-idgrupo" id="select-idgrupo"'
                                    . ' class="selectpicker" multiple  data-max-options="1" '
                                    . 'data-min-options="1" required data-style="btn-info" '
                                    . 'title="Selecione o grupo de trabalho?" data-live-search="true" >';


                                $pdo = new Conexao();
                                echo "<optgroup label='Grupos - Títulos'>";

                                foreach ($array_grupos as $id) {
                                    $result = $pdo->select("SELECT * FROM grupo_has_users a INNER JOIN grupo b ON a.idgrupo = b.idgrupo WHERE a.uid = {$id_users} AND b.recusado = 0 ORDER BY titulo");
                                    foreach ($result as $res) {
                                        if ($idgrupo == $res['idgrupo']) {
                                            echo "<option selected value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        } else {
                                            echo "<option value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        }
                                    }
                                }
                                echo "</optgroup></select></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" id="workflow">
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <!-- /.row -->
                <div class="row">

                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    </body>
</html>