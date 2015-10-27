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
    </head>
    <body>
        <article>
            <div id="logo">
                <img src="img/if.png"/>
            </div>
            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                <div id="login-box">
                    <div class='row'>
                        <div class='col-lg-10'>
                            <h1>Login</h1> Entre com seus dados corretamente para acessar o sistema.
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class='row'>
                        <div class='col-lg-10'>
                            <label>
                                <span>Email</span>
                                <br clear='all'/>
                                <input name="email" class="form-control" title="Username" value="" size="34" />
                            </label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-10'>
                            <label>
                                <span>Password:</span>
                                <br clear='all'/>
                                <input name="pass" type="password" class="form-control" title="Password" value="" size="34"/>
                            </label>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-lg-4 col-sm-4 col-xs-4 col-md-4'>
                            <div id="cadastro">
                                <a data-toggle="modal" data-target="#login" style="color: #FFF;">Cadastre-se</a>
                            </div>
                        </div>
                        <div class='col-lg-8 col-sm-8 col-xs-8 col-md-8'>
                            <div id="lembrarSenha">
                                <a data-toggle="modal" data-target="#review" style="color: #FFF;">Esqueceu sua senha?</a>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-10'>
                            <input type="submit" value="" class="bt-enviar"/>
                            <input type="hidden" name="acao" value="Login"/>
                        </div>
                    </div>

                </div>
            </form>
        </article>

        <!-- Modal -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Cadastro de Login</h4>
                    </div>
                    <form name="formulario" id="formulario" method="post" action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <label class="label-control">Nome:</label>
                                        <input class="form-control" type="text" name="nome" required="required" placeholder="Digite seu nome..."/>
                                    </div>
                                    <br style="clear: both;">
                                    <br style="clear: both;">
                                    <div class="col-lg-12">
                                        <label class="label-control">Email:</label>
                                        <input class="form-control" type="text" name="email" required="required" placeholder="Digite seu email..."/>
                                    </div>
                                    <br style="clear: both;">
                                    <br style="clear: both;">
                                    <div class="col-lg-6">
                                        <label class="label-control">Prontu&aacute;rio:</label>
                                        <input class="form-control" type="text" name="prontuario" required="required" placeholder="Digite seu prontuário..."/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label-control">Senha:</label>
                                        <input class="form-control" type="text" name="senha" required="required" placeholder="Digite sua senha..."/>
                                        <input type="hidden" name="acao" value="createLogin"/>
                                    </div>
                                    <br style="clear: both;">
                                    <br style="clear: both;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <!-- Modal -->
        <div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Recuperação de Senha</h4>
                    </div>
                    <form name="formulario" id="formulario" method="post" action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <label class="label-control">Email:</label>
                                        <input class="form-control" type="text" name="email" required="required" placeholder="Digite seu email..."/>
                                    </div>
                                    <br style="clear: both;">
                                    <br style="clear: both;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
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