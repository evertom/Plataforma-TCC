<script>
	$(document).ready(function () {
		//evento do botao editar para chamar o form dinamico
		$('.notificacoes').click(function () {
			$(this).find('span').fadeOut();
			//apos clicar nas configuracoes damos um update nas notificacoes do usuario atual para nao exibir mais msg
			var user = <?php echo $id_users; ?>;
			$.ajax({
				type: "POST",
				url: "ajax/updateAviso.php",
				data: "user=" + user,
				success: function (html) {

				}
			});
		});
	});
</script>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php" data-toggle="tooltip" data-placement="bottom" title="Notifica&ccedil;&otilde;es">Painel ADM TCC</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle notificacoes" data-toggle="dropdown" href="#">
            <?php
            require_once('includes/Conexao.class.php');
            $pdo = new Conexao();

            $resultado = $pdo->select("SELECT count(*) as cont FROM avisos WHERE uid = " . $id_users . " "
                    . "AND visto = 0");

            if (count($resultado)) {
                foreach ($resultado as $res) {
                    if ($res['cont'] > 0) {
                        echo '<span class="badgeRed">' . $res['cont'] . '</span> <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>';
                    } else {
                        echo '<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>';
                    }
                }
            }
            ?>
        </a>
        <ul class="dropdown-menu dropdown-messages">
            <?php
            $result = $pdo->select("SELECT a.idavisos,a.descricao, "
                    . "DATE_FORMAT(a.data, '%d/%m/%Y') as data, u.username,u.fotouser "
                    . "FROM avisos a INNER JOIN users u ON u.uid = a.de "
                    . "WHERE a.uid = " . $id_users . " ORDER BY a.idavisos DESC LIMIT 5");

            if (count($result)) {
                foreach ($result as $ress) {
                    echo '<li>
                        <a href="notificacao.php?id=' . $ress['idavisos'] . '">
                            <div style="margin-bottom:8px;">
                                <strong><img src="' . $ress['fotouser'] . '" width="25px"/> ' . $ress['username'] . '</strong>
                                <span class="pull-right text-muted">
                                    <em><i class="fa fa-calendar"></i> ' . $ress['data'] . '</em>
                                </span>
                            </div>';
                    if (strlen($ress['descricao']) > 130) {
                        $noticia = substr($ress['descricao'], 0, 130) . "... <i class=\"fa fa-plus-square\"></i> leia mais";
                    } else {
                        $noticia = $ress['descricao'];
                    }
                    echo '<div>' . $noticia . '</div></a></li><li class="divider"></li>';
                }
                echo ' <li>
                            <a class="text-center" href="#">
                                <strong>Ver tudo</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                       </li>';
            } else {
                echo '<li>
                        <a href="#">
                            <div>
                                    <strong>Admin</strong>
                                    <span class="pull-right text-muted">
                                            <em>Hoje</em>
                                    </span>
                            </div>
                            <div>Ainda n&atilde;o h&agrave; avisos para voc&ecirc;</div>
                        </a>
                </li><li class="divider"></li>';
            }
            ?>
        </ul>
        <!-- /.dropdown-messages -->
    </li>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-tasks">
            <li>
                <a href="#">
                    <div>
                        <p>
                            <strong>Task 1</strong>
                            <span class="pull-right text-muted">40% Complete</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="#">
                    <div>
                        <p>
                            <strong>Task 2</strong>
                            <span class="pull-right text-muted">20% Complete</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="#">
                    <div>
                        <p>
                            <strong>Task 3</strong>
                            <span class="pull-right text-muted">60% Complete</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                <span class="sr-only">60% Complete (warning)</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="#">
                    <div>
                        <p>
                            <strong>Task 4</strong>
                            <span class="pull-right text-muted">80% Complete</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                <span class="sr-only">80% Complete (danger)</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a class="text-center" href="#">
                    <strong>See All Tasks</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
        </ul>
        <!-- /.dropdown-tasks -->
    </li>
    <?php
    if ($tipo_users  == 0) {
        ?>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-file-pdf-o fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Regulamento-TCC.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Regulamento Completo TCC
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Proposta-de-conclusao-de-curso.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Formulário de Proposta
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Desisntência Professor
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo-aluno.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Desisntência Aluno
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Ata-de-defesa-da-monografia.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Ata de Defesa da Monografia
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Compromisso-etico.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Compromisso Ético
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-autorizacao-para-publicacao.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Autorização para Publicação
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <center>
                        <strong>Operações Automatizadas</strong>
                        <i class="fa fa-angle-double-down"></i>
                    </center>
                </li>
                <li class="divider"></li>
		<li>
                    <a href="deixaGrupo.php">
                        <div>
                            <i class="fa fa-group fa-fw"></i> Desistência de TCC
                            <span class="pull-right text-muted small">Relatório PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
		<li>
                    <a href="pdf_pre_projeto.php?idUser=<?php echo $id_users;?>" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Pré Projeto Preenchido
                            <span class="pull-right text-muted small">Relatório PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
		<li>
                    <a href="pdf_compromisso_etico.php?idUser=<?php echo $id_users;?>" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Compromisso Ético
                            <span class="pull-right text-muted small">Relatório PDF</span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <?php
    } else {
        ?>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-file-pdf-o fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Regulamento-TCC.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Regulamento Completo TCC
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Proposta-de-conclusao-de-curso.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Formulário de Proposta
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Desisntência Professor
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-desistencia-de-orientacao-coorientado-do-grupo-aluno.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Desisntência Aluno
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Ata-de-defesa-da-monografia.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Ata de Defesa da Monografia
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Compromisso-etico.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Compromisso Ético
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="GerenciamentoGrupos/PDFregulamentos/Termo-de-autorizacao-para-publicacao.pdf" target="blanck">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Autorização para Publicação
                            <span class="pull-right text-muted small">PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                 <li>
                    <center>
                        <strong>Operações Automatizadas</strong>
                        <i class="fa fa-angle-double-down"></i>
                    </center>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="desfazerGrupo.php">
                        <div>
                            <i class="fa fa-group fa-fw"></i> Desistência de Grupo
                            <span class="pull-right text-muted small">Relatório PDF</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="ataBancaTcc.php">
                        <div>
                            <i class="fa fa-file-pdf-o"></i> Ata de Defesa
                            <span class="pull-right text-muted small">Relatório PDF</span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <?php
    }
    ?>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="userProfile.php?id=<?php echo $id_users; ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
            </li>
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li>
            <li class="divider"></li>
            <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->