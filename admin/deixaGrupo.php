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
        <style type="text/css">
        @media print {
          .btn-danger,.page-header,.someImpresso{
            visibility:hidden;
          }                                 
        }
      </style>
        <script>
            $(document).ready(function () {
                //evento do botao editar para chamar o form dinamico
                $('.notificacoes').click(function () {
                    $(this).find('span').fadeOut();
                    //apos clicar nas configura��es damos um update nas notificacoes do usuario atual para nao exibir mais msg
                    var user = <?php echo $id_users; ?>;
                    $.ajax({
                        type: "POST",
                        url: "ajax/updateAviso.php",
                        data: "user=" + user,
                        success: function (html) {

                        }
                    });
                });

                $("#contact").submit(function () {
                  
                    var valores =  $("#contact").serializeArray();
                    console.log(valores);
                    var ok = false;
                    var id = null;
                    var mensagem = "";

                    $.ajax
                    ({
                        async: false,
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/desistencia.php",
                        beforeSend: function () {
                            loading_show();
                        },
                        data: valores,
                        success: function (data)
                        {
                            ok = data.msg;
                            mensagem = data.escrita;
                        },
                        error: function (data) {
                            console.log(data);
                            //$('.alert-danger').fadeIn('fast');
                            ok = false;
                        },
                        complete: function () {
                            loading_hide();
                            return ok;
                        }
                    });

                    if (ok === true) {
                        $('.alert-success').fadeIn('fast');
                        self.print();
                        limpa();
                    } else {
                        $('.alert-danger').append(mensagem).fadeIn('fast');
                        limpa();
                    }

                    return false;
                });
            });

            //funcao para mostrar o loading
            function loading_show() {
                $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
            }
            //funcao para esconder o loading
            function loading_hide() {
                $('#loading').fadeOut('fast');
            }

            function limpa() {
                $('#contact').find("textarea").val("");
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
                        <div class="col-xs-12">
                            <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user ?></span></h1>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-8">
                            <div class="someImpresso">
                                 Preencha o formulário explicando o motivo de sua desistência deste Grupo<br/><br/>
                            </div>
                            <form method="post" class="desistencia" id="contact">
                                <fieldset>
                                    <div class="row">
                                        
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                Eu, 
                                                <input id="name" style="border: none;width: 290px;font-weight: bold;"name="name" type="text" placeholder="Nome" value="<?php echo $nome_user ?>" required ></input>
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                Prontuário  
                                                <input id="prontuario" style="border: none;width: 220px;font-weight: bold;"name="prontuario" type="text" placeholder="Nome" value="<?php echo $prontuario_users ?>" required ></input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            aluno(a) do Curso de Tecnologia em Análise e Desenvolvimento de Sistemas no Campus Bragança Paulista do IFSP, neste período letivo de <strong><?php echo date('d/m/Y');?></strong>
                                            declaro, para os devidos fins:
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group">
                                                <input  id="motiGrupo" name="motiGrupo" type="checkbox"></input>
                                                Desistir do desenvolvimento do Trabalho de Conclusão de Curso no grupo formado pelos seguintes integrantes:
                                                <?php
                                                    require_once './includes/Conexao.class.php';
                                                    $pdo = new Conexao();
                                                    $sql = "SELECT gu.idgrupo "
                                                            . "FROM grupo_has_users gu "
                                                            . "WHERE gu.uid = ".$id_users."";
                                                    $result = $pdo->select($sql);
                                                    foreach ($result as $res){
                                                        $idGrupo = $res['idgrupo'];
                                                    }
                                                    $sql = "SELECT u.username "
                                                            . "FROM grupo_has_users gu "
                                                            . "INNER JOIN users u ON u.uid = gu.uid"
                                                            . " WHERE gu.idgrupo = {$idGrupo} "
                                                            . "AND gu.uid <> {$id_users} "
                                                            . "AND gu.tipo = 1";
                                                    $resulte = $pdo->select($sql);
                                                    $total = count($resulte);
                                                    $aux = 1;
                                                    foreach ($resulte as $res){
                                                        if($total == $aux){
                                                             echo "<strong>".$res['username']."</strong>";
                                                        }else{
                                                             echo "<strong>".$res['username']."</strong>, ";
                                                        }
                                                       $aux++;
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group">
                                                <input  id="motiProf" name="motiProf" type="checkbox"></input>
                                                Desistir da orientação do Trabalho de Conclusão de Curso do(a) professor(a)
                                                <?php
                                                    $sql = "SELECT u.username "
                                                            . "FROM grupo_has_users gu "
                                                            . "INNER JOIN users u ON u.uid = gu.uid"
                                                            . " WHERE gu.idgrupo = {$idGrupo} "
                                                            . "AND gu.tipo = 2";
                                                    $resu = $pdo->select($sql);
                                                    foreach ($resu as $res){
                                                        echo '<strong>'.$res['username'].'</strong>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Motivo:
                                            <textarea class="form-control" id="descri" name="descri" rows="3" cols="40" placeholder="Descri&ccedil;&atilde;o" required></textarea>
                                            Bragança Paulista, <?php echo date('d');?> de <?php echo date('M');?> de <?php echo date('Y');?>
                                        </div>
                                    </div>
                                </fieldset>
                                <br/>
                                <input id="acao" name="acao" type="hidden" value="inserir"></input>
                                <input id="idgrupo" name="idgrupo" type="hidden" value="<?php echo  $idGrupo;?>"></input>
                                <input id="iduser" name="iduser" type="hidden" value="<?php echo  $id_users;?>"></input>
                                <button class="btn btn-danger pull-left" type="submit">Desistir</button>
                                <div id="loading" class="someImpresso"></div>
                                <br/><br/><br/>
                                <div class="alert alert-success alert-dismissable" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Opera&ccedil;&atilde;o realizada com sucesso...
                                </div>
                                <div class="alert alert-danger alert-dismissable"  style="display:none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    Falha na operação...
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
                <div class="row"></div>
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