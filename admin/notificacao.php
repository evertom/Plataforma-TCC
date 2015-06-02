<?php 
require_once('verifica-logado.php');
$id = isset($_GET['id']) ? $_GET['id']:"";
	
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
	<script>
		$(document).ready(function(){
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
					url: "ajax/insertProf.php",
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
                <!-- /.row -->
				 <div class="row">
                    <div class="col-xs-12">
                         <?php
							$result = $pdo->select("SELECT a.idavisos,a.descricao, DATE_FORMAT(a.data, '%d/%m/%Y') as data, u.username FROM avisos a INNER JOIN users u ON u.uid = a.de WHERE a.uid = ".$id_users." AND idavisos = ".$id."");
							
							if(count($result)){
								foreach($result as $res){
									echo '<p><h4>Enviado dia '.$res['data'].' por: <span class="text-danger">'.$res['username'].'</span></h4></p><br/>';
									echo '<p>'.$res['descricao'].'</p>';
								}
							}
						?>
                    </div>
                </div>		
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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