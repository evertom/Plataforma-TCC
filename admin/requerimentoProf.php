<?php
require_once('verifica-logado.php');
$idProf = isset($_GET['uid']) ? $_GET['uid'] : "";
$nomeProf = isset($_GET['nome']) ? $_GET['nome'] : "";

if ($idProf == "" || $nomeProf == "") {
    $alerta = '<div class="alert alert-danger alert-dismissable">'
            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
            . '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
            . 'Para requisitar um professor voc&ecirc; deve escolher um na tela principal do f&oacute;rum '
            . '<a href="index.php" class="alert-link">Clique aqui</a>.</div>';
} else {
    $alerta = '<div class="alert alert-danger alert-dismissable">'
            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
            . '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
            . 'Preencha todos os campos, e descreva muito bem sua ideia para que o professor entenda sua '
            . 'proposta e possa aceita-la...</div>';
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
        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"/></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"/></script>
        <![endif]-->
        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <!-- jQuery -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>
        <script>
            $(document).ready(function () {
                $("#contact").submit(function () {
                    loading_show();
                    //pegamos totos os valores do form
                    var valores = $("#contact").serializeArray();
                    
                    $.ajax({
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/insertReq.php",
                        data: valores,
                        success: function (data)
                        {
                            if(data.msg === true){
                                showAlert('alert', {title: 'AVISO!!!',
                                    message: 'Requerimento enviado com sucesso, aguarde o professor entrar em contato...',
                                    type: BootstrapDialog.TYPE_SUCCESS,location:'index.php'}, null);
                                limpa();
                            }else{
                                console.log(data);
                                showAlert('alert', {title: 'AVISO!!!', 
                                    message: 'Falha ao cadastrar requerimento...', 
                                    type: BootstrapDialog.TYPE_ERROR,location:'index.php'}, null);
                                limpa();
                            }
                        },
                        error: function (data){
                            console.log(data);
                            showAlert('alert', {title: 'AVISO!!!',
                                message: 'Falha no sistema, contate seu administrador...',
                                type: BootstrapDialog.TYPE_ERROR,location:'index.php'}, null);
                        }   
                    });
                    return false;
                });

                // aqui a fun??o ajax que busca os dados em outra pagina do tipo html, n?o ? json
                function load_dados(valores, page, div)
                {
                    $.ajax
                            ({
                                type: 'POST',
                                dataType: 'html',
                                url: page,
                                beforeSend: function () {//Chama o loading antes do carregamento
                                    loading_show();
                                },
                                data: "parametro=" + valores,
                                success: function (msg)
                                {
                                    loading_hide();
                                    var data = msg;
                                    $(div).html(data).fadeIn();
                                }
                            });
                }

                load_dados(null, 'ajax/pesqAluno1.php', '#Pront1');

                //Aqui uso o evento key up para come?ar a pesquisar, se valor for maior q 2 ele faz a pesquisa
                $('#name1').keyup(function () {

                    var $parametro = $(this).val();

                    if ($parametro.length >= 1) {
                        load_dados($parametro, 'ajax/pesqAluno1.php', '#Pront1');
                    } else {
                        load_dados(null, 'ajax/pesqAluno1.php', '#Pront1');
                    }
                });

                $('#name2').keyup(function () {

                    var $parametro = $(this).val();

                    if ($parametro.length >= 1)
                    {
                        load_dados($parametro, 'ajax/pesqAluno2.php', '#Pront2');
                    } else
                    {
                        load_dados(null, 'ajax/pesqAluno2.php', '#Pront2');
                    }
                });

                $('#name3').keyup(function () {

                    var $parametro = $(this).val();

                    if ($parametro.length >= 1)
                    {
                        load_dados($parametro, 'ajax/pesqAluno3.php', '#Pront3');
                    } else
                    {
                        load_dados(null, 'ajax/pesqAluno3.php', '#Pront3');
                    }
                });

                $('#coorientador').keyup(function () {

                    var $parametro = $(this).val();

                    if ($parametro.length >= 1)
                    {
                        load_dados($parametro, 'ajax/pesqCoorientador.php', '#coori');
                    } else
                    {
                        load_dados(null, 'ajax/pesqCoorientador.php', '#coori');
                    }
                });
            });

            function loading_show() {
                $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
            }
            function loading_hide() {
                $('#loading').fadeOut('fast');
            }
            function limpa() {
                $('#contact').find("textarea").val("");
                $('#contact').find("input").each(function () {
                    $(this).val("");
                });
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
                            <h1 class="page-header">Requerimento de Orienta&ccedil;&atilde;o ao Professor <span class="text-danger"><?php echo $nomeProf ?></span></h1>
                        </div>
                    </div>
                    <br/>
                    <?php
                    if (isset($alerta)) {
                        echo $alerta;
                    }
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <form method="post" class="reply" id="contact">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input id="name1" name="name1" type="text" placeholder="Nome do primeiro integrante" value="" required class="form-control"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12" style="font-size: 20px;">
                                                <div id="Pront1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input id="name2" name="name2" type="text" placeholder="Nome do segundo integrante" value="" class="form-control"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12" style="font-size: 20px;">
                                                <div id="Pront2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input id="name3" name="name3" type="text" placeholder="Nome do terceiro integrante" value="" class="form-control"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12" style="font-size: 20px;">
                                                <div id="Pront3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input id="coorientador" name="coorientador" type="text" placeholder="Nome do Coorientador" value="" class="form-control"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12" style="font-size: 20px;">
                                                <div id="coori"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>
                                                <input class="form-control" id="titulo" name="titulo" type="text"  placeholder="Titulo" value="" required></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div id="loading"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" id="descri" name="descri" style="height:150px;" placeholder="Descri&ccedil;&atilde;o" required></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <br/>
                                <input id="user" name="user" type="hidden" value="<?php echo $id_users; ?>"></input>
                                <input id="orientador" name="orientador" type="hidden" value="<?php echo $idProf; ?>"></input>
                                <input id="acao" name="acao" type="hidden" value="inserir"></input>
                                <button class="btn btn-primary pull-left" type="submit">Enviar Requisi&ccedil;&atilde;o</button>
                                <div id="loading"></div><br/><br/><br/>

                                <div class="clearfix">
                                </div>

                            </form>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="alert alert-success alert-dismissable" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Opera&ccedil;&atilde;o realizada com sucesso...
                            </div>
                            <div class="alert alert-danger alert-dismissable"  style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                Falha no cadastro...
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
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