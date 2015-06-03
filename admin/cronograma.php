<?php
require_once('verifica-logado.php');
require_once('includes/Conexao.class.php');
date_default_timezone_set("America/Sao_Paulo");

$pdo = new Conexao();
$result = $pdo->select("SELECT idgrupo FROM grupo_has_users WHERE uid = $id_users ORDER BY idgrupo desc;");

if (count($result)) {
    foreach ($result as $res) {
        $idgrupo = $res['idgrupo'];
        $array_grupos = array('id' => $idgrupo);
    }
    $result = $pdo->select("SELECT idcronograma FROM cronograma WHERE idgrupo = $idgrupo");
    if (count($result)) {
        foreach ($result as $res) {
            $idcronograma = $res['idcronograma'];
        }
    } else {
        $idcronograma = null;
    }
} else {
    echo "<script type='text/javascript'>location.href='panel.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
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
			z-index: 99999!important;
			overflow-y: auto!important;
			background-color: #FFF!important;
			width: 100%!important;
			height:100%!important;
			top:0px!important;
			left:0px!important;
		}
	</style>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- MetisMenu CSS -->
    <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
	
	<!-- Jquery -->
	<script src="js/jquery-2.1.3.js"></script>
	
    <!-- Custom CSS -->
    <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- FullCallender -->
    <link href="fullcalendar-2.3.1/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
	<script src="fullcalendar-2.3.1/lib/moment.min.js"></script>
	<script src="fullcalendar-2.3.1/fullcalendar.min.js"></script>
	<script src="fullcalendar-2.3.1/lang-all.js"></script>
		
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	
	<!-- select bootstrap -->
	<link href="js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
	<script src="js/bootstrap-select/js/bootstrap-select.min.js"></script>
	
	<!-- bootstrap-switch-master -->
	<link href="js/bootstrap-switch-master/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<script src="js/bootstrap-switch-master/js/bootstrap-switch.min.js"></script>
	
	

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
	
	<script>
		
		$(document).ready(function(){
			
			var myID = $("#myID").val();
			
			var IDGRUPO = $("#idgrupo").val();
		
			var BDEVENTOS = {
				url:'pages/cronograma_eventos/get-events.php',
				method:'GET',
				data: {idcronograma: IDGRUPO}
			};
			
			$("[name='isClonclusion']").bootstrapSwitch('state', false);
			
			$('#idTipoEvento').on('change', function(){
				if ($(this).val() == 2){
					$("#opcionalHorario").fadeIn(550);
					$("#opcionalData").fadeOut(550);
					$("#allday").val("false");
				}else{
					$("#opcionalHorario").fadeOut(550);
					$("#opcionalData").fadeIn(550);
					$("#allday").val("true");
				}
			});
			
			$('#select-idgrupo').on('change', function(){
				var id = $(this).val();
				if(id !== null){
					IDGRUPO = id;
					$("#idGrupo").val(id);
					$('.calender').fullCalendar('removeEventSource', BDEVENTOS);
					$('.calender').fullCalendar('addEventSource',BDEVENTOS);
				}else{
					reset();
					IDGRUPO = "";
					$("#idGrupo").val("");
					$('.calender').fullCalendar('removeEventSource', BDEVENTOS);
				}
			});
			
			//Aqui declaração do calender
			$('.calender').fullCalendar({
				defaultView: 'agendaWeek',
				lang: "pt-br",
				timezone: true,
				timezoneParam: 'America/Sao_Paulo',
				minTime: '08:00:00',
				maxTime: '23:59:59',
				eventSources: BDEVENTOS,
				eventClick: function(calEvent, jsEvent, view) {
					if($(".panel").hasClass("foo")){
						$(".panel").removeClass("foo");
					}
					reset();
					var start = moment(calEvent.start, "YYYY-MM-DD");
					var end = moment(calEvent.end, "YYYY-MM-DD");
					var participantes = calEvent.participantes;
					var array_participantes = participantes.split(",");
					var concluido = false;
					if(calEvent.concluido == 1){concluido = true;}
					for(var i = 0; i < array_participantes.length; i++){
						if(array_participantes[i] == myID){
							if(!$("#concluido").is(":visible")){
								$("#concluido").fadeIn(250);
							}
							if(!$("#delete").is(":visible")){
								$("#delete").fadeIn(250);
							}
						}
					}
					$("#idParticipantes").selectpicker('val', array_participantes);
					$("#idTipoEvento").selectpicker('val', calEvent.idTipoEvento);
					$(".selectpicker").selectpicker('refresh');
					
					if ($("#idTipoEvento").val() == 2){
						if(!$("#opcionalHorario").is(":visible"))$("#opcionalHorario").fadeIn(550);
						if($("#opcionalData").is(":visible"))$("#opcionalData").fadeOut(550);
						$("#horario").val(start.format("HH:mm"));
					}else{
						if($("#opcionalHorario").is(":visible"))$("#opcionalHorario").fadeOut(550);
						if(!$("#opcionalData").is(":visible"))$("#opcionalData").fadeIn(550);
						$("#horario").val("");
					}
					$("#dataInicial").val(start.format("YYYY-MM-DD"));
					$("#dataFinal").val(end.format("YYYY-MM-DD"));
					$("#allday").val(calEvent.allDay);
					$("#idgrupo").val(calEvent.idGrupo);
					$("#nomeEvento").val(calEvent.nomeEvento);
					$("#descricao").val(calEvent.descricao);
					$("#idcronograma").val(calEvent.idcronograma);
					$("#idevento").val(calEvent.idEvento);
					$("#isClonclusion").bootstrapSwitch('state', concluido);
				}
			});
			
			$(".fa.fa-expand").click(function(){
				if(!$(".panel").hasClass('foo')){
					$(".panel").addClass("foo");
				}
			});
			
			$(".fa.fa-minus-square").click(function(){
				if($(".panel").hasClass('foo')){
					$(".panel").removeClass("foo");
				}
			});
			
			$("#reset").click(function(){
				reset();
			});
			
			$("#delete").click(function(){
				Delete();
			});
			
			$("#cronograma").submit(function(){
				
				var start = $("#dataInicial").val();
				var end = $("#dataFinal").val();
				var allday = $("#allday").val();
				var idGrupo = $("#idgrupo").val();
				var participantes = $("#idParticipantes").val();
				var nomeEvento = $("#nomeEvento").val();
				var descricao = $("#descricao").val();
				var idCronograma = $("#idcronograma").val();
				var idEvento = $("#idevento").val();
				var idTipoEvento = $("#idTipoEvento").val();
				var isClonclusion = $("#isClonclusion").bootstrapSwitch('state');
				
				//pegamos todos os valores do form
				if($("#allday").val() == "false"){
					start = new moment(start+" "+ $("#horario").val(), "YYYY/MM/DD HH:mm");
					end = new moment(start, "YYYY/MM/DD HH:mm");
					end.set('hours', start.hours()+1);
				}else{
					start = moment(start + "00:00","YYYY/MM/DD HH:mm" );
					end = moment(end + " 00:00", "YYYY/MM/DD HH:mm" );
					if(end.unix() < start.unix()){
						alert("A data inicial não pode ser menor que a data final");
						return false;
					}
				}
					
				start = start.format("YYYY/MM/DD HH:mm");
				end = end.format("YYYY/MM/DD HH:mm");
				
				if(idEvento == ""){
					var valores = "operation=CRUD&case=INSERT";
				}else{
					var valores = "operation=CRUD&case=UPDATE";
				}
				
				valores += "&start="+start;
				valores += "&end="+end;
				valores += "&allday="+allday;
				valores += "&idGrupo="+idGrupo;
				valores += "&participantes="+participantes;
				valores += "&nomeEvento="+nomeEvento;
				valores += "&descricao="+descricao;
				valores += "&idCronograma="+idCronograma;
				valores += "&idEvento="+idEvento;
				valores += "&idTipoEvento="+idTipoEvento;
				valores += "&isClonclusion="+isClonclusion;
				
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
				
				if(ok == true){
					$('.alert-success').fadeIn('fast');
					reset();
				}else{
					$('.alert-danger').fadeIn('fast');
				}
				
				$(".calender").fullCalendar('refetchEvents');
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
		
		//Function para Deletar
		function Delete(){
			
			var idEvento = $("#idevento").val();
                        var idGrupo = $("#idgrupo").val();
                        
			if(idEvento != "" && idEvento != null){
				var valores = "operation=CRUD&case=DELETE";
				valores += "&idEvento="+idEvento;
                                valores += "&idGrupo="+idGrupo;
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
				
				if(ok == true){
					$('.alert-success').fadeIn('fast');
					reset();
				}else{
					$('.alert-danger').fadeIn('fast');
				}
				$(".calender").fullCalendar('refetchEvents');
				return ok;
			}else{
				return false;
			}	
		}
		
		function reset(){
			var hoje = moment().format("YYYY-MM-DD");			
			$("#dataInicial").val(hoje);
			$("#dataFinal").val(hoje);
			$("#horario").val("");
			$("#idTipoEvento").val("");
			$("#idParticipantes").selectpicker('deselectAll');
			$("#idParticipantes").selectpicker('val','');
			$(".selectpicker").selectpicker('refresh');
			$(".selectpicker").selectpicker('render');
			$("#nomeEvento").val("");
			$("#descricao").val("");
			$("#idevento").val("");
			$("#isClonclusion").bootstrapSwitch('state', false);
			if($("#concluido").is(":visible")){$("#concluido").fadeOut(250);}
			if($("#delete").is(":visible")){$("#delete").fadeOut(250);}
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
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <h1 class="page-header">Cronograma <small class="text-danger"><?php echo $nome_user?></small></h1>
=======
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Admin</title>
        <style>
            .foo{
                position: fixed!important;
                z-index: 99999!important;
                overflow-y: auto!important;
                background-color: #FFF!important;
                width: 100%!important;
                height:100%!important;
                top:0px!important;
                left:0px!important;
            }
        </style>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

        <!-- Jquery -->
        <script src="js/jquery-2.1.3.js"></script>

        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- FullCallender -->
        <link href="fullcalendar-2.3.1/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
        <script src="fullcalendar-2.3.1/lib/moment.min.js"></script>
        <script src="fullcalendar-2.3.1/fullcalendar.min.js"></script>
        <script src="fullcalendar-2.3.1/lang-all.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>

        <!-- select bootstrap -->
        <link href="js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-select/js/bootstrap-select.min.js"></script>

        <!-- bootstrap-switch-master -->
        <link href="js/bootstrap-switch-master/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-switch-master/js/bootstrap-switch.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            $(document).ready(function () {

                var myID = $("#myID").val();
                var IDGRUPO = $("#idgrupo").val();

                var BDEVENTOS = {
                    url: 'pages/cronograma_eventos/get-events.php',
                    method: 'GET',
                    data: {idcronograma: IDGRUPO}
                };

                $("[name='isClonclusion']").bootstrapSwitch('state', false);

                $('#idTipoEvento').on('change', function () {
                    if ($(this).val() == 2) {
                        $("#opcionalHorario").fadeIn(550);
                        $("#opcionalData").fadeOut(550);
                        $("#allday").val("false");
                    } else {
                        $("#opcionalHorario").fadeOut(550);
                        $("#opcionalData").fadeIn(550);
                        $("#allday").val("true");
                    }
                });

                $('#select-idgrupo').on('change', function () {
                    var id = $(this).val();
                    if (id !== null) {
                        IDGRUPO = id;
                        $("#idGrupo").val(id);
                        $('.calender').fullCalendar('removeEventSource', BDEVENTOS);
                        $('.calender').fullCalendar('addEventSource', BDEVENTOS);
                    } else {
                        reset();
                        IDGRUPO = "";
                        $("#idGrupo").val("");
                        $('.calender').fullCalendar('removeEventSource', BDEVENTOS);
                    }
                });

                //Aqui declaração do calender
                $('.calender').fullCalendar({
                    defaultView: 'agendaWeek',
                    lang: "pt-br",
                    timezone: true,
                    timezoneParam: 'America/Sao_Paulo',
                    minTime: '08:00:00',
                    maxTime: '23:59:59',
                    eventSources: BDEVENTOS,
                    eventClick: function (calEvent, jsEvent, view) {
                        if ($(".panel").hasClass("foo")) {
                            $(".panel").removeClass("foo");
                        }
                        reset();
                        var start = moment(calEvent.start, "YYYY-MM-DD");
                        var end = moment(calEvent.end, "YYYY-MM-DD");
                        var participantes = calEvent.participantes;
                        var array_participantes = participantes.split(",");
                        var concluido = false;
                        if (calEvent.concluido == 1) {
                            concluido = true;
                        }
                        for (var i = 0; i < array_participantes.length; i++) {
                            if (array_participantes[i] == myID) {
                                if (!$("#concluido").is(":visible")) {
                                    $("#concluido").fadeIn(250);
                                }
                                if (!$("#delete").is(":visible")) {
                                    $("#delete").fadeIn(250);
                                }
                            }
                        }
                        $("#idParticipantes").selectpicker('val', array_participantes);
                        $("#idTipoEvento").selectpicker('val', calEvent.idTipoEvento);
                        $(".selectpicker").selectpicker('refresh');

                        if ($("#idTipoEvento").val() == 2) {
                            if (!$("#opcionalHorario").is(":visible"))
                                $("#opcionalHorario").fadeIn(550);
                            if ($("#opcionalData").is(":visible"))
                                $("#opcionalData").fadeOut(550);
                            $("#horario").val(start.format("HH:mm"));
                        } else {
                            if ($("#opcionalHorario").is(":visible"))
                                $("#opcionalHorario").fadeOut(550);
                            if (!$("#opcionalData").is(":visible"))
                                $("#opcionalData").fadeIn(550);
                            $("#horario").val("");
                        }
                        $("#dataInicial").val(start.format("YYYY-MM-DD"));
                        $("#dataFinal").val(end.format("YYYY-MM-DD"));
                        $("#allday").val(calEvent.allDay);
                        $("#idgrupo").val(calEvent.idGrupo);
                        $("#nomeEvento").val(calEvent.nomeEvento);
                        $("#descricao").val(calEvent.descricao);
                        $("#idcronograma").val(calEvent.idcronograma);
                        $("#idevento").val(calEvent.idEvento);
                        $("#isClonclusion").bootstrapSwitch('state', concluido);
                    }
                });

                $(".fa.fa-expand").click(function () {
                    if (!$(".panel").hasClass('foo')) {
                        $(".panel").addClass("foo");
                    }
                });

                $(".fa.fa-minus-square").click(function () {
                    if ($(".panel").hasClass('foo')) {
                        $(".panel").removeClass("foo");
                    }
                });

                $("#reset").click(function () {
                    reset();
                });

                $("#delete").click(function () {
                    Delete();
                });

                $("#cronograma").submit(function () {

                    var start = $("#dataInicial").val();
                    var end = $("#dataFinal").val();
                    var allday = $("#allday").val();
                    var idGrupo = $("#idgrupo").val();
                    var participantes = $("#idParticipantes").val();
                    var nomeEvento = $("#nomeEvento").val();
                    var descricao = $("#descricao").val();
                    var idCronograma = $("#idcronograma").val();
                    var idEvento = $("#idevento").val();
                    var idTipoEvento = $("#idTipoEvento").val();
                    var isClonclusion = $("#isClonclusion").bootstrapSwitch('state');

                    //pegamos todos os valores do form
                    if ($("#allday").val() == "false") {
                        start = new moment(start + " " + $("#horario").val(), "YYYY/MM/DD HH:mm");
                        end = new moment(start, "YYYY/MM/DD HH:mm");
                        end.set('hours', start.hours() + 1);
                    } else {
                        start = moment(start + "00:00", "YYYY/MM/DD HH:mm");
                        end = moment(end + " 00:00", "YYYY/MM/DD HH:mm");
                        if (end.unix() < start.unix()) {
                            alert("A data inicial não pode ser menor que a data final");
                            return false;
                        }
                    }

                    start = start.format("YYYY/MM/DD HH:mm");
                    end = end.format("YYYY/MM/DD HH:mm");

                    if (idEvento == "") {
                        var valores = "operation=CRUD&case=INSERT";
                    } else {
                        var valores = "operation=CRUD&case=UPDATE";
                    }

                    valores += "&start=" + start;
                    valores += "&end=" + end;
                    valores += "&allday=" + allday;
                    valores += "&idGrupo=" + idGrupo;
                    valores += "&participantes=" + participantes;
                    valores += "&nomeEvento=" + nomeEvento;
                    valores += "&descricao=" + descricao;
                    valores += "&idCronograma=" + idCronograma;
                    valores += "&idEvento=" + idEvento;
                    valores += "&idTipoEvento=" + idTipoEvento;
                    valores += "&isClonclusion=" + isClonclusion;

                    var ok = false;

                    $.ajax
                    ({
                        async: false,
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/control_cronograma.php",
                        beforeSend: function () {
                            loading_show();
                        },
                        data: valores,
                        success: function (data)
                        {
                            ok = data.msg;
                        },
                        error: function (data) {
                            $('.alert-danger').fadeIn('fast');
                            console.log(data);
                            ok = false;
                        },
                        complete: function () {
                            loading_hide();
                            return ok;
                        }
                    });

                    if (ok == true) {
                        $('.alert-success').fadeIn('fast');
                        reset();
                    } else {
                        $('.alert-danger').fadeIn('fast');
                    }

                    $(".calender").fullCalendar('refetchEvents');
                    return false;
                });
            });
            function loading_show() {
                $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
            }
            function loading_hide() {
                $('#loading').fadeOut('fast');
            }
            
            //Submeter formulario de mensagens
            function sendMsg() {

                var idgrupo = $('#idgrupo').val();
                var msg = $('#analises').val();
                var myID = $("#myID").val();

                var valores = "operation=MSG";
                valores += "&idgrupo=" + idgrupo;
                valores += "&msg=" + msg;
                valores += "&myID=" + myID;

                if (msg == "" || msg == null) {
                    return false;
                }

                var ok = false;

                $.ajax
                ({
                    async: false,
                    type: "POST", //metodo POST
                    dataType: 'json',
                    url: "ajax/control_cronograma.php",
                    beforeSend: function () {
                        loading_show();
                    },
                    data: valores,
                    success: function (data)
                    {
                        ok = data.msg;
                        $('#analises').val("");
                        $('.alert-success').fadeIn('fast');
                        $('body').scrollTop(100, 'slow');
                    },
                    error: function (data) {
                        $('.alert-danger').fadeIn('fast');
                        console.log(data);
                        ok = false;
                    },
                    complete: function () {
                        loading_hide();
                        return ok;
                    }
                });

            }

            //Function para Deletar
            function Delete() {

                var idEvento = $("#idevento").val();
                if (idEvento != "" && idEvento != null) {
                    var valores = "operation=CRUD&case=DELETE";
                    valores += "&idEvento=" + idEvento;
                    var ok = false;
                    $.ajax
                    ({
                        async: false,
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/control_cronograma.php",
                        beforeSend: function () {
                            loading_show();
                        },
                        data: valores,
                        success: function (data)
                        {
                            ok = data.msg;
                        },
                        error: function (data) {
                            $('.alert-danger').fadeIn('fast');
                            console.log(data);
                            ok = false;
                        },
                        complete: function () {
                            loading_hide();
                            return ok;
                        }
                    });

                    if (ok == true) {
                        $('.alert-success').fadeIn('fast');
                        reset();
                    } else {
                        $('.alert-danger').fadeIn('fast');
                    }
                    $(".calender").fullCalendar('refetchEvents');
                    return ok;
                } else {
                    return false;
                }
            }

            function reset() {
                var hoje = moment().format("YYYY-MM-DD");
                $("#dataInicial").val(hoje);
                $("#dataFinal").val(hoje);
                $("#horario").val("");
                $("#idTipoEvento").val("");
                $("#idParticipantes").selectpicker('deselectAll');
                $("#idParticipantes").selectpicker('val', '');
                $(".selectpicker").selectpicker('refresh');
                $(".selectpicker").selectpicker('render');
                $("#nomeEvento").val("");
                $("#descricao").val("");
                $("#idevento").val("");
                $("#isClonclusion").bootstrapSwitch('state', false);
                if ($("#concluido").is(":visible")) {
                    $("#concluido").fadeOut(250);
                }
                if ($("#delete").is(":visible")) {
                    $("#delete").fadeOut(250);
                }
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
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <h1 class="page-header">Cronograma <small class="text-danger"><?php echo $nome_user ?></small></h1>
                        </div>
>>>>>>> origin/master
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
                            if ($tipo_users > 0) {
                                echo '<div class="form-group input-group">'
                                        . '<select name="select-idgrupo" id="select-idgrupo" '
                                        . 'class="selectpicker" multiple  data-max-options="1" data-min-options="1" '
                                        . 'required data-style="btn-warning" title="Selecione o grupo de trabalho?" '
                                        . 'data-live-search="true" >';

                                $pdo = new Conexao();
                                echo "<optgroup label='Grupos - Títulos'>";

                                foreach ($array_grupos as $id) {
                                    $result = $pdo->select("SELECT idgrupo, titulo "
                                            . "FROM grupo WHERE idgrupo = $id ORDER BY titulo");
                                    foreach ($result as $res) {
                                        if ($idgrupo == $res['idgrupo']) {
                                            echo "<option selected value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        } else {
                                            echo "<option value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        }
                                    }
                                }
                                echo "</optgroup></select></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <form id="cronograma">
                                <div class="form-group input-group">
                                    <select name="idTipoEvento" id="idTipoEvento" class="selectpicker" multiple  data-max-options="1" data-min-options="1" required data-style="btn-info" title='Qual é o tipo de evento?' data-live-search="true" >
                                    <?php
                                    $pdo = new Conexao();
                                    $result = $pdo->select("SELECT * FROM tipoevento ORDER BY nome");

                                    echo "<optgroup label='Opções'>";

                                    foreach ($result as $res) {
                                        if ($res['nome'] == "Outros") {
                                            $outros = "<optgroup label='Está sem opções?'><option value='" . $res['id'] . "'>" . $res['nome'] . "</option></optgroup>";
                                        } else {
                                            echo "<option value='" . $res['id'] . "'>" . $res['nome'] . "</option>";
                                        }
                                    }
                                    echo "</optgroup>" . $outros;
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <select name="idParticipantes[]" id="idParticipantes" class="selectpicker" multiple  data-max-options="5" data-min-options="1" required data-style="btn-info" title='De quem é a tarefa?' data-live-search="true" data-selected-text-format="count>2" >
                                    <?php
                                    $pdo = new Conexao();
                                    $sql = "SELECT b.uid, b.username FROM grupo_has_users a ";
                                    $sql .= "INNER JOIN users b ON a.uid = b.uid "
                                            . " WHERE a.idgrupo = $idgrupo ORDER BY b.username";

                                    $result = $pdo->select($sql);

                                    echo "<optgroup label='Participantes'>";

                                    foreach ($result as $res) {
                                        echo "<option value='" . $res['uid'] . "'>" . $res['username'] . "</option>";
                                    }
                                    echo "</optgroup>";
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
                                    <input class="form-control" id="nomeEvento" name="nomeEvento" type="text"  placeholder="Nome do evento" value="" required></input>
                                </div>
                                <small>Data Inicial</small>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                    <input class="form-control" id="dataInicial" name="dataInicial" type="date"  max="<?php echo date('Y-m-d', strtotime("+2 years")); ?>" min="<?php echo date('Y-m-d', strtotime("-2 years")); ?>" value="<?php echo date('Y-m-d'); ?>" required></input>
                                </div>
                                <div id="opcionalData">
                                    <small>Data Final</small>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                        <input class="form-control" id="dataFinal" name="dataFinal" type="date"  value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d', strtotime("-2 years")); ?>" max="<?php echo date('Y-m-d', strtotime("+2 years")); ?>"></input>
                                    </div>
                                </div>
                                <div id="opcionalHorario" style="display:none;">
                                    <small>Horário</small>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input class="form-control" id="horario" name="horario" type="time"  value="" min="08:00" max="23:59"></input>
                                    </div>
                                </div>
                                <div class="form-group input-group">
                                    <small>Descrição</small>
                                    <textarea style="resize: none;" class="form-control" id="descricao" name="descricao" rows="8" cols="40" placeholder="Descri&ccedil;&atilde;o" required></textarea>
                                </div>
                                <div id="concluido" style="display:none;">
                                    <div class="form-group input-group">
                                        <small>Concluído</small>
                                        <p>
                                            <input data-on-color="success" data-off-color="danger" data-size="normal" id="isClonclusion" name="isClonclusion" type="checkbox" data-off-text="Não" data-on-text="Sim"/>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group input-group pull-right">
                                    <input id="myID" name="myID" type="hidden" value="<?php echo $id_users; ?>"></input>
                                    <input id="idevento" name="idevento" type="hidden" value=""></input>
                                    <input id="idgrupo" name="idgrupo" type="hidden" value="<?php echo $idgrupo; ?>"></input>
                                    <input id="idcronograma" name="idcronograma" type="hidden" value="<?php echo $idcronograma; ?>"></input>
                                    <input id="allday" name="allday" type="hidden" value="true"></input>
                                    <button style="margin-left: 10px" class="btn btn-primary" type="submit">Enviar <i class="fa fa-share-square"></i></button>
                                    <button style="margin-left: 10px; display: none;" class="btn btn-danger" id="delete" type="button">Deletar <i class="fa fa-times-circle"></i></button>
                                    <button style="margin-left: 10px" class="btn btn-warning" id="reset" type="button">Limpar <i class="fa fa-eraser"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Cronograma <div style="width: 35px;height: auto;position: relative; right: 0px;float: right;"><i style="cursor: pointer;" class="fa fa-minus-square"></i>      <i style="cursor: pointer;" class="fa fa-expand"></i></div></div>
                                <div class="panel-body">
                                    <div class="calender"></div>
                                    <br/>
                                <?php
                                if ($idcronograma > 0 && $tipo_users == 1) {
                                    echo "<form id='respostaCrono'>"
                                            . "<div style='margin: 0px auto; width: 100%;'>"
                                                . "<div class='form-group input-group' style='width: 100%;'>"
                                                    . " <h2>Mensagem <small>Observações sobre o cronograma</small></h2>"
                                                    . "<textarea style='resize: none;' class='form-control' id='analises' name='analises' rows='4' cols='100' placeholder='Descri&ccedil;&atilde;o' required></textarea>"
                                                . "</div>"
                                                . "<div class='form-group input-group'>"
                                                    . "<button onclick='sendMsg();' style='margin-left: 10px' class='btn btn-primary' type='button'>Enviar <i class='fa fa-share-square'></i></button>"
                                                . "<button style='margin-left: 10px' class='btn btn-warning' id='resalvas' type='reset'>Limpar <i class='fa fa-eraser'></i></button>"
                                                . "</div>"
                                            . "</div>"
                                        . "</form>";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <!-- /.row -->
                <div class="row"></div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
    </body>
</html>