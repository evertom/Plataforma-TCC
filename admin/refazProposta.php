<?php 
require_once('verifica-logado.php');
$id = isset($_GET['idgrupo']) ? $_GET['idgrupo']:"";
	
	if($id == ""){
            echo  "<script type='text/javascript'>
                        window.location.href='panel.php'
                    </script>";
            exit;
	}
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
    <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
    <script>
        //funcao para solicitar mais detalhes da requisicao
        function RefazRequisicao(idgrupo,idProf){
            loading_show();
            var idUser = <?php echo $id_users;?>;
            var texto = $("#descriProjeto").val();

            if(texto == ""){
                showAlert('alert',{title: 'Aviso!!!', message:'Preencha a Descricao do Projeto!!!', type: BootstrapDialog.TYPE_WARNING}, null);
                loading_hide();
            }else{
                $.ajax({
                    type: "POST",
                    url: "ajax/refazRequisicao.php",
                    data: "idgrupo=" + idgrupo + "&idUser="+idUser + "&idProf=" + idProf + "&texto="+texto,
                    success: function(html){
                        $('.alert-success').fadeIn('fast');
                        loading_hide();
                    }
                });
            }
        }

        //fun��o para mostrar o loading
        function loading_show(){
            $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
        }
        //fun��o para esconder o loading
        function loading_hide(){
            $('#loading').fadeOut('fast');
        }

        function limpa(){
            $('#contact').find("textarea").val("");
            $('#contact').find("input").each(function(){
                $(this).val("");
            });
        }

    </script>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
           <?php require_once('pages/headerAdminAcessoNegado.php');?>
        </nav>

        <!-- Page Content -->
        <div class="row" style="height:auto;background:#FFF;">
			<div class="col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user?></span></h1>
                    </div>
                </div>		
                <!-- /.row -->
				 <div class="row">
                    <div class="col-xs-12">
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
															WHERE u.uid = ".$id_users."
															AND g.aceito = 0
															AND g.recusado = 0");
									if(count($result)){
										$i = 0;
										foreach($result as $res){
										
												echo '<div class="panel panel-danger">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a style="color:#940000!important;" data-toggle="collapse" data-parent="#accordion" id="'.$res['idgrupo'].'" href="#collapse'.$i.'"><i class="fa fa-th-list"></i> '.$res['titulo'].'</a>
															</h4>
														</div>
													<div id="collapse'.$i.'" class="panel-collapse collapse in">
														<div class="panel-body">
															<p><smal><i class="fa fa-calendar"></i> Enviado <strong>'.$res['dataCriacao'].'</strong></smal></p><hr/>
															<div class="row">';
															
															$resultado = $pdo->select("SELECT u.uid,username,email,fotouser
																				FROM users u
																				INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																				where gu.idgrupo = ".$res['idgrupo']."
																				AND u.tipo = 0");
															$idGrupo = null;
															$k = 1;
															foreach($resultado as $ress){
																echo '<div class="col-sm-4 aluno'.$k.'" id="'.$ress['uid'].'">
																<p><img src="'.$ress['fotouser'].'" width="60px" alt="'.$ress['username'].'"/>
																</p>
																<p>
																<i class="fa fa-graduation-cap"></i><strong>'.$ress['username'].'</strong><br/>
																<i class="fa fa-envelope-o"></i> '.$ress['email'].'</p>
																</div>';
																
																
																$k++;
															}
															$idGrupo .= chr(39).$res['idgrupo'].chr(39).',';
															
															$resu = $pdo->select("SELECT u.uid
																		FROM users u
																		INNER JOIN grupo_has_users gu ON gu.uid = u.uid
																		WHERE gu.idgrupo = ".$res['idgrupo']."
																		AND u.tipo = 1
																		AND gu.tipo = 2");
															
															foreach($resu as $resProf){
																$idProf = $resProf['uid'];
															}
															$idGrupo .= chr(39).$idProf.chr(39).',';
															$size = strlen($idGrupo);
															$condicao2 = substr($idGrupo,0,$size-1);
																													
												echo '		
															</div>
															<hr/>
															<p><strong>Descri&ccedil;&atilde;o</strong></p>
															<p><textarea id="descriProjeto" style="width:100%;height:200px;padding:10px;">'.$res['descricao'].'</textarea></p>
															<p>
	<button type="submit" value="" onclick="RefazRequisicao('.$condicao2.')" class="update_button btn btn-primary">Enviar <span class="glyphicon glyphicon-send"></span></button></p>
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
										}
									}
								?>
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                </div>		
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
			</div>
			<br style="clear:both;"/>
			<br style="clear:both;"/>
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
    <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
    <script src="bootstrap3-dialog-master/alertsMsg.js"></script>
  
</body>
</html>