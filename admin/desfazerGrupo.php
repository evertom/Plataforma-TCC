<?php
require_once('verifica-logado.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Admin</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
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
                        url: "ajax/desistenciaProf.php",
                        beforeSend: function () {
                            loading_show();
                        },
                        data: valores,
                        success: function (data)
                        {
                            ok = data.msg;
                            mensagem = data.alerta;
                        },
                        error: function (data) {
                            //console.log(data);
                            $('.alert-danger').fadeIn('fast');
                            ok = false;
                        },
                        complete: function () {
                            loading_hide();
                            return ok;
                        }
                    });

                    if (ok === true) {
                        $('.alert-success').append(mensagem).fadeIn('fast');
                        //self.print();
                        limpa();
                        window.open('pdf_desistencia_prof.php?idUser=<?php echo $id_users ;?>');
                        window.location='panel.php';
                    } else {
                        $('.alert-danger').append(mensagem).fadeIn('fast');
                        limpa();
                    }

                    return false;
                });
                
                $('#meusGrupos').change(function(){
                    var idGrupo = $(this).val();
                    var myId = <?php echo $id_users;?>;
                    
                     $.ajax
                    ({
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/buscaAlunos.php",
                        beforeSend: function () {
                            $('#alunosGrupo').html('');
                            loading_show();
                        },
                        data: "idGrupo=" + idGrupo + "&myid=" + myId,
                        success: function (data)
                        {
                            $.each(data, function(i, obj){
                                $('#alunosGrupo').append(obj.username+ ' / ');
                                $('#idgrupo').val(obj.idgrupo);
                            });
                            loading_hide() ;
                        },
                        error: function (data) {
                            //console.log(data);
                            ('.alert-danger').fadeIn('fast');
                            ok = false;
                        }
                    });
                    return false;
                });
                
            });
            function loading_show() {
                $('#loading').html("<img src='img/loader.gif'/>").fadeIn('fast');
            }
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
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header">Bem vindo <span class="text-danger">
                                <?php echo $nome_user ?></span>
                            </h1>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-8">
                            <div class="someImpresso">
                                 Preencha o formulário explicando o motivo de sua desistência deste Grupo<br/><br/>
                                 <select id="meusGrupos" name="meusGrupos">
                                    <option value="" selected="selected">Escolha o Grupo</option>
                                    <?php
                                        require_once './includes/Conexao.class.php';
                                        $Conexao = new Conexao();
                                        
                                        $sql = "SELECT gu.idgrupo,gu.uid,g.titulo "
                                                . "FROM grupo_has_users gu "
                                                . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
                                                . "WHERE gu.uid = 12";
                                        
                                        $result = $Conexao->select($sql);
                                        foreach ($result as $res){
                                    ?>
                                            <option value="<?php echo $res['idgrupo'];?>"><?php echo $res['titulo'];?></option>
                                    <?php
                                        }
                                    ?>
                                 </select>
                                 <br/>
                                 <br/>
                                 <br/>
                            </div>
                            <form method="post" class="desistencia" id="contact">
                                <fieldset>
                                    <div class="row">
                                        
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                Eu, 
                                                <input id="name" style="border: none;width: 290px;font-weight: bold;" name="name" type="text" placeholder="Nome" value="<?php echo $nome_user ?>" required />
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group input-group">
                                                Prontuário  
                                                <input id="prontuario" style="border: none;width: 220px;font-weight: bold;" name="prontuario" type="text" placeholder="Nome" value="<?php echo $prontuario_users ?>" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           comunico que, a partir desta data, não serei mais o(a) responsável pela
                                           <input type="radio" name="opcaoProf" id="opcaoProf" value="1" checked="checked"> orientação / 
                                           <input type="radio" name="opcaoProf" id="opcaoProf" value="2" > coorientação do TCC do(a) aluno(a)
                                           <div id="alunosGrupo" style="display:inline;font-weight: bold;"></div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group">
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
                                <input id="acao" name="acao" type="hidden" value="inserir"/>
                                <input id="idgrupo" name="idgrupo" type="hidden" value="<?php echo  $idGrupo;?>"/>
                                <input id="iduser" name="iduser" type="hidden" value="<?php echo  $id_users;?>"/>
                                <button class="btn btn-danger pull-left" type="submit">Desistir</button>
                                <div id="loading" class="someImpresso"></div>
                                <br/><br/><br/>
                                <div class="alert alert-success alert-dismissable" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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