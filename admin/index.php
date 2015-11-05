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

$Wall->UpdateHora($atual, $expira, $_SESSION['id_login']);

require_once('includes/Conexao.class.php');
$pdo = new Conexao();

$primeroAcesso = $pdo->select("SELECT primeiroacesso FROM users WHERE uid = {$id_users} ");
?>

<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>Plataforma de Gerenciamento de TCC</title>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
        <!-- Bootstrap Core CSS -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/demo.css" rel="stylesheet" />
        <link href="css/introjs.css" rel="stylesheet" />
        <link rel="shortcut icon" href="favicon.ico"/>

        <!-- jQuery -->
        <script src="js/jquery-2.1.3.js"></script>
        <script src="js/intro.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>


        <!-- >Chat Messenger
        <link href="chat/css/style.css" rel="stylesheet" type="text/css" />
        <!--script type="text/javascript" src="chat/js/functions.js"></script>
        <script type="text/javascript" src="chat/js/chat.js"></script>
        <script type="text/javascript" src="chat/js/jquery.js"></script>-->

        <!-- >Chat Messenger<--->
        <link href="src/Chat/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="fullcalendar-2.3.1/lib/moment.min.js"></script>
        <script type="text/javascript" src="vendor/components/autobahn/autobahn.min.wamp1.js"></script>
        <script type="text/javascript" src="src/Chat/chat.min.js"></script>
        <!-- >Chat Messenger<--->


        <!-- >Mural<--->
        <link rel="stylesheet" type="text/css" media="all" href="css/wall.css" />
        <script type="text/javascript" src="js/jquery.oembed.js"></script>
        <script type="text/javascript" src="js/wall.js"></script>
        <!-- >Mural<--->

        <script type="text/javascript">
            var pagina = 0;

            function carrega() {
                $('#loading').html("<img src='img/loader.gif'/> Carregando Feeds...").fadeIn('fast');
                $.ajax({
                    type: "POST",
                    url: "loadAjax.php",
                    data: "page=" + pagina,
                    cache: false,
                    success: function (html) {
                        $('#loading').fadeOut('fast');
                        $("#content").append(html);
                    },
                    error: function (html) {
                        $('#loading').html("erro...").fadeIn('fast');
                    }
                });
            }
            ;

            $(document).ready(function () {

                chat_init({userId: <?php echo $id_users; ?>});

<?php if ($primeroAcesso[0]['primeiroacesso'] == 0) { ?>
                    introJs().start();
<?php } ?>

                carrega();

                //evento para chamar o form dinamico
                $(function ($) {
                    var painel = $("#painel");
                    var close = $("#closePainel");
                    var open = $(".openInsertForm");
                    var div = $(".insertForm");


                    //Abrir painel e buscar dinamicamente
                    $(open).click(function () {
                        painel.fadeIn(500);
                        var href = $(this).attr('href');
                        $.ajax({
                            url: href,
                            success: function (response) {
                                var data = $(response);
                                div.html(data).fadeIn(500);
                            }
                        });
                    });
                });
            });

            $(function () {
                var PassosCompletosIntro = 1;
                $('.NextIntro').on('click', function () {
                    PassosCompletosIntro = parseInt(PassosCompletosIntro) + 1;

                    if (PassosCompletosIntro == 10) {
                        confirmIntro();
                    }
                });

                $('.BackIntro').on('click', function () {
                    PassosCompletosIntro = parseInt(PassosCompletosIntro) - 1;
                });

                $('.introjs-skipbutton').on('click', function () {
                    if (PassosCompletosIntro != 10) {

                    }
                });

                $('.destaque').hover(function () {
                    //eleva a descricao para cima
                    $(this).find('p').stop().animate({top: '160px'}, 300);
                },
                        function () {
                            //volta a descricao para baixo
                            $(this).find('p').stop().animate({top: '200px'}, 300);
                        });

                $(".descricaoprof a").click(function () {
                    var paragrafro = $(this).parents('#blocoprofessores').find('.descricaoP');

                    if (paragrafro.is(":visible")) {
                        paragrafro.toggle("slow");
                    } else {
                        $('body').find('.descricaoP').each(function () {
                            if ($(this).is(":visible")) {
                                $(this).toggle("slow");
                            }
                        });
                        paragrafro.toggle("slow");
                    }
                });
            });

            function confirmIntro() {
                $.ajax({
                    type: "POST",
                    url: "ajax/introJs.php",
                    data: "id=" +<?php echo $id_users ?>,
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                return false;
            }



            $(window).scroll(function () {

                if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                    pagina += 1;
                    carrega();
                }
            });
            function rolar_para(elemento) {
                $('html, body').animate({
                    scrollTop: $(elemento).offset().top
                }, 2000);
            }

            function loading_show() {
                $('#loading').html("<img src='images/loader.gif'/>").fadeIn('fast');
            }

            function loading_hide() {
                $('#loading').fadeOut('fast');
            }

            //funcao para editar o post do feeds
            function EditarPostBt(elemento) {
                var div = $(elemento).parents('.stbody');
                var id = div.find('.comment_button').attr('id');
                var texto = div.find('.EditarPost').text();

                div.find('.EditarPost').html('<textarea style="width:100%;height:60px;"class="meuform postText">' + $.trim(texto) + '</textarea><input class="btn btn-primary btn-sm " onclick="btnEditaPost(this)" type="button" value="Salvar"></input> <input class="btn btn-info btn-sm " onclick="btnEditaPostCancela(this)" type="button" value="Cancelar"></input>');
            }


            //funcao para cancelar a edicao do post no feeds, caso ele apague, e feito um busca no bd para trazer a msg correta
            function btnEditaPostCancela(elemento) {

                var div = $(elemento).parents('.stbody');
                var texto = div.find('.postText').val();
                var id = div.find('.comment_button').attr('id');

                if (texto === '') {
                    loading_show();
                    $.ajax({
                        type: "POST",
                        url: "ajax/cancelaPost.php",
                        data: "id=" + id,
                        success: function (html) {
                            loading_hide();
                            div.find('.EditarPost').html(html).fadeIn('fast');
                        }
                    });
                    return false;
                } else {
                    div.find('.EditarPost').html(texto).fadeIn('fast');
                }
            }

            //funcao para atulizar o post quando clica no botao salvar
            function btnEditaPost(elemento) {

                var div = $(elemento).parents('.stbody');
                var texto = div.find('.postText').val();
                texto = $.trim(texto);
                var id = div.find('.comment_button').attr('id');

                if (texto === '') {
                    showAlert('alert', {title: 'AVISO!!!', message: 'Por favor digite seu Post !!!', type: BootstrapDialog.TYPE_WARNING}, null);
                    div.find('.postText').focus();
                } else {
                    $.ajax({
                        type: "POST",
                        url: "ajax/updatePost.php",
                        data: "texto=" + texto + "&id=" + id,
                        success: function (html) {
                            div.find('.EditarPost').html(texto).fadeIn('fast');
                        }
                    });
                    return false;
                }
            }

            function like(elemento) {
                var div = $(elemento).parents('.stbody');
                var idmsg = div.find('.comment_button').attr('id');
                var iduser = <?php echo $id_users; ?>;

                $.ajax({
                    type: "POST",
                    url: "ajax/like.php",
                    data: "idmsg=" + idmsg + "&iduser=" + iduser,
                    success: function (html) {

                        $(elemento).next('.likethis').html('<span class="badge">' + html + '</span>').fadeIn('fast');
                        $(elemento).removeClass('like').addClass('unlike');
                        $(elemento).html('<i class="fa fa-thumbs-o-down"></i> Descurtir');
                        $(elemento).attr('onclick','unlike(this)');
                    }
                });
                return false;
            }
            
            function curtirComments(elemento){
                var div = $(elemento).parents('.stcommenttext');
                var idmsg = div.attr('id');
                var iduser = <?php echo $id_users; ?>;
            
                 $.ajax({
                    type: "POST",
                    url: "ajax/likeComment.php",
                    data: "idmsg=" + idmsg + "&iduser=" + iduser,
                    success: function (html) {

                        $(elemento).next('.commentThis').html('<span class="badge">' + html + '</span>').fadeIn('fast');
                        $(elemento).removeClass('like').addClass('unlike');
                        $(elemento).html('<i class="fa fa-thumbs-o-down"></i> Descurtir');
                        $(elemento).attr('onclick','unlikeComment(this)');
                    }
                });
                return false;
            }
            
            
            function unlikeComment(elemento) {
                var div = $(elemento).parents('.stcommenttext');
                var idmsg = div.attr('id');
                var iduser = <?php echo $id_users; ?>;

                $.ajax({
                    type: "POST",
                    url: "ajax/likeComment.php",
                    data: "idmsg=" + idmsg + "&iduser=" + iduser,
                    success: function (html) {
                        if (html === '0') {
                            $(elemento).next('.commentThis').html('').fadeIn('fast');
                            $(elemento).removeClass('unlike').addClass('like');
                            $(elemento).html('<i class="fa fa-thumbs-o-up"></i> Curtir');
                            $(elemento).attr('onclick','curtirComments(this)');
                        } else {
                            $(elemento).next('.commentThis').html('<span class="badge">' + html + '</span>').fadeIn('fast');
                            $(elemento).removeClass('unlike').addClass('like');
                            $(elemento).html('<i class="fa fa-thumbs-o-up"></i> Curtir');
                            $(elemento).attr('onclick','curtirComments(this)');
                        }
                    }
                });
                return false;
            }
            

            function unlike(elemento) {
                var div = $(elemento).parents('.stbody');
                var idmsg = div.find('.comment_button').attr('id');
                var iduser = <?php echo $id_users; ?>;

                $.ajax({
                    type: "POST",
                    url: "ajax/like.php",
                    data: "idmsg=" + idmsg + "&iduser=" + iduser,
                    success: function (html) {
                        if (html === '0') {
                            $(elemento).next('.likethis').html('').fadeIn('fast');
                            $(elemento).removeClass('unlike').addClass('like');
                            $(elemento).html('<i class="fa fa-thumbs-o-up"></i> Curtir');
                            $(elemento).attr('onclick','like(this)');
                        } else {
                            $(elemento).next('.likethis').html('<span class="badge">' + html + '</span>').fadeIn('fast');
                            $(elemento).removeClass('unlike').addClass('like');
                            $(elemento).html('<i class="fa fa-thumbs-o-up"></i> Curtir');
                            $(elemento).attr('onclick','like(this)');
                        }
                    }
                });
                return false;
            }
            
            

            //funcao para atulizar o comentario do post quando clica no botao salvar
            function btnEditaComentario(elemento) {

                var div = $(elemento).parents('.stcommenttext');
                var id = div.attr('id');
                var texto = div.find('.ComentarioText').val();
                texto = $.trim(texto);

                if (texto === '') {
                    showAlert('alert', {title: 'AVISO!!!', message: 'Por favor digite seu Coment\u00e1rio !!!', type: BootstrapDialog.TYPE_WARNING}, null);
                    div.find('.ComentarioText').focus();
                } else {
                    $.ajax({
                        type: "POST",
                        url: "ajax/updateComentPost.php",
                        data: "texto=" + texto + "&id=" + id,
                        success: function (html) {
                            div.find('.EditarComment').html(texto).fadeIn('fast');
                        }
                    });
                    return false;
                }
            }

            //funcao para editar o comentario post do feeds
            function EditaComentPost(elemento) {
                var div = $(elemento).parents('.stcommenttext');
                var id = div.attr('id');
                var texto = div.find('.EditarComment').text();
                texto = $.trim(texto);

                div.find('.EditarComment').html('<textarea style="width:100%;height:60px;"class="meuform ComentarioText"  >' + texto + '</textarea><input class="btn btn-primary btn-sm btnEditaComentario" onclick="btnEditaComentario(this)" type="button" value="Salvar"></input> <input class="btn btn-info btn-sm btnEditaComentarioCancela" onclick="btnEditaComentarioCancela(this)" type="button" value="Cancelar"></input><br/><br/>');
            }

            //funcao para cancelar a edicao do comentario post no feeds, caso ele apague, e feito um busca no bd para trazer a msg correta
            function btnEditaComentarioCancela(elemento) {

                var div = $(elemento).parents('.stcommenttext');
                var id = div.attr('id');
                var texto = div.find('.EditarComment').text();
                texto = $.trim(texto);

                if (texto === '') {
                    loading_show();
                    $.ajax({
                        type: "POST",
                        url: "ajax/cancelaComentario.php",
                        data: "id=" + id,
                        success: function (html) {
                            loading_hide();
                            div.find('.EditarComment').html(html).fadeIn('fast');
                        }
                    });
                    return false;
                } else {
                    div.find('.EditarComment').html(texto).fadeIn('fast');
                }
            }
        </script>
    </head>
    <body>
        <!-- Div para listar forms que adicionaram itens. --->
        <div id="painel"><div class="insertForm"></div></div>
        <!-- >Chat Messenger<--->
        <div style="position:absolute; top:0; right:0;" id="retorno"></div>
        <div id="janelas"></div>
        <!-- >Chat Messenger<--->
        <header>
            <div id="aligheader">
                <div id="logoif" data-step="1" data-intro="Olá, seja muito bem vindo à Plataforma de Gerencimento de TCC, 
                     aqui você encontrará recursos para auxiliar você e seu grupo juntamente de seu orientador
                     a desenvolver sua monografia, mapeando todos os passos do grupo como um histórico de processos 
                     feitos, atas de reuniões automatizadas, sistema de bate-papo, acompanhamento por gráficos, 
                     enfim, tudo muito intuitivo e dinâmico, fazendo assim com que seu grupo tenha um maior controle 
                     sobre oque está sendo feito e sobre oque ainda precisa fazer, mantendo assim um ótimo fluxo no desenvolvimento, e com o professor acompanhando passo
                     a passo todas as etapas, conheça um pouco nossa plataforma !!!"></div>
                <div id="forumimg" data-step="2" data-intro="Aqui na página principal, você encontra nossa mini rede social, 
                     na qual você poderá compartilhar suas ideias, comentar ideias dos seus amigos, bater papo no privado, 
                     ver possíveis ideias de tema para TCC postada por todos integrantes da plataforma, visualizar monografias de 
                     TCC finalizadas para ter como base, enfim, muitas vantagens que você poderá encontrar aqui. "></div>
                <div id="aligmenu">
                    <nav id="navigation">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li data-step="3" data-intro="Nesse menu você encontrará nossa plataforma onde será realizado todo o controle 
                                da monografia de seu TCC, porém para poder ter acesso total a plataforma, é necessário que você contate um 
                                orientador mais abaixo, e que ele aceite seu convite, formando assim um grupo e sendo liberado seu acesso a 
                                plataforma juntamente de todos os integrantes do grupo."><a href="panel.php">TCC</a></li>

                            <li data-step="4" data-intro="Nesse menu, você encontrará todos os PDF disponibilizados pela secretaria para alguns processos envolvendo o grupo de TCC, como 
                                por exemplo, ata de desistência de grupo e de orientador, ata de responsabilidade, ata de apresentação da monografia, porém esses PDF foram 
                                todos automatizados pela plataforma, na qual dispensará você ter o trabalho de escrever, pois o sistema fará tudo automaticamente."><a href="" data-toggle="modal" data-target="#myModal2"><i class="fa fa-file-pdf-o"></i> Arquivos</a></li>
                            <li data-step="10" data-intro="Aqui você encontra mais algumas dicas sobre a plataforma!<br><br> Para finalizar clique no botão ENTENDI e Boa sorte em seu desenvolvimento!"><a href="" data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i> Sobre</a></li>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Informa&ccedil;&otilde;es sobre a Plataforma</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>A plataforma de Gerenciamento de TCC foi criado para auxiliar 
                                                o aluno no desenvolvimento de sua monografia, desde a criação 
                                                de sua ideia em si, até seu objetivo final, a banca. Para tal 
                                                foi desenvolvido um sistema de rede social onde os alunos vão
                                                poder trocar ideias através do Feeds de notícias ou pelo bate
                                                papo privado.</p>
                                            <p>Dentro do painel administrativo você encontrará todo o suporte
                                                para o desenvolvimento do TCC de seu grupo, com muitas funcionalidades
                                                e controles, para que haja sempre um bom fluxo de seu projeto.</p>
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

                            <!-- Modal -->
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Arquivos PDF</h4>
                                        </div>
                                        <div class="modal-body">
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Regulamento-TCC.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Regulamento Completo TCC
                                                </div>
                                            </a>
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Proposta-de-conclusao-de-curso.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Formulário de Proposta
                                                </div>
                                            </a>
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Desisntência Professor
                                                </div>
                                            </a>        
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo-aluno.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Desisntência Aluno
                                                </div>
                                            </a>
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Ata-de-defesa-da-monografia.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Ata de Defesa da Monografia
                                                </div>
                                            </a>
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Compromisso-etico.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Compromisso Ético
                                                </div>
                                            </a>
                                            <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-autorizacao-para-publicacao.pdf" target="_blanck">
                                                <div>
                                                    <i class="fa fa-file-pdf-o"></i> Autorização para Publicação
                                                </div>
                                            </a>

                                            <br style="clear:both;"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline btn-success" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal 2-->
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <section>
            <div id="conteudo">
                <!-- bloco do perfil -->
                <div id="perfil" class="arredonda">
                    <div data-step="5" data-intro="Aqui você encontra um pequeno painel de configuração de usuário, como foto e dados pessoais, e encontra as publicações de TCC já realizadas e permitidas para exibição.">
                        <div id="fotoperfil" class="destaque">
                            <img src="<?php echo $fotouser ?>"/>
                            <p><a onclick="return false;" href="addPhoto.php?id=<?php echo $id_users ?>" title="Editar Foto" class="openInsertForm">Editar Foto...</p></a>
                        </div>
                        <div id="nomeperfil">
                            <?php echo $nome_user ?>
                        </div>
                        <hr/>
                        <nav>
                            <a href="userProfile.php?id=<?php echo $id_users; ?>"><ul><i class="fa fa-user"></i> Perfil</ul></a>
                            <ul><i class="fa fa-gears"></i> Configura&ccedil;&otilde;es</ul>
                            <ul><i class="fa fa-book"></i> Publica&ccedil;&otilde;es</ul>
                            <a href="logout.php"><ul><i class="fa fa-sign-out"></i> Sair</ul></a>
                        </nav>
                    </div>
                    <div data-step="6" data-intro="Nesse bloco você encontrará nosso bate papo privado para trocar ideias com quem desejar da plataforma.">
                        <br clear="all"/>
                        <div id="nomeperfil">Messenger</div>
                        <hr/>
                        <div id="chat"></div>
                    </div>
                </div>
                <!-- final bloco do perfil -->
                <div id="feeds">
                    <div id="wall_container">
                        <div id="updateboxarea">
                            <form method="post" id="formpost" action="">
                                <fieldset data-step="7" data-intro="Aqui você poderá expor suas ideias, opiniões, dúvidas etc.">
                                    <legend>Em que est&aacute; pensando?</legend>
                                    <textarea  class="meuform" name="update" id="update"></textarea><br />

                                    <button type="submit" value="" id="update_button" class="update_button btn btn-primary">Postar <span class="glyphicon glyphicon-send"></span></button>
                                </fieldset>
                            </form>
                        </div>
                        <div id='flashmessage'>
                            <div id="flash" align="left"></div>
                        </div>

                        <div class="separador clr" data-step="8" data-intro="Aqui você acompanha tudo oque os usuários da plataforma postaram, você poderá curtir o post de seu amigo se gostar e comentar."><h3>Feeds</h3></div>
                        <div id="content"></div>
                        <div id='loading'></div>
                    </div>
                    <br clear="all"/>
                </div><!-- final bloco do feeds -->
                <aside>				
                    <div id="sidebar" class="arredonda">
                        <div class="separador2 clr" data-step="9" data-intro="Esse bloco é muito importante para o acesso à plataforma, aqui você encontra todos os Professores do IFSP na 
                             área de ADS (Análise e Desenvolvimento de Sistemas).<br><br>Abaixo da foto você encontra a área de atuação do professor e sua disponibilidade, e um botão de 
                             SOLICITAR orientação para formação de grupo do TCC, para enviar sua requisição ao professor clique nesse botão e preencha o formulário em seguida."><h3>Professores ADS</h3></div>
                             <?php
                             $result = $pdo->select("SELECT uid,username,email,fotouser,descricao,cargo "
                                     . "FROM users WHERE tipo = 1 ORDER BY cargo,username ASC");

                             foreach ($result as $res) {
                                 ?>
                            <div id="blocoprofessores">
                                <div id="fotoprof">
                                    <img src="<?php echo $res['fotouser'] ?>" width="59" alt="Usuário"/>
                                </div>
                                <div id="descricaoprof" class="descricaoprof">

                                    <i class="fa fa-graduation-cap"></i><strong> <?php echo $res['cargo'] ?></strong><br/>
                                    <?php echo $res['username'] ?><br/>
                                    <i class="fa fa-angle-double-down"></i> <a>Leia Mais</a>

                                    <div class="expansive-painel">
                                        <div class="descricaoP">
                                            <p><i class="fa fa-envelope-o"></i> <?php echo $res['email'] ?></p>
                                            <p><?php echo $res['descricao'] ?></p>
                                            <p><a href="requerimentoProf.php?uid=<?php echo $res['uid']; ?>&nome=<?php echo $res['username']; ?>"><button type="button" class="btn btn-outline btn-success">Requisitar</button></a></p>
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
                    <img src="img/if.png" width="200" alt="IFSP" title="IFSP"/>
                </div>
            </section>
        </footer>
    </body>
</html>