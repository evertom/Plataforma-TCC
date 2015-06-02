<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">
                <h1 class="page-header">Bem vindo <span class="text-danger"><?php echo $nome_user ?></span></h1>
            </div>
            <div style="font-size:15px;"id="col-xs-6 col-md-4">
                <br/><p><i class="fa fa-quote-left"></i> Um professor que tenta ensinar, sem inspirar o aluno com desejo de aprender, est&aacute; martelando em ferro frio. (Horace Mann) <i class="fa fa-quote-right"></i></p>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <?php
                            $resu = $pdo->select("SELECT  count(gu.uid) as cont
                                                FROM grupo_has_users gu
                                                INNER JOIN grupo g ON g.idgrupo = gu.idgrupo
                                                where gu.uid = " . $id_users . "
                                                AND g.aceito = 1
                                                AND g.recusado = 0
                                                AND gu.tipo = 2
                                                group by gu.uid");
                            if (count($resu)) {
                                foreach ($resu as $res) {
                                    $total = $res['cont'];
                                }
                            } else {
                                $total = 0;
                            }
                            ?>
                            <div class="huge"><?php echo $total; ?></div>
                            <div>Grupos Orientados</div>
                        </div>
                    </div>
                </div>
                <a href="meusGrupos.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-link fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <?php
                            $resu = $pdo->select("SELECT  count(gu.uid) as cont
                                                FROM grupo_has_users gu
                                                INNER JOIN grupo g ON g.idgrupo = gu.idgrupo
                                                where gu.uid = " . $id_users . "
                                                AND g.aceito = 1
                                                AND g.recusado = 0
                                                AND gu.tipo = 3
                                                group by gu.uid");
                            if (count($resu)) {
                                foreach ($resu as $res) {
                                    $total = $res['cont'];
                                }
                            } else {
                                $total = 0;
                            }
                            ?>
                            <div class="huge"><?php echo $total; ?></div>
                            <div>Grupos Coorientados</div>
                        </div>
                    </div>
                </div>
                <a href="gruposCoorientados.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
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
                            <i class="fa fa-sitemap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <?php
                            $resu = $pdo->select("SELECT count(gu.idgrupo) as cont
                                                FROM grupo g
                                                INNER JOIN grupo_has_users gu ON gu.idgrupo = g.idgrupo
                                                INNER JOIN users u ON u.uid = gu.uid
                                                where g.aceito = 0
                                                AND g.recusado = 0
                                                AND g.revisando = 0
                                                AND gu.tipo = 2
                                                AND u.uid = " . $id_users . "");
                            if (count($resu)) {
                                foreach ($resu as $res) {
                                    $total = $res['cont'];
                                }
                            } else {
                                $total = 0;
                            }
                            ?>
                            <div class="huge"><?php echo $total; ?></div>
                            <div>Requisi&ccedil;&otilde;es</div>
                        </div>
                    </div>
                </div>
                <a href="allRequisicoes.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
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
                            <i class="fa fa-times-circle fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <?php
                            $resu = $pdo->select("SELECT count(gu.idgrupo) AS cont
                                                FROM grupo g
                                                INNER JOIN grupo_has_users gu ON gu.idgrupo = g.idgrupo
                                                INNER JOIN users u ON u.uid = gu.uid
                                                WHERE g.recusado = 1
                                                AND g.aceito = 0
                                                AND gu.tipo = 2
                                                AND u.uid = " . $id_users . "");
                            if (count($resu)) {
                                foreach ($resu as $res) {
                                    $total = $res['cont'];
                                }
                            } else {
                                $total = 0;
                            }
                            ?>
                            <div class="huge"><?php echo $total; ?></div>
                            <div>Grupos Recusados</div>
                        </div>
                    </div>
                </div>
                <a href="gruposRecusados.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="col-lg-12">
        <h3>Grupos Orientados</h3><hr/>
    </div>
    <div class="row">
        <?php
        $result = $pdo->select("SELECT u.username, u.fotouser, u.email, u.prontuario "
                . "FROM users u "
                . "INNER JOIN grupo_has_users gu ON gu.uid = u.uid "
                . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
                . "WHERE g.aceito = 1 "
                . "AND g.visto = 1 "
                . "AND g.idgrupo IN (" . $condicao . ") "
                . "AND gu.tipo in(1,2) ");

        $i = 0;
        if (count($result)) {
            foreach ($result as $res) {
                echo '<div class="col-lg-3 col-md-6">
                        <div class="thumbnail">
                          <img src="' . $res['fotouser'] . '" width="242px" alt="' . $res['username'] . '"/>
                          <div class="caption">
                                <h3>' . $res['username'] . '</h3>
                                <p><i class="fa fa-envelope-o"></i> ' . $res['email'] . '</p>
                                <p><i class="fa fa-key"></i> ' . $res['prontuario'] . '</p>
                          </div>
                        </div>
                </div>';
                $i++;
                if ($i == 4) {
                    echo '<div class="row">'
                            . '<div class="col-lg-12">'
                            . '<hr/>'
                            . '<br/>'
                            . '</div>'
                        . '</div>';
                    $i = 0;
                }
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissable">'
            . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
            . '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
            . 'Voc&ecirc; ainda n&atilde;o possui grupos em que esteja orientando,'
            . ' verifique em suas notifica&ccedil;&otilde;es se h&agrave; pend&ecirc;ncias para acertar...</div>';
        }
        ?>
    </div>
</div>
<!-- /#page-wrapper -->