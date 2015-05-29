<?php 
require_once('verifica-logado.php');
$id = isset($_GET['id']) ? $_GET['id']:"";
if($id = ""){
	echo  "<script type='text/javascript'>location.href='painel.php'</script>";
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
	<script>
		$(document).ready(function(){
			//evento do botao editar para chamar o form dinamico
			$('.notificacoes').click(function(){
				$(this).find('span').fadeOut();
				//apos clicar nas configurações damos um update nas notificacoes do usuario atual para nao exibir mais msg
				var user = <?php echo $id_users;?>;
				$.ajax({
					type: "POST",
					url: "ajax/updateAviso.php",
					data: "user="+user,
					success: function(html){
						
					}
				});
			});
			
			$("#contact").submit(function(){
				//pegamos totos os valores do form
				var valores = $("#contact").serializeArray();
				var ok = false;
				var id = null;
							
				$.ajax
				({
					async: false,
					type: "POST", //metodo POST
					dataType: 'json',
					url: "ajax/updateUserProfile.php",
					beforeSend: function(){
						loading_show();
					},
					data: valores,
					success: function(data)
					{
						ok = data.msg;
					},
					error: function(data){
						$('.alert-danger').fadeIn('fast');
						ok = false;
					},
					complete: function(){
						loading_hide();
						return ok;
					}
				});	
				
				if(ok == true){
					$('.alert-success').fadeIn('fast');
					limpa();
				}else{
					$('.alert-danger').fadeIn('fast');
					limpa();
				}
				
				return false;
			});
		});
		
		//função para mostrar o loading
		function loading_show(){
			$('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
		}
		//função para esconder o loading
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
            <?php require_once('pages/headerAdmin.php');?>
            <?php require_once('pages/menuLateralAdmin.php');?>
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user?></span></h1>
                    </div>
                </div>
				<br/>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-8">
						<form method="post" class="reply" id="contact">
							<fieldset>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="name" name="name" type="text" placeholder="Nome" value="<?php echo $nome_user;?>" required class="form-control"></input>
                                        </div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Email" value="<?php echo $email_users;?>" required></input>
                                        </div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                           <input class="form-control" id="pass" name="pass" type="password"  placeholder="Senha" value="" required></input>
                                        </div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input class="form-control" id="prontuario" name="prontuario" type="text"  placeholder="Prontu&aacute;rio" value="<?php echo $prontuario_users;?>" required></input>
                                        </div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>
											<?php
												if($tipo_users == 0){
													$cargo_users = "Aluno";
													echo '<input class="form-control" id="cargo" name="cargo" type="text"  placeholder="Cargo" value="'.$cargo_users.'" readonly="true" required></input>';
												}else{
													echo '<input class="form-control" id="cargo" name="cargo" type="text"  placeholder="Cargo" value="'.$cargo_users.'" required></input>';
												}
											?>
											
                                        </div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" id="descri" name="descri" rows="3" cols="40" placeholder="Descri&ccedil;&atilde;o" required><?php echo $descricao_users;?></textarea>
									</div>
								</div>
							</fieldset>
							<br/>
							<input id="id_users" name="id_users" type="hidden" value="<?php echo $id_users;?>"></input>
							<input id="acao" name="acao" type="hidden" value="inserir"></input>
							<button class="btn btn-primary pull-left" type="submit">Cadastrar</button>
							<div id="loading"></div>
							<br/><br/><br/>
							<div class="alert alert-success alert-dismissable" style="display:none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Opera&ccedil;&atilde;o realizada com sucesso...
							</div>
							<div class="alert alert-danger alert-dismissable"  style="display:none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								Falha no cadastro...
							</div>
							<div class="clearfix">
							</div>
						</form>
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