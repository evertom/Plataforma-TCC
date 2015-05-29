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
			
		});
	</script>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php require_once('pages/headerAdminAcessoNegado.php');?>
        </nav>
		<!-- Page Content -->
        <div id="row">
			<div class="col-xs-12">
			<br/>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					Para ter acesso total ao painel de Administra&ccedil;&atilde;o, voc&ecirc; precisa ter um grupo de TCC formado pelo orientador, caso ainda n&atilde;o tenha realizado uma requisi&ccedil;&atilde;o v&aacute; para p&aacute;gina principal e escolha seu orientador, caso j&aacute; tenha realizado uma requisi&ccedil;&atilde;o basta aguardar o professor aprovar ou n&atilde;o, no caso de reprovado, contate-o pessoalmente ou requisite outro professor.
				</div>
			</div>
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