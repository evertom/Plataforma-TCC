<?php
	require_once('verifica-logado.php');	
	error_reporting(0);
	require_once 'includes/functions.php';
	require_once 'includes/tolink.php';
	require_once 'includes/time_stamp.php';
	
	$Wall = new Wall_Updates();
	
	date_default_timezone_set('America/Sao_Paulo');
	$atual = date('Y-m-d H:i:s');
	$expira = date('Y-m-d H:i:s', strtotime('+2 min'));
	
	$Wall->UpdateHora($atual,$expira,$_SESSION['id_login']);
?>

<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<title>Plataforma de Gerenciamento de TCC</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	 <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta http-equiv="pragma" content="no-cache" />
	
	<link rel="stylesheet" type="text/css" media="all" href="css/wall.css" />
	<script type="text/javascript" src="js/jquery.oembed.js"></script>
	<script type="text/javascript" src="js/wall.js"></script>

	<!-- >Chat Messenger<--->
	<link href="chat/css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="chat/js/jquery.js"></script>
	<script type="text/javascript" src="chat/js/functions.js"></script>
	<script type="text/javascript" src="chat/js/chat.js"></script>
	<!-- >Chat Messenger<--->
	
	<link rel="shortcut icon" href="favicon.ico"/>
	<script type="text/javascript">
		var pagina = 0;
		
		function carrega(){
			$('#loading').html("<img src='img/loader.gif'/> Carregando Feeds...").fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "loadAjax.php",
				data: "page="+pagina,
				cache: false,
				success: function(html){
					$('#loading').fadeOut('fast');
					$("#content").append(html);
				},
				error:function(html){
					$('#loading').html("erro...").fadeIn('fast');
				}
			});
		};
		
		$(document).ready(function(){
			
			/*var recursiva = function () {
				alert("Se passaram 1 segundo!");
				setTimeout(recursiva,8000);
			}
			recursiva();*/
			carrega();
		});
		
		$(window).scroll(function(){
			
			if($(window).scrollTop() + $(window).height() >= $(document).height()){
				pagina += 1;
				carrega();
			};
		});
		function rolar_para(elemento) {
		  $('html, body').animate({
			scrollTop: $(elemento).offset().top
		  }, 2000);
		}
                
		function loading_show(){
			$('#loading').html("<img src='images/loader.gif'/>").fadeIn('fast');
		};
		
		function loading_hide(){
			$('#loading').fadeOut('fast');
		};
                
		//evento para chamar o form dinamico
		$(function($){
			var painel = $("#painel");
			var close = $("#closePainel");
			var open = $(".openInsertForm");
			var div = $(".insertForm");
			
			
			//fecha painel clicando na seta
			$(close).click(function(){
				painel.hide({effect:'drop', duraiton: 1000, direction: 'rigth'});
			});	
			
			//Abrir painel e buscar dinamicamente
			$(open).click(function(){
				painel.show({effect:'drop', duraiton: 1000, direction: 'rigth'});
				var href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function( response ){
						var data = $(response);
						div.html(data).fadeIn(500);
					}
				});
			});	
		});
		
	$(function(){
		$('.destaque').hover(function(){
			//eleva a descri��o para cima
			$(this).find('p').stop().animate({top:'160px'},300);
		},
		function(){
			//volta a descri��o para baixo
			$(this).find('p').stop().animate({top:'200px'},300);
	   });
	   
	   $(".descricaoprof a").click(function(){
			var paragrafro = $(this).parents('#blocoprofessores').find('.descricaoP');
			
			if(paragrafro.is(":visible")){
				paragrafro.toggle("slow");
			}else{
				$('body').find('.descricaoP').each(function(){
				if($(this).is(":visible")){
					$(this).toggle("slow");
					}
				});
				paragrafro.toggle("slow");
			}
		});
		
		//fun��o para editar o post do feeds
		$('.EditarPostBt').live('click', function(){
			var div = $(this).parents('.stbody');
			var id = div.find('.comment_button').attr('id');
			
			var texto = div.find('.EditarPost').text();
			
			div.find('.EditarPost').html('<textarea style="width:100%;height:60px;"class="meuform postText">'+ $.trim(texto) +'</textarea><input class="btn btn-primary btn-sm btnEditaPost" type="button" value="Salvar"></input> <input class="btn btn-info btn-sm btnEditaPostCancela" type="button" value="Cancelar"></input>');
		});
		//funcao para cancelar a edicao do post no feeds, caso ele apague, e feito um busca no bd para trazer a msg correta
		$('.btnEditaPostCancela').live('click',function(){
			
			var div = $(this).parents('.stbody');
			var texto = div.find('.postText').val();
			var id = div.find('.comment_button').attr('id');
			
			if(texto === ''){
				loading_show();
				$.ajax({
					type: "POST",
					url: "ajax/cancelaPost.php",
					data: "id="+id,
					success: function(html){
						loading_hide();
						div.find('.EditarPost').html(html).fadeIn('fast');
					}
				});
				return false;
			}else{
				div.find('.EditarPost').html(texto).fadeIn('fast');
			}
		});
		//funcao para atulizar o post quando clica no botao salvar
		$('.btnEditaPost').live('click',function(){
			
			var div = $(this).parents('.stbody');
			var texto = div.find('.postText').val();
			texto = $.trim(texto);
			var id = div.find('.comment_button').attr('id');
			
			if(texto === ''){
				alert("Por favor digite seu Post !!!");
				div.find('.postText').focus();
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/updatePost.php",
					data: "texto="+texto+"&id="+id,
					success: function(html){
						div.find('.EditarPost').html(texto).fadeIn('fast');
					}
				});
				return false;
			}
		});
		
		//funcao para editar o comentario post do feeds
		$('.EditaComentPost').live('click', function(){
			var div = $(this).parents('.stcommenttext');
			var id = div.attr('id');
			var texto = div.find('.EditarComment').text();
			texto = $.trim(texto);
			
			div.find('.EditarComment').html('<textarea style="width:100%;height:60px;"class="meuform ComentarioText">'+ texto +'</textarea><input class="btn btn-primary btn-sm btnEditaComentario" type="button" value="Salvar"></input> <input class="btn btn-info btn-sm btnEditaComentarioCancela" type="button" value="Cancelar"></input><br/><br/>');
		});
		//funcao para cancelar a edicao do comentario post no feeds, caso ele apague, e feito um busca no bd para trazer a msg correta
		$('.btnEditaComentarioCancela').live('click',function(){
			
			var div = $(this).parents('.stcommenttext');
			var id = div.attr('id');
			var texto = div.find('.EditarComment').text();
			texto = $.trim(texto);
			
			if(texto === ''){
				loading_show();
				$.ajax({
					type: "POST",
					url: "ajax/cancelaComentario.php",
					data: "id="+id,
					success: function(html){
						loading_hide();
						div.find('.EditarComment').html(html).fadeIn('fast');
					}
				});
				return false;
			}else{
				div.find('.EditarComment').html(texto).fadeIn('fast');
			}
		});
		
		//funcao para atulizar o comentario do post quando clica no botao salvar
		$('.btnEditaComentario').live('click',function(){
			
			var div = $(this).parents('.stcommenttext');
			var id = div.attr('id');
			var texto = div.find('.ComentarioText').val();
			texto = $.trim(texto);
			
			if(texto === ''){
				alert("Por favor digite seu Coment\u00e1rio !!!");
				div.find('.ComentarioText').focus();
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/updateComentPost.php",
					data: "texto="+texto+"&id="+id,
					success: function(html){
						div.find('.EditarComment').html(texto).fadeIn('fast');
					}
				});
				return false;
			}
		});
		
		$('.like').live('click',function(){
			var div = $(this).parents('.stbody');
			var idmsg = div.find('.comment_button').attr('id');
			var iduser = <?php echo $id_users;?>;
			
			$.ajax({
				type: "POST",
				url: "ajax/like.php",
				data: "idmsg="+idmsg+"&iduser="+iduser,
				success: function(html){
					
					div.find('.likethis').html('<span class="badge">'+html+'</span>').fadeIn('fast');
					div.find('.like').removeClass('like').addClass('unlike');
					div.find('.unlike').html('<i class="fa fa-thumbs-o-down"></i> Descurtir');
				}
			});
			return false;
		});
		
		$('.unlike').live('click', function(){
			var div = $(this).parents('.stbody');
			var idmsg = div.find('.comment_button').attr('id');
			var iduser = <?php echo $id_users;?>;
			
			$.ajax({
				type: "POST",
				url: "ajax/like.php",
				data: "idmsg="+idmsg+"&iduser="+iduser,
				success: function(html){
					if(html === 0){
						div.find('.likethis').html('').fadeIn('fast');
						div.find('.unlike').removeClass('unlike').addClass('like');
						div.find('.like').html('<i class="fa fa-thumbs-o-up"></i> Curtir');
					}else{
						div.find('.likethis').html('<span class="badge">'+html+'</span>').fadeIn('fast');
						div.find('.unlike').removeClass('unlike').addClass('like');
						div.find('.like').html('<i class="fa fa-thumbs-o-up"></i> Curtir');
					}
				}
			});
			return false;
		});
	});
	</script>
</head>
    <body>
        <!-- Div para listar forms que adicionaram itens. --->
        <div id="painel"><div id="closePainel">X</div><div class="insertForm"></div></div>
        <!-- >Chat Messenger<--->
        <div style="position:absolute; top:0; right:0;" id="retorno"></div>
        <div id="janelas"></div>
        <!-- >Chat Messenger<--->
        <header>
            <div id="aligheader">
                <div id="logoif"></div>
                <div id="forumimg"></div>
                <div id="aligmenu">
                    <nav id="navigation">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="panel.php">TCC</a></li>
                            <li><a href="#">Arquivos</a></li>
                            <li><a href="" data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i> Sobre</a></li>
                            <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Informa&ccedil;&otilde;es sobre o F&oacute;rum</h4>
                                            </div>
                                            <div class="modal-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
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
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <section>
            <div id="conteudo">
                <!-- bloco do perfil -->
                    <div id="perfil" class="arredonda">
                        <div id="fotoperfil" class="destaque">
                            <img src="<?php echo $fotouser ?>"/>
                            <p><a onclick="return false;" href="addPhoto.php?id=<?php echo $id_users?>" title="Editar Foto" class="openInsertForm">Editar Foto...</p></a>
                        </div>
                        <div id="nomeperfil">
                            <?php echo $nome_user ?>
                        </div>
                        <hr/>
                        <nav>
                            <a href="userProfile.php?id=<?php echo $id_users;?>"><ul><i class="fa fa-user"></i> Perfil</ul></a>
                            <ul><i class="fa fa-gears"></i> Configura&ccedil;&otilde;es</ul>
                            <ul><i class="fa fa-book"></i> Publica&ccedil;&otilde;es</ul>
                            <a href="logout.php"><ul><i class="fa fa-sign-out"></i> Sair</ul></a>
                        </nav>
                        <br clear="all"/>
                        <?php include('chat/chat.php');?>
                    </div>
            <!-- final bloco do perfil -->
            <div id="feeds">
                <div id="wall_container">
                    <div id="updateboxarea">
                        <form method="post" id="formpost" action="">
                            <fieldset>
                                <legend>Em que est&aacute; pensando?</legend>
                                <textarea  class="meuform" name="update" id="update"></textarea><br />

                                <button type="submit" value="" id="update_button" class="update_button btn btn-primary">Postar <span class="glyphicon glyphicon-send"></span></button>
                            </fieldset>
                        </form>
                    </div>
                    <div id='flashmessage'>
                        <div id="flash" align="left"></div>
                    </div>

                    <div class="separador clr"><h3>Feeds</h3></div>
                    <div id="content"></div>
                    <div id='loading'></div>
                </div>
                <br clear="all"/>
            </div><!-- final bloco do feeds -->
            <aside>				
                <div id="sidebar" class="arredonda">
                    <div class="separador2 clr"><h3>Professores ADS</h3></div>

                    <?php 
                        require_once('includes/Conexao.class.php');

                        $pdo = new Conexao();

                        $result = $pdo->select("SELECT uid,username,email,fotouser,descricao,cargo FROM users WHERE tipo = 1 ORDER BY cargo,username ASC");

                        foreach($result as $res){
                    ?>
                    <div id="blocoprofessores">
                        <div id="fotoprof">
                                <img src="<?php echo $res['fotouser']?>" width="59px"/>
                        </div>
                        <div id="descricaoprof" class="descricaoprof">

                            <i class="fa fa-graduation-cap"></i><strong> <?php echo $res['cargo']?></strong><br/>
                            <?php echo $res['username']?><br/>
                            <i class="fa fa-angle-double-down"></i> <a>Leia Mais</a>

                            <div class="expansive-painel">
                                <div class="descricaoP">
                                    <p><i class="fa fa-envelope-o"></i> <?php echo $res['email']?></p>
                                    <p><?php echo $res['descricao']?></p>
                                    <p><a href="requerimentoProf.php?uid=<?php echo $res['uid'];?>&nome=<?php echo $res['username'];?>"><button type="button" class="btn btn-outline btn-success">Requisitar</button></a></p>
                                </div>
                            </div>
                        </div>
                        <br clear="all"/>
                        <br clear="all"/>
                    </div>
                    <?php
                        }
                    ?>
                    </div><!-- final bloco do aside professores -->
                </aside>
                <br clear="all"/>
            </div><!-- final bloco do conteudo -->
        </section>		
        <footer>
            <section>
                <div id="direitos">
                    Todos os Direitos reservados
                </div>
                <div id="ifroda">
                    <img src="img/if.png" width="200px"/>
                </div>
            </section>
        </footer>
    </body>
</html>