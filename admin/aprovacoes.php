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
            //funcao para rejeitar uma requisicao de orientacao
            function aprovaGrupo(id1, id2, id3, idgrupo) {
                var idProf = <?php echo $id_users; ?>;

            }

            $(document).ready(function () {
                $('#formCad').submit(function (e) {
                    var ok = false;

                    if ($('input[name=disponibilizar]').is(':checked')) {
                        if ($('input[name=nota]').val() <= 9) {
                            showAlert('alert', {title: 'AVISO!!!',
                                message: 'Atenção, para disponibilizar a monografia como exemplo, a nota final deve ser maior ou igual a 9...',
                                type: BootstrapDialog.TYPE_WARNING}, null);
                        } else {
                            ok = true;
                        }
                    } else {
                        ok = true;
                    }

                    if (ok === true) {
                        var Post = new FormData(this);

                        showAlert('confirm', {
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'AVISO!!!', message: 'Tem certeza que deseja adicionar este(s) arquivo(s)?',
                            time_to_close_dialog: 9000
                        },
                        {
                            method: 'POST',
                            type: 'POST',
                            url: 'ajax/insertArqFinal.php',
                            data: Post,
                            dataType: 'JSON',
                            cache: false,
                            processData: false,
                            contentType: false,
                            after_function: function (data, dialogRef) {
                                console.log(data);
                                if (data) {
                                    dialogRef.getModalBody().html(data.msg);
                                    dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                                    setTimeout('window.location.href="aprovacoes.php"', 4000);
                                } else {
                                    dialogRef.getModalBody().html('falha ao realizar o procedimento!');
                                }
                            }
                        });
                    }
                    e.preventDefault();
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
                            <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user ?></span></h1>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- .panel-heading -->
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">
                                    <?php
                                    require_once('includes/Conexao.class.php');
                                    $pdo = new Conexao();

                                    $result = $pdo->select("SELECT * FROM atadefesa WHERE status = 0");
                                    if (count($result)) {
                                        $i = 0;
                                        foreach ($result as $res) {

                                            echo '<div class="panel panel-green">
                                                        <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                        <a style="color:#FFF!important;" data-toggle="collapse" data-parent="#accordion" id="' . $res['idgrupo'] . '" href="#collapse' . $i . '"><i class="fa fa-th-list"></i> ' . $res['titulo'] . '</a>
                                                                </h4>
                                                        </div>
                                                        <div id="collapse' . $i . '" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <p><smal><i class="fa fa-calendar"></i> Data da Banca Final <strong>' . date('d-m-Y', strtotime($res['dia'])) . '</strong> às ' . $res['hora'] . ' horas</smal></p><hr/>
                                                                <div class="row">';

                                            $resultado = $pdo->select("SELECT u.uid,username,email,fotouser
                                                                        FROM users u
                                                                        INNER JOIN grupo_has_users gu ON gu.uid = u.uid
                                                                        where gu.idgrupo = " . $res['idgrupo'] . "
                                                                        AND u.tipo = 0");
                                            $idGrupo = null;
                                            $k = 1;
                                            foreach ($resultado as $ress) {
                                                echo '<div class="col-sm-4 aluno' . $k . '" id="' . $ress['uid'] . '">
                                                        <p><img src="' . $ress['fotouser'] . '" width="100" alt="' . $ress['username'] . '" style="border:4px solid #9C9C9C;border-radius:10px;"/>
                                                        </p>
                                                        <p>
                                                        <i class="fa fa-graduation-cap"></i><strong>' . $ress['username'] . '</strong><br/>
                                                        <i class="fa fa-envelope-o"></i> ' . $ress['email'] . '</p>
                                                        </div>';
                                                $k++;
                                            }
                                            echo '</div>';

                                            $resultadoCori = $pdo->select("SELECT u.uid,username,email,fotouser "
                                                    . "FROM users u INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
                                                    . "WHERE gu.idgrupo = " . $res['idgrupo'] . " AND gu.tipo = 3");

                                            if (count($resultadoCori)) {
                                                foreach ($resultadoCori as $resCori) {
                                                    echo '<hr/><p><strong>Coorientador</strong></p>'
                                                    . '<p><img src="' . $resCori['fotouser'] . '" width="100" alt="' . $resCori['username'] . '" style="border:4px solid #9C9C9C;border-radius:10px;"/></p>'
                                                    . '<p><i class="fa fa-graduation-cap"></i><strong>' . $resCori['username'] . '</strong><br/>'
                                                    . '<i class="fa fa-envelope-o"></i> ' . $resCori['email'] . '</p>';
                                                }
                                            }

                                            echo '
                                                <hr>
                                                <h2>Professores <small>da Banca</small></h2><br><br>
                                                <div class="col-lg-12">
                                                <form enctype="multipart/form-data" method="POST" id="formCad" action="" >
                                                    <input type="hidden" value="' . $res['idAtaDefesa'] . '" name="idAtaDefesa" />
                                                    <input type="hidden" value="' . $res['titulo'] . '" name="titulo" />
                                                    <input type="hidden" value="' . $res['idgrupo'] . '" name="idgrupo" />
                                                    <div class="col-lg-3" style="margin-bottom: 40px;">
                                                        <p>' . $res['prof1'] . '</p>
                                                        <p>' . $res['prof2'] . '</p>
                                                        <p>' . $res['prof3'] . '</p>
                                                    </div>
                                                
                                                    <div class="col-lg-3" style="margin-bottom: 40px;">
                                                        <p><input type="radio" name="status" value="1" class="" style="width:30px;display:inline" checked/> Aprovado <i class="fa fa-check"></i></p>
                                                        <p><input type="radio" name="status" value="2" class="" style="width:30px;"/> Reprovado <i class="fa fa-times"></i></p>
                                                        <p><input type="texte" name="nota" value="" class="form-control" placeholder="Nota Final" required="required"/></p>
                                                    </div>
                                                    <div class="col-lg-6" style="margin-bottom: 40px;">
                                                        <p><input type="checkbox" value="1" name="disponibilizar" /> Deseja Disponibilizar a monografia em PDF na Plataforma como Exemplo de consulta para outros alunos?</p>
                                                        <p><input type="file" class="btn btn-primary" name="file" /></p>

                                                    </div>
                                                    <br style="clear:both">

                                                    <button type="submit" class="btn btn-success" id="enviaArq"> <i class="fa fa-graduation-cap"></i> Enviar</button></p>
                                                </form>
                                                                </div>
                                                                </div>
                                                        </div>
                                                </div>';

                                            $i++;
                                        }
                                    } else {
                                        echo '<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    Voc&ecirc; n&atilde;o possui grupos com Banca marcada...
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- .panel-body -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
    </body>
</html>