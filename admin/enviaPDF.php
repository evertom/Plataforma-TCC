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
        <script type="text/javascript" src="js/jquery-1.7.js"></script>

        <script type="text/javascript" src="js/jquery.form.js"></script>

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

            $('#form').ajaxForm({
                uploadProgress: function (event, position, total, percentComplete) {
                    $('.progress-bar').css('width', percentComplete);
                    $('#porcentagem').html(percentComplete + '%');
                },
                success: function (data) {
                    console.log(data);
                    $('.progress-bar').css('width', '100%');
                    $('#porcentagem').html('100%');
                    $('#visualizar').slideDown(3000, function () {
                        $('#visualizar').html(data);
                    })
                    $('.progress-bar').fadeOut(3000);
                }
            });
            
            $('.arqs').live('click', function(){
                var idUser = <?php echo $id_users;?>;
                $.ajax
                ({
                    type: "POST",
                    url: "ajax/listaArquivos.php",
                    data: "idUser="+idUser,
                    success: function (data)
                    {
                        console.log(data);
                        $(".modal-body").html(data);
                    },
                    error: function (data) {

                    }
                });
                return false;
            });
            
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
                            <h2 class="page-header">Envio <span class="text-danger">de Arquivos</span></h2>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <blockquote>
                                Mande seu arquivo em formato PDF para que o(a) professor(a) possa fazer suas consideracoes sobre o TCC
                            </blockquote>
                            <br>
                            <form action="ajax/upload.php" method="post" id="form">
                                <div id="file">
                                    <input type="file" name="file" class="btn btn-primary"/>
                                    <br ><br >

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            <span id="porcentagem">0%</span>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <input type="submit" class="btn btn-primary"/>
                                <input type="button" class="btn btn-info arqs" value="Ver Arquivos enviados" data-toggle="modal" data-target="#myModal"/>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Arquivos Enviados</h4>
                                            </div>
                                            <div class="modal-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </form> 
                            <br style="clear: both;">
                            <br style="clear: both;">
                            <div id="visualizar"></div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <div class="row"></div>
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