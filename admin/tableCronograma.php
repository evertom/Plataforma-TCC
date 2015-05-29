<?php 
	require_once('verifica-logado.php');
	require_once('includes/Conexao.class.php');
	date_default_timezone_set("America/Sao_Paulo");
	
	$pdo = new Conexao();
	$result = $pdo->select("SELECT idgrupo FROM grupo_has_users WHERE uid = $id_users ORDER BY idgrupo desc;");
	
	if(count($result)){
		foreach($result as $res){
			$idgrupo = $res['idgrupo'];
			$array_grupos = array('id' => $idgrupo);
		}
		$result = $pdo->select("SELECT idcronograma FROM cronograma WHERE idgrupo = $idgrupo");
		if(count($result)){
			foreach($result as $res){
				$idcronograma = $res['idcronograma'];
			}
		}else{
			$idcronograma = null;
		}
	}else{
		echo  "<script type='text/javascript'>location.href='panel.php'</script>";
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
	<style>
		.foo{
			position: fixed!important;
			overflow-y: auto!important;
			z-index: 99999!important;
			background-color: #FFF!important;
			width: 100%!important;
			height:100%!important;
			top:0px!important;
			left:0px!important;
		}
	</style>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- Jquery -->
	<script src="js/jquery-2.1.3.js"></script>
	<!-- Jquery ui API-->
	<script src="js/jquery-ui.min.js"></script>
	
    
	<!-- Custom CSS -->
    <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Moment -->
    <script src="fullcalendar-2.3.1/lib/moment.min.js"></script>
	
	<!-- Tables -->
	 <link href="css/tables/jquery.dataTables.min.css" rel="stylesheet">
	 <link href="css/tables/jquery.dataTables_themeroller.css" rel="stylesheet">
	<script src="js/jquery.dataTables.min.js"></script>
			
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	
	<!-- select bootstrap -->
	<link href="js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="js/bootstrap-select/js/bootstrap-select.min.js"></script>
	
	<!-- bootstrap-switch-master -->
	<link href="js/bootstrap-switch-master/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
	<script src="js/bootstrap-switch-master/js/bootstrap-switch.min.js"></script>
	
	

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
	
	<script>
		
		$(function(){
			$( "#information").draggable();
		 });
		
		$(document).ready(function(){
			
			var IDGRUPO = $("#idgrupo").val();
			
			Load(IDGRUPO);
			
			$(".fa.fa-expand").click(function(){
				if(!$(".table-panel").hasClass('foo')){
					$(".table-panel").addClass("foo");
				}
			});
			
			$(".fa.fa-minus-square").click(function(){
				if($(".table-panel").hasClass('foo')){
					$(".table-panel").removeClass("foo");
				}
			});
			
			$(".fa.fa-times-circle").on('click', function(){
				$("#information").fadeOut(150);
			});
			
			$('#select-idgrupo').on('change', function(){
				var id = $(this).val();
				if(id !== null){
					var idO;
					for(var i = 0; i < id.length; i++){
						idO = id[i];
					}
					IDGRUPO = idO;
				}else{
					IDGRUPO = "";
				}
				$("#idgrupo").val(idO);
				Load(idO);
			});
		});
		
		function SetUpdates(checked, del, id, IDGRUPO){
			$.ajax
			({
				async: false,
				type: "POST", //metodo POST
				dataType: 'json',
				url: "ajax/control_cronograma.php",
				data: {operation: "UpdateTable", idEvento:id, Checked : checked, Delete: del},
				success: function(data)
				{
					if(data.msg == true){
						if(del == true){
							$('.alert-success').fadeIn('fast');
							Load(IDGRUPO);
						}
						return true;
					}else{
						$('.alert-danger').fadeIn('fast');
						return false;
					}
				},
				error: function(data){
					$('.alert-danger').fadeIn('fast');
					console.log(data);
					return false;
				}
			});
		}
		
		function GetInfo(id){
			$.ajax
			({
				async: false,
				type: "POST", //metodo POST
				dataType: 'html',
				url: "ajax/control_cronograma.php",
				data: {operation: "GetInfo", idEvento:id},
				success: function(data)
				{
					$("#information").css({"top" : window.height/2,"left":(window.width/2)-250});
					$("#information").fadeIn(100);
					$("#info-panel").html(data).fadeIn(150);
					return false;
				},
				error: function(data){
					console.log(data);
					$("#information").css({"top" : window.height/2,"left":window.width/2});
					$("#information").fadeIn(100);
					$("#info-panel").html(data).fadeIn(150);
					return false;
				}
			});
		}
		
		
		function Load(id){
			$.ajax
			({
				async: false,
				type: "POST", //metodo POST
				dataType: 'html',
				url: "ajax/control_cronograma.php",
				data: {operation: "dataTable", idGrupo:id},
				success: function(data)
				{
					$(".table-responsive").html(data).fadeIn(100);
				},
				error: function(data){
					$('.alert-danger').fadeIn('fast');
					console.log(data);
						$(".table-responsive").html(data).fadeIn(100);
				}
			});
			$(".table").DataTable({
				"language": {
					"url": "ajax/portuguesTable.json"
				}
			});
			
			$("[name='isClonclusion']").bootstrapSwitch();
		}
		
		
		//Submeter formulario de mensagens
		function sendMsg(){
		
			var idgrupo = $('#idgrupo').val();
			var msg = $('#analises').val();
			var myID = $("#myID").val();
			
			var valores = "operation=MSG";
			valores += "&idgrupo="+idgrupo;
			valores += "&msg="+msg;
			valores += "&myID="+myID;
			
			if(msg == "" || msg == null){
				return false;
			}
			
			var ok = false;
			
			$.ajax
			({
				async: false,
				type: "POST", //metodo POST
				dataType: 'json',
				url: "ajax/control_cronograma.php",
				beforeSend: function(){
					loading_show();
				},
				data: valores,
				success: function(data)
				{
					ok = data.msg;
					$('#analises').val("");
					$('.alert-success').fadeIn('fast');
					$('body').scrollTop(100, 'slow');
				},
				error: function(data){
					$('.alert-danger').fadeIn('fast');
					console.log(data);
					ok = false;
				},
				complete: function(){
					loading_hide();
					return ok;
				}
			});
			
		}
		
		//função para mostrar o loading
		function loading_show(){
			$('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
		}
		//função para esconder o loading
		function loading_hide(){
			$('#loading').fadeOut('fast');
		}
	</script>
</head>
<body>
	<input id="idgrupo" name="idgrupo" type="hidden" value="<?php echo $idgrupo;?>"></input>
	<input id="myID" name="myID" type="hidden" value="<?php echo $id_users;?>"></input>
	
	<!-- Aqui div para exibir mais informçaões><--->
	<div style="display:none; width: 500px; position: fixed;z-index: 9999999;" id="information">
		<div class="panel panel-info">
			<div class="panel-heading">Mais Informações <div style="width: 35px;height: auto;position: relative; right: 0px;float: right;"><i style="cursor: pointer;" class="fa fa-times-circle"></i></div></div>
				<div class="panel-body" id="info-panel">
				</div>
		</div>
	</div>
	
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
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <h1 class="page-header">Cronograma <small class="text-danger"><?php echo $nome_user?></small></h1>
                    </div>
				</div>
				<div class="row">
					<div class="col-xs-8 col-md-8 col-sm-8" >
						<div id="loading"></div>
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
					<div class="col-xs-4 col-sm-4 col-md-4">
						<?php 
							if($tipo_users > 0){
							echo	'<div class="form-group input-group">
										<select name="select-idgrupo" id="select-idgrupo" class="selectpicker" multiple  data-max-options="1" data-min-options="1" required data-style="btn-warning"
										title="Selecione o grupo de trabalho?" data-live-search="true" >';
										
										
											$pdo = new Conexao();
											echo "<optgroup label='Grupos - Títulos'>"; 
											
											foreach($array_grupos as $id){
												$result = $pdo->select("SELECT idgrupo, titulo FROM grupo WHERE idgrupo = $id ORDER BY titulo");
												foreach($result as $res){
													if($idgrupo == $res['idgrupo']){
														echo "<option selected value='".$res['idgrupo']."'>".$res['titulo']."</option>";
													}else{
														echo "<option value='".$res['idgrupo']."'>".$res['titulo']."</option>";
													}
													
												}
											}
											echo "</optgroup></select></div>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="panel panel-primary table-panel">
							<div class="panel-heading">Tabela Cronograma <div style="width: 35px;height: auto;position: relative; right: 0px;float: right;"><i style="cursor: pointer;" class="fa fa-minus-square"></i>      <i style="cursor: pointer;" class="fa fa-expand"></i></div></div>
								<div class="panel-body">
									<div class="table-responsive">
									
									</div>
								</div>
						</div>
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