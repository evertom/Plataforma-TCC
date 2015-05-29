<?php
session_start();
ob_start();
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<title>Plataforma de Gerenciamento de TCC</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<script language="JavaScript" src="js/jquery-2.1.1.js"></script>
	<link rel="shortcut icon" href="favicon.ico"/>
	
	<script>
		//Aqui inicio do código Jquery
		$(document).ready(function(){
			var $divShow = $('#showCad');	
			var $divShow2 = $('#showCad2');	
			var $divClick = $('#cadastro');
			var $divClick2 = $('#lembrarSenha');
		
		//bloco para cadastro
			$divClick.click(function(){
				$('body').css('overflow','hidden');
				$('body').css('display','block');
					$divShow.toggle('slow', function(){		
					});
			});
			
			$('#botaoFechar').click(function(){
				$('#showCad').fadeOut(500,function(){
					$('body').css('overflow','auto');
				});
			});
		//bloca para lembra senha	
			$divClick2.click(function(){
				$('body').css('overflow','hidden');
				$('body').css('display','block');
				
					$divShow2.toggle('slow', function(){	
					});
			});
			
			$('#botaoFechar2').click(function(){
				$('#showCad2').fadeOut(500,function(){
					$('body').css('overflow','auto');
				});
			});
		});
	</script>
</head>
	<body>
		<article>
			<div id="logo">
				<img src="img/if.png"/>
			</div>
			<form name="form_pesquisa" id="form_pesquisa" method="post" action="">
				<div id="login-box">
					<H2>Login</H2>
					Entre com seus dados corretamente para acessar o sistema.
					<br/>
					<br/>
					<div id="login-box-name">Prontu&aacute;rio:</div>
					<div id="login-box-field">
						<input name="email" class="form-login" title="Username" value="" size="30" />
					</div>
					<div id="login-box-name">Password:</div>
					<div id="login-box-field">
						<input name="pass" type="password" class="form-login" title="Password" value="" size="30"/>
					</div>
					<br/>
					<span class="login-box-options">
						<div id="cadastro">
							Cadastre-se
						</div>
						<div id="lembrarSenha">
							Esqueceu sua senha?
						</div>
					</span>

					<input type="submit" value="" class="bt-enviar"/>
					<input type="hidden" name="acao" value="Login"/>
				</div>
			</form>
		</article>
		<div id="showCad">
			<div id="aligform" class="arredonda">
				<div id="botaoFechar"></div>
					Cadastro de Login
				<hr>
				<br/>
				<form name="formulario" id="formulario" method="post" action="">
					<fieldset>
						<legend>Dados do Aluno</legend>
						
						<label>Nome:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="meuform" type="text" name="nome" size="20" tabindex="1"required="required"/>
						<br/>
						<label>Email:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="meuform" type="email" name="email" size="20" tabindex="1"required="required"/>
						<br/>
						<label>Prontu&aacute;rio:</label>
						<input class="meuform" type="text" name="prontuario" size="20" tabindex="1"required="required"/>
						<br/>
						<label>Senha:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="meuform" type="password" name="senha" size="20" tabindex="1"required="required"/>
						<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="hidden" name="acao" value="createLogin"/>
						<input class="br-enviar arredonda" type="submit" value="Enviar" tabindex="2"/>
					</fieldset>
				</form>
			</div>
		</div>
		
		<div id="showCad2">
			<div id="aligform" class="arredonda">
				<div id="botaoFechar2"></div>
					Esqueceu sua senha ?
					<hr>
					<p>
						Preencha o campo com seu email para o cadastramento de uma nova senha.
					</p>
					<br/>
					<br/>
					<form name="formulario" id="formulario" method="post" action="">
						<fieldset>
							<legend>Dados do Aluno</legend>
							<label>Email:</label>
							<input class="meuform" type="email" name="email" size="40" tabindex="1"required="required"/>
							
							<input class="br-enviar arredonda" type="submit" value="Enviar" tabindex="2"/>
						</fieldset>
					</form>
				
			</div>
		</div>
	</body>
</html>
<?php
	$action = isset($_POST['acao']) ? trim($_POST['acao']) : '';
	
	if(isset($action) && $action != ""){ 
		switch($action){
			case 'Login':
					
				require_once('class/Autentica.class.php');						
				$Autentica = new Autentica();
				
				$Autentica->email	= $_POST['email'];
				$Autentica->pass	= $_POST['pass'];
											
				if($Autentica->Validar_Usuario()){
					echo  "<script type='text/javascript'>
							alert('Login Efetuado');location.href='admin/index.php'</script>";
				}else{
					echo  "<script type='text/javascript'>
							alert('Erro ao logar');location.href='home.php'</script>";
				}
			break;
			
			case 'createLogin':
					require_once('class/Users.class.php');						
					$Users = new Users();
					
					$Users->nome	= $_POST['nome'];
					$Users->email	= $_POST['email'];
					$Users->senha	= $_POST['senha'];
					$Users->prontuario	= $_POST['prontuario'];
												
					if($Users->AddUser()){
						echo  "<script type='text/javascript'>
								alert('Login Criado');location.href='home.php'</script>";
					}else{
						echo  "<script type='text/javascript'>
								alert('Erro ao criar Login');location.href='home.php'</script>";
					}
			break;
			
			case 'updatePost':
			break;
		}
	}
?>