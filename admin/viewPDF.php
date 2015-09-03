<?php
require_once('verifica-logado.php');
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
        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            $(document).ready(function () {
                $("#pdfgrupo").change(function () {
                    var idGrupo = $(this).val();
                    $(".idgrupo").val(idGrupo);
                    $("#viewer").remove().slideUp();
                    loading_show();

                    $.ajax({
                        type: "POST",
                        url: "viewPDF/web/viewer.php",
                        data: "idgrupo=" + idGrupo,
                        success: function (data) {
                            loading_hide();
                            console.log(data);
                            $(".iframe").html('<iframe src="viewPDF/web/viewer.php?" id="viewer" style="border: 0px; overflow: hidden" width="100%" height="100%"></iframe>').slideDown('slow');
                        },
                        error: function (data) {

                        }
                    });
                    return false;
                });
                
                $("#consideracoesFinais").submit(function(){
                    var valores = $("#consideracoesFinais").serializeArray();
                    
                    $.ajax({
                        type: "POST",
                        url : "ajax/consideracoes.php",
                        data : valores,
                        beforeSend: function (data) {
                            $('#loading2').html("<img src='img/loader.gif'/>").fadeIn('fast');
                        },
                        success: function(data){
                            console.log(data);
                            $('textarea').val("");
                            $('#loading2').fadeOut();
                            $('.alert-success').fadeIn('fast');
                            $('.alert-success').fadeOut(4000);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                    return false;
                });
                
                
            });
            function loading_show() {
                $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
            }
            function loading_hide() {
                $('#loading').fadeOut('fast');
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">Considerações <span class="text-danger">de acompanhamento do PDF</span></h2>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Escolha seu grupo: 
                            <select name="pdfgrupo" class="btn btn-primary" id="pdfgrupo">
                                <option value="" selected="selected">Escolha um Grupo para ver seu PDF...</option>
                                <?php
                                require_once './includes/Conexao.class.php';
                                $pdo = new Conexao();
                                $result = $pdo->select("SELECT gu.idgrupo,g.titulo "
                                        . "FROM grupo_has_users gu "
                                        . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
                                        . "WHERE gu.uid = {$id_users} AND gu.tipo = 2 ");
                                foreach ($result as $res) {
                                    echo '<option value="' . $res['idgrupo'] . '">' . $res['titulo'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- /.row -->

                </div>
                <!-- /.container-fluid -->
                <br><br>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md-6 iframe" style="height:417px;">
                        <div id="loading"></div>
                        <iframe src="viewPDF/web/viewer.php" id="viewer" style="border: 0px; overflow: hidden" width="100%" height="100%"></iframe>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-6">
                        <div class="col-xs-12">
                            <b style="font-size: 1.4em;">Faça suas Considerações <span class="text-danger">ao Grupo</span></b>
                            <form method="post" class="reply" id="consideracoesFinais">
                                <input type="hidden" name="idgrupo" value="" class="idgrupo"/>
                                <textarea name="consideracoes" class="form-control" rows="12"></textarea><br>
                                <button type="submit" value="" id="update_button" class="update_button btn btn-primary">Enviar <span class="glyphicon glyphicon-send"></span></button>
                                <div id="loading2"></div>
                            </form>
                            <div class="alert alert-success" style="margin-top:20px;display: none;">
                                Considerações enviadas com sucesso...
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
    </body>
</html>