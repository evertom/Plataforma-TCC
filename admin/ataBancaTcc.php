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
        <meta name="author" content="" />
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
        <script>
            $(document).ready(function () {
                $("#contact").submit(function () {
                  
                    var valores =  $("#contact").serializeArray();
                    console.log(valores);

                    $.ajax
                    ({
                        type: "POST", //metodo POST
                        dataType: 'json',
                        url: "ajax/ataDefesa.php",
                        beforeSend: function () {
                            loading_show();
                        },
                        data: valores,
                        success: function (data)
                        {
                            loading_hide();
                            $('.alert-success').html(data.alerta).fadeIn('fast');
                            $('html, body').animate({scrollTop: $(".alert-success").offset().top}, 3500);
                            window.open('pdf_ataDefesa.php?idAta=' + data.idAta);
                            window.location='panel.php';
                        },
                        error: function (data) {
                            //console.log(data);
                            loading_hide() ;
                            $('.alert-danger').fadeIn('fast');
                        }
                    });
                    return false;
                });
                
                
                 $('#meusGrupos').change(function(){
                    var idGrupo = $(this).val();
                    var myId = <?php echo $id_users;?>;

                     $.ajax
                    ({
                        type: "POST", 
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
                                $('#alunosGrupo').append(obj.username+ ', ');
                                $('#alunosGrupo2').append(obj.username+ ', ');
                                $('#tituloGrupo').html(obj.titulo);
                                $('#tituloGrupo2').val(obj.titulo);
                                $('#idgrupo').val(obj.idgrupo);
                               
                            });
                            $('html, body').animate({scrollTop: $(".btn-success").offset().top}, 3500);
                            loading_hide() ;
                        },
                        error: function (data) {
                            $('.alert-danger').fadeIn('fast');
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
                                Ata de Defesa da Monografia<br/><br/>
                                <form method="post" class="desistencia" id="contact">
                                    <select id="meusGrupos" name="meusGrupos" required/>
                                        <option value="" selected="selected">Escolha o Grupo</option>
                                        <?php
                                            require_once './includes/Conexao.class.php';
                                            $Conexao = new Conexao();

                                            $sql = "SELECT gu.idgrupo,gu.uid,g.titulo "
                                                    . "FROM grupo_has_users gu "
                                                    . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
                                                    . "WHERE gu.uid = {$id_users}";

                                            $result = $Conexao->select($sql);
                                            foreach ($result as $res){
                                        ?>
                                                <option value="<?php echo $res['idgrupo'];?>"><?php echo $res['titulo'];?></option>
                                        <?php
                                            }
                                        ?>
                                     </select>
                                    <br>
                                    <br>
                            </div>
                            
                                <fieldset>
                                    <div class="row">
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
                                            <div class="form-group input-group" style="text-align:justify;">
                                                Aos, 
                                                <input id="dia" name="dia" type="date" required /> &agrave;s 
                                                <input id="horas" name="horas" type="time" required />
                                                <br>
                                                <br>
                                                Sito à rua Francisco Samuel Lucchesi, 770 – Penha – Bragança Paulista – 
                                                deste Instituto de Ensino, reuniu-se em sessão pública a comissão julgadora
                                                da Monografia de Tecnologia de Análise e Desenvolvimento de Sistemas 
                                                desenvolvida pelo(s) alunos(as): 
                                                <div id="alunosGrupo" style="display:inline;font-weight: bold;"></div>
                                                sob o título :
                                                <div id="tituloGrupo" style="display:inline;font-weight: bold;"></div>
                                                
                                                  <br><br>
                                                Integraram a comissão os Professores:
                                                <input id="name" style="border: none;width: 250px;font-weight: bold;" name="name" type="text"  value="<?php echo $nome_user ?>" required /> (orientador(a)),
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Membro 1 
                                            <input style="border: none;width: 193px;font-weight: bold;"  type="text"  value="<?php echo $nome_user ?>" name="prof1" />
                                            (Presidente) - _________________________________
                                            <br>
                                            <br>
                                            
                                            Membro 2    
                                            <select id="prof2" name="prof2">
                                                <option value="" selected="selected">Escolha um Professor</option>
                                                <?php
                                                    $sql = "SELECT * "
                                                            . "FROM users u "
                                                            . "WHERE u.tipo = 1 "
                                                            . "ORDER BY u.username ASC";

                                                    $result = $Conexao->select($sql);
                                                    foreach ($result as $res){
                                                ?>
                                                        <option value="<?php echo $res['username'];?>"><?php echo $res['username'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;_________________________________
                                            <br>
                                            <br>
                                            Membro 3
                                            <select id="prof3" name="prof3">
                                                <option value="" selected="selected">Escolha um Professor</option>
                                                <?php
                                                    $sql = "SELECT * "
                                                            . "FROM users u "
                                                            . "WHERE u.tipo = 1 "
                                                            . "ORDER BY u.username ASC";

                                                    $result = $Conexao->select($sql);
                                                    foreach ($result as $res){
                                                ?>
                                                        <option value="<?php echo $res['username'];?>"><?php echo $res['username'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;_________________________________
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group" style="text-align:justify;">
                                               sob a presidência do primeiro. A Banca Examinadora, 
                                               tendo decidido aceitar a monografia de Trabalho de 
                                               Conclusão de Curso (TCC), passou à arguição pública
                                               dos candidatos. Encerrados os trabalhos os examinadores
                                               deram parecer final sobre a apresentação.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group">
                                                Parecer:________________________________________________________________________
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group input-group" style="text-align:justify;">
                                                Em conclusão os(as) candidatos(as)
                                                <div id="alunosGrupo2" style="display:inline;font-weight: bold;"></div> 
                                                foram considerados(as) ______________, 
                                                na graduação da Monografia em Tecnologia de Análise e 
                                                Desenvolvimento de Sistemas. E, para constar, eu, 
                                                <?php
                                                    $result = $Conexao->select("SELECT * FROM users WHERE cargo = 'Coordenador ADS'");
                                                    foreach ($result as $res){
                                                        $nome = $res['username'];
                                                    }
                                                    echo "<strong>".$nome."</strong>";
                                                ?>
                                                
                                               , Coordenador do referido curso,
                                                lavrei a presente Ata que assino juntamente com os membros
                                                da Banca Examinadora.
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br/>
                                <input id="acao" name="acao" type="hidden" value="inserir"/>
                                <input id="idgrupo" name="idgrupo" type="hidden" value=""/>
                                <input id="iduser" name="iduser" type="hidden" value="<?php echo  $id_users;?>"/>
                                <input id="tituloGrupo2" name="tituloGrupo2" type="hidden" value=""/>
                                <button class="btn btn-success pull-left" type="submit">Agendar</button>
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