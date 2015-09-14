<?php
require_once('verifica-logado.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin</title>

        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        
        <script>
            $(document).ready(function () {
                $('.panel-red a').click(function () {
                    var expansivePainel = $(this).parents('.panel-red');
                    var idAluno1 = expansivePainel.find('.aluno1').attr('id');
                    var idAluno2 = expansivePainel.find('.aluno2').attr('id');
                    var idAluno3 = expansivePainel.find('.aluno3').attr('id');
                    var idgrupo = $(this).attr("id");
                    var idProf = <?php echo $id_users; ?>;

                    $.ajax({
                        type: "POST",
                        url: "ajax/updateVistoGrupo.php",
                        data: "idgrupo=" + idgrupo + "&idAluno1=" + idAluno1 + "&idAluno2=" + idAluno2 + "&idAluno3=" + idAluno3 + "&idProf=" + idProf,
                        success: function (html) {
                            expansivePainel.removeClass('panel-red').addClass('panel-green');
                        },
                        error: function (html) {
                            showAlert('alert',{title: 'ERRO!!!', message:'Erro de processo!!!', type: BootstrapDialog.TYPE_DANGER}, null);
                        }
                    });

                });
            });
            //funcao para ceitar a requisicao e montar um grupo para ser orientado
            function montaGrupo(id1, id2, id3, idgrupo) {
                loading_show();
                var idProf = <?php echo $id_users; ?>;
                $.ajax({
                    type: "POST",
                    url: "ajax/montaGrupo.php",
                    data: "id1=" + id1 + "&id2=" + id2 + "&id3=" + id3 + "&idgrupo=" + idgrupo + "&idprof=" + idProf,
                    success: function (html) {
                        $('.alert-success').fadeIn('fast');
                        loading_hide();
                    }
                });
            }

            //funcao para rejeitar uma requisicao de orientacao
            function recusaGrupo(id1, id2, id3, idgrupo) {
                var idProf = <?php echo $id_users; ?>;
                var url = "requisicao-negada.php";
                window.location.href = url + "?id1=" + id1 + "&id2=" + id2 + "&id3=" + id3 + "&idgrupo=" + idgrupo + "&idprof=" + idProf;
            }

            //funcao para solicitar mais detalhes da requisicao
            function maisDetalhes(id1, id2, id3, idgrupo) {
                loading_show();
                var idProf = <?php echo $id_users; ?>;
                $.ajax({
                    type: "POST",
                    url: "ajax/maisDetalhes.php",
                    data: "id1=" + id1 + "&id2=" + id2 + "&id3=" + id3 + "&idgrupo=" + idgrupo + "&idprof=" + idProf,
                    success: function (html) {
                        $('.alert-success').fadeIn('fast');
                        loading_hide();
                    }
                });
            }
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

                                    $result = $pdo->select("SELECT g.idgrupo,date_format(g.dataCriacao, '%d/%m/%Y') as dataCriacao,g.titulo,g.descricao,g.visto
															FROM grupo g
															INNER JOIN grupo_has_users gu ON gu.idgrupo = g.idgrupo
															INNER JOIN users u ON u.uid = gu.uid
															WHERE u.uid = " . $id_users . "
															AND g.aceito = 0
															AND g.recusado = 0
															AND g.revisando = 0
															AND gu.tipo = 2");
                                    if (count($result)) {
                                        $i = 0;
                                        foreach ($result as $res) {
                                            if ($res['visto'] == 0) {
                                                echo '<div class="panel panel-red">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a style="color:#FFF!important;" data-toggle="collapse" data-parent="#accordion" id="' . $res['idgrupo'] . '" href="#collapse' . $i . '"><i class="fa fa-th-list"></i> ' . $res['titulo'] . '</a>
															</h4>
														</div>
													<div id="collapse' . $i . '" class="panel-collapse collapse">
														<div class="panel-body">
															<p><smal><i class="fa fa-calendar"></i> Enviado <strong>' . $res['dataCriacao'] . '</strong></smal></p><hr/>
															<div class="row">';

                                                $resultado = $pdo->select("SELECT u.uid,username,email,fotouser
																				FROM users u
																				INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																				where gu.idgrupo = " . $res['idgrupo'] . "
																				AND u.tipo = 0
																				AND gu.tipo = 1");
                                                $idGrupo = null;
                                                $k = 1;
                                                foreach ($resultado as $ress) {
                                                    echo '<div class="col-sm-4 aluno' . $k . '" id="' . $ress['uid'] . '">
																<p><img src="' . $ress['fotouser'] . '" width="60px" alt="' . $ress['username'] . '"/>
																</p>
																<p>
																<i class="fa fa-graduation-cap"></i><strong>' . $ress['username'] . '</strong><br/>
																<i class="fa fa-envelope-o"></i> ' . $ress['email'] . '</p>
																</div>';

                                                    $idGrupo .= chr(39) . $ress['uid'] . chr(39) . ',';
                                                    $k++;
                                                }
                                                $idGrupo .= chr(39) . $res['idgrupo'] . chr(39) . ',';
                                                $size = strlen($idGrupo);
                                                $condicao2 = substr($idGrupo, 0, $size - 1);

                                                echo '			</div>';

                                                $resultadoCori = $pdo->select("SELECT u.uid,username,email,fotouser
																				FROM users u
																				INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																				where gu.idgrupo = " . $res['idgrupo'] . "
																				AND gu.tipo = 3");

                                                if (count($resultadoCori)) {
                                                    foreach ($resultadoCori as $resCori) {
                                                        echo '<hr/>
																		<p><strong>Coorientador</strong></p>
																		<p><img src="' . $resCori['fotouser'] . '" width="60px" alt="' . $resCori['username'] . '"/></p>
																		<p><i class="fa fa-graduation-cap"></i><strong>' . $resCori['username'] . '</strong><br/>
																		<i class="fa fa-envelope-o"></i> ' . $resCori['email'] . '</p>
																		';
                                                    }
                                                }

                                                echo '		
															<hr/>
															<p><strong>Descri&ccedil;&atilde;o</strong></p>
															<p>' . $res['descricao'] . '</p><hr/>
															<p>
								<button type="button" onclick="montaGrupo(' . $condicao2 . ')" class="btn btn-outline btn-success">Aceitar</button>
                                <button type="button" onclick="recusaGrupo(' . $condicao2 . ')" class="btn btn-outline btn-danger">Recusar</button>
								<a href="" data-toggle="modal" data-target="#myModal"><button type="button" onclick="maisDetalhes(' . $condicao2 . ')" class="btn btn-outline btn-warning">Mais Detalhes</button></a></p>
							</p>
														<br/>
														<div id="loading"></div>
														<div class="alert alert-success alert-dismissable" style="display:none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Opera&ccedil;&atilde;o realizada com sucesso...
							</div>
														</div>
													</div>
												</div>';

                                                $i++;
                                            } else if ($res['visto'] == 1) {
                                                echo '<div class="panel panel-green">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a style="color:#FFF!important;" data-toggle="collapse" data-parent="#accordion" id="' . $res['idgrupo'] . '" href="#collapse' . $i . '"><i class="fa fa-th-list"></i> ' . $res['titulo'] . '</a>
															</h4>
														</div>
													<div id="collapse' . $i . '" class="panel-collapse collapse">
														<div class="panel-body">
															<p><smal><i class="fa fa-calendar"></i> Enviado <strong>' . $res['dataCriacao'] . '</strong></smal></p><hr/>
															<div class="row">';

                                                $resultado = $pdo->select("SELECT u.uid,username,email,fotouser
																				FROM users u
																				INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																				where gu.idgrupo = " . $res['idgrupo'] . "
																				AND u.tipo = 0
																				AND gu.tipo = 1");
                                                $idGrupo = null;
                                                $k = 1;
                                                echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Alunos</strong></p>';
                                                foreach ($resultado as $ress) {
                                                    echo '<div class="col-sm-4 aluno' . $k . '" id="' . $ress['uid'] . '">
																<p><img src="' . $ress['fotouser'] . '" width="60px" alt="' . $ress['username'] . '"/>
																</p>
																<p>
																<i class="fa fa-graduation-cap"></i><strong>' . $ress['username'] . '</strong><br/>
																<i class="fa fa-envelope-o"></i> ' . $ress['email'] . '</p>
																</div>';

                                                    $idGrupo .= chr(39) . $ress['uid'] . chr(39) . ',';
                                                    $k++;
                                                }
                                                $idGrupo .= chr(39) . $res['idgrupo'] . chr(39) . ',';
                                                $size = strlen($idGrupo);
                                                $condicao2 = substr($idGrupo, 0, $size - 1);

                                                echo '		
															</div>';

                                                $resultadoCori = $pdo->select("SELECT u.uid,username,email,fotouser
																				FROM users u
																				INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																				where gu.idgrupo = " . $res['idgrupo'] . "
																				
																				AND gu.tipo = 3");

                                                if (count($resultadoCori)) {
                                                    foreach ($resultadoCori as $resCori) {
                                                        echo '<hr/>
																		<p><strong>Coorientador</strong></p>
																		<p><img src="' . $resCori['fotouser'] . '" width="60px" alt="' . $resCori['username'] . '"/>
																		</p>
																		<p>
																		<i class="fa fa-graduation-cap"></i><strong>' . $resCori['username'] . '</strong><br/>
																		<i class="fa fa-envelope-o"></i> ' . $resCori['email'] . '</p>
																		';
                                                    }
                                                }

                                                echo '	<hr/>
															<p><strong>Descri&ccedil;&atilde;o</strong></p>
															<p>' . $res['descricao'] . '</p><hr/>
															<p>
								<button type="button" onclick="montaGrupo(' . $condicao2 . ')" class="btn btn-outline btn-success">Aceitar</button>
                                <button type="button" onclick="recusaGrupo(' . $condicao2 . ')" class="btn btn-outline btn-danger">Recusar</button>
								<a href="" data-toggle="modal" data-target="#myModal"><button type="button" onclick="maisDetalhes(' . $condicao2 . ')" class="btn btn-outline btn-warning">Mais Detalhes</button></a></p>
														<br/>
														<div class="alert alert-success alert-dismissable" style="display:none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Opera&ccedil;&atilde;o realizada com sucesso...
							</div>
														</div>
													</div>
												</div>';

                                                $i++;
                                            }
                                        }
                                    } else {
                                        echo '<div class="alert alert-success alert-dismissable">'
                                            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                            . 'N&atilde;o h&agrave; requisi&ccedil;&otilde;es para aceitar...</div>';
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
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Solicita&ccedil;&atilde;o de maiores detalhes</h4>
                    </div>
                    <div class="modal-body">
                        Uma mensagem foi enviada aos alunos do presente grupo, solicitando um maior detalhamento do projeto descrito, para que possa ser avaliado mais precisamente, pois as informa&ccedil;&otilde;es contidas na presente mensagem n&atilde;o s&atilde;o suficientes para compreendimento da proposta do projeto.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline btn-success" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
        
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>
        
    </body>
</html>