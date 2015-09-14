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
        <link rel="stylesheet" href="admin/bootstrap/css/bootstrap.min.css"/>
        <script src="admin/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="admin/bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <script src="admin/bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="admin/bootstrap3-dialog-master/alertsMsg.js"></script>
        <script>
            //Aqui inicio do c�digo Jquery
            $(document).ready(function () {
               
                var $divShow = $('#showCad');
                var $divShow2 = $('#showCad2');
                var $divClick = $('#cadastro');
                var $divClick2 = $('#lembrarSenha');

                //bloco para cadastro
                $divClick.click(function () {
                    $('body').css('overflow', 'hidden');
                    $('body').css('display', 'block');
                    $divShow.toggle('slow', function () {
                    });
                });

                $('#botaoFechar').click(function () {
                    $('#showCad').fadeOut(500, function () {
                        $('body').css('overflow', 'auto');
                    });
                });
                //bloca para lembra senha	
                $divClick2.click(function () {
                    $('body').css('overflow', 'hidden');
                    $('body').css('display', 'block');

                    $divShow2.toggle('slow', function () {
                    });
                });

                $('#botaoFechar2').click(function () {
                    $('#showCad2').fadeOut(500, function () {
                        $('body').css('overflow', 'auto');
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
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 col-xs-12 col-md-12'>
                            <h4>Login <small>Entre com seus dados corretamente para acessar o sistema.</small></h4>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 col-xs-12 col-md-12'>
                            <label>
                                <span>Email</span>
                                <br clear='all'/>
                                <input name="email" class="form-login" title="Username" value="" size="30" />
                            </label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 col-xs-12 col-md-12'>
                            <label>
                                <span>Password:</span>
                                <br clear='all'/>
                                <input name="pass" type="password" class="form-login" title="Password" value="" size="30"/>
                            </label>
                        </div>
                    </div>
                   
                    <div class='row'>
                        <div class='col-lg-4 col-sm-4 col-xs-4 col-md-4'>
                               <div id="cadastro">
                                   Cadastre-se
                               </div>
                        </div>
                        <div class='col-lg-8 col-sm-8 col-xs-8 col-md-8'>
                           <div id="lembrarSenha">
                               Esqueceu sua senha?
                           </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-12 col-sm-12 col-xs-12 col-md-12'>
                            <input type="submit" value="" class="bt-enviar"/>
                            <input type="hidden" name="acao" value="Login"/>
                        </div>
                    </div>
                    
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

if (isset($action) && $action != "") {
    switch ($action) {
        case 'Login':

            require_once('class/Autentica.class.php');
            $Autentica = new Autentica();

            $Autentica->email = $_POST['email'];
            $Autentica->pass = $_POST['pass'];

            if ($Autentica->Validar_Usuario()) {
                echo "<script type='text/javascript'>"
                . " showAlert('alert',{title: 'Bem vindo!!!', message:'Seja bem vindo ao sistema TCC.', location:'admin/index.php' }, null);"
                . "</script>";
            } else {
                echo "<script type='text/javascript'>"
                . "showAlert('alert',{title: 'Aviso!!!', message:'senha ou login incorretos!!!', type: BootstrapDialog.TYPE_WARNING, location:'home.php'}, null);"
                . "</script>";
            }
            break;

        case 'createLogin':
            require_once('class/Users.class.php');
            $Users = new Users();

            $Users->nome = $_POST['nome'];
            $Users->email = $_POST['email'];
            $Users->senha = $_POST['senha'];
            $Users->prontuario = $_POST['prontuario'];

            if ($Users->AddUser()) {
                echo "<script type='text/javascript'>"
                . "showAlert('alert',{title: 'Parabéns!!!', message:'Login criado com sucesso!!!', location:'home.php'}, null);</script>";
            } else {
                echo "<script type='text/javascript'>"
                . "showAlert('alert',{title: 'Aviso!!!', message:'Erro ao tentar cadastrar novo login!!!', type: BootstrapDialog.TYPE_DANGER, location:'home.php'}, null);</script>";
            }
            break;
        case 'updatePost':
            break;
    }
}
?>