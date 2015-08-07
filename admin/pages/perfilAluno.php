<?php
require_once('includes/Conexao.class.php');
$pdo = new Conexao();

//apos a montagem do grupo e necessario cadastrar o pre projeto obrigatoriamente
$rsu = $pdo->select("SELECT * FROM grupo WHERE idgrupo = " . $idGrupo . "");
foreach ($rsu as $resPre) {
    $preProjeto = $resPre['preProjeto'];
    $cronograma = $resPre['cronograma'];
}
if ($preProjeto == 1) {
    echo '
		<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:block!important;"aria-hidden="false">
		  <div class="modal-backdrop fade in" style="height: 756px;"></div>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
						<h4 class="modal-title" id="myModalLabel">#Etapa 2 - Grupo de TCC montado com sucesso</h4>
					</div>
					<div class="modal-body">
						Ap&oacute;s  a montagem do grupo de TCC atrav&eacute;s do Professor solicitado, para completar a etapa de cadastro do grupo, preencha todos os dados do Pr&eacute; Projeto, e ap&oacute;s o preenchimento cadastre o seu cronograma.
					</div>
					<div class="modal-footer">
						<a href="cadastroPreProjeto.php?idgrupo=' . $idGrupo . '"><button type="button" class="btn btn-primary">Cadastrar Pr&eacute; Projeto</button></a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>';
}

if ($cronograma == 1) {
    echo '
		<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:block!important;"aria-hidden="false">
		  <div class="modal-backdrop fade in" style="height: 756px;"></div>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
						<h4 class="modal-title" id="myModalLabel">#Etapa 3 - Pr&eacute; Projeto cadastrado com sucesso...</h4>
					</div>
					<div class="modal-body">
						Ap&oacute;s o cadastramento do Pr&eacute; Projeto, voc&ecirc; dever&aacute; montar seu cronograma de desenvolvimento, especificando as datas e atividades a serem realizadas, automaticamente ser&atilde;o gerados gr&aacute;ficos para acompanhamento do desenvolvimento e analisar se o grupo est&aacute; atrasado ou trabalhando conforme o programado.
					</div>
					<div class="modal-footer">
						<form action="cronograma.php" method="POST">
							<input type="hidden" value="$idGrupo" name="idgrupo" />
							<button type="action" class="btn-primary" >Cadastrar Cronograma</button>
						</form>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>';
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <?php
    $result = $pdo->select("SELECT g.fraselema FROM users u INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
            . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo WHERE g.aceito = 1 "
            . "AND g.visto = 1 AND g.idgrupo = " . $idGrupo . " and u.uid = " . $id_users . "");

    foreach ($result as $res) {
        $fraseLema = isset($res['fraselema']) ? $res['fraselema'] : "Voc&ecirc; ainda n&atilde;o "
            . "possui uma frase lema, v&aacute; ao painel de configura&ccedil;&otilde;es e "
            . "cadastre sua frase que est&aacute; na monografia para exibila.";
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user ?></span></h1>
            </div>

            <div style="font-size:11px;" class="col-xs-6 col-md-4">
                <br/><p><i class="fa fa-quote-left"></i> <?php echo $fraseLema; ?> <i class="fa fa-quote-right"></i></p>
            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <!-- /.row -->
    <?php
        $concluido = 0;
        $atrasado = 0;
        $registros = 0;
        $participo = 0;
        $resultado = $pdo->select("SELECT * FROM evento WHERE idGrupo = {$idGrupo}");
        if(count($resultado)){
            foreach($resultado as $ress){
                $registros ++;
                
                $aux = $ress['participantes'];
                $aux = explode(",", $aux);
                
                for($i=0; $i < count($aux); $i++){
                    if($id_users == $aux[$i]){
                        $participo ++;
                    }
                }
                
                if($ress['concluido'] == 1){
                    $concluido ++;
                    continue;
                }
                
                if(strtotime($ress['end']) < strtotime(date('Y-m-d'))){
                    $atrasado ++;
                }
            }
        }
    ?>    
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-list-alt fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $registros?></div>
                            <div>Total de Eventos</div>
                        </div>
                    </div>
                </div>
                <a href="tableCronograma.php">
                    <div class="panel-footer">
                        <span class="pull-left">Mais Detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check-square-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $concluido?></div>
                            <div>Eventos Concluidos</div>
                        </div>
                    </div>
                </div>
                <a href="tableCronograma.php">
                    <div class="panel-footer">
                        <span class="pull-left">Mais Detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-times fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $atrasado?></div>
                            <div>Eventos Atrasados</div>
                        </div>
                    </div>
                </div>
                <a href="tableCronograma.php">
                    <div class="panel-footer">
                        <span class="pull-left">Mais Detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-child fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $participo?></div>
                            <div>Eventos que Participo</div>
                        </div>
                    </div>
                </div>
                <a href="tableCronograma.php">
                    <div class="panel-footer">
                        <span class="pull-left">Mais Detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="col-lg-12">
        <h3>Integrantes do Grupo</h3><hr/>
    </div>
    <div class="row">
        <?php
        $result = $pdo->select("SELECT u.username, u.fotouser, u.email, u.prontuario FROM users u INNER JOIN grupo_has_users gu ON gu.uid = u.uid INNER JOIN grupo g ON g.idgrupo = gu.idgrupo WHERE g.aceito = 1 AND g.visto = 1 AND g.idgrupo = " . $idGrupo . "");

        foreach ($result as $res) {
            echo '<div class="col-lg-3 col-md-6">
							<div class="thumbnail">
							  <img src="' . $res['fotouser'] . '" width="242px" alt="' . $res['username'] . '">
							  <div class="caption">
								<h3>' . $res['username'] . '</h3>
								<p><i class="fa fa-envelope-o"></i> ' . $res['email'] . '</p>
								<p><i class="fa fa-key"></i> ' . $res['prontuario'] . '</p>
							  </div>
							</div>
						</div>';
        }
        ?>
    </div>
    <!-- /.row -->
    <div class="row">
        <?php
        $result = $pdo->select("SELECT g.dataCriacao,g.titulo,g.descricao,g.objetivoGeral,g.objetivoEspecifico,g.justificativa,g.tipodePesquisa,g.metodologia,g.resultadoEsperado FROM users u INNER JOIN grupo_has_users gu ON gu.uid = u.uid INNER JOIN grupo g ON g.idgrupo = gu.idgrupo WHERE g.aceito = 1 AND g.visto = 1 AND g.idgrupo = " . $idGrupo . " and u.uid = " . $id_users . "");

        foreach ($result as $res) {
            $titulo = $res['titulo'];
            $descricao = $res['descricao'];
            $objetivoGeral = isset($res['objetivoGeral']) ? $res['objetivoGeral'] : '';
            $objetivoEspecifico = isset($res['objetivoEspecifico']) ? $res['objetivoEspecifico'] : '';
            $justificativa = isset($res['justificativa']) ? $res['justificativa'] : '';
            $tipodePesquisa = isset($res['tipodePesquisa']) ? $res['tipodePesquisa'] : '';
            $metodologia = isset($res['metodologia']) ? $res['metodologia'] : '';
            $resultadoEsperado = isset($res['resultadoEsperado']) ? $res['resultadoEsperado'] : '';
        }
        ?>
        <div class="col-xs-12 col-sm-6 col-md-8">
            <h3><?php echo $titulo; ?></h3><hr/>
            <p><?php echo $descricao; ?></p>
            <h3>Justificativa</h3><hr/>
            <p><?php echo $justificativa; ?></p>
            <h3>Tipo de Pesquisa</h3><hr/>
            <p><?php echo $tipodePesquisa; ?></p>
            <h3>Metodologia de Desenvolvimento</h3><hr/>
            <p><?php echo $metodologia; ?></p>

        </div>
        <div class="col-xs-6 col-md-4">
            <h3>Objetivo Geral</h3><hr/>
            <p><?php echo $objetivoGeral; ?></p>
            <br/>
            <h3>Objetivo Espec&iacute;fico</h3><hr/>
            <p><?php echo $objetivoEspecifico; ?></p>
            <h3>Resultados Esperados</h3><hr/>
            <p><?php echo $resultadoEsperado; ?></p>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->