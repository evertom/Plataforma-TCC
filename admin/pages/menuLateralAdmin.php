<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a class="active" href="panel.php"><i class="fa fa-dashboard fa-fw"></i> Painel</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Gr&aacute;ficos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="cronogramaLinha.php">Desempenho</a>
                    </li>
                    <li>
                        <a href="cronogramaPizza.php">Cronograma</a>
                    </li>
                    <li>
                        <a href="graficoWorkflow.php">Workflow</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-calendar fa-fw"></i> Cronograma<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="timeLine.php">Linha do Tempo</a>
                    </li>
                    <li>
                        <a href="cronograma.php">Cronograma Calendario</a>
                    </li>
                    <li>
                        <a href="tableCronograma.php">Cronograma Tabela</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-sliders"></i> &nbsp;Workflow <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="workflow.php">Fluxo do Trabalho</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-cloud-upload"></i> &nbsp;Envios <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="enviaPDF.php">Upload de arquivos </a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="videoConferencia.php"><i class='fa fa-video-camera'></i> &nbsp;Vídeo Conferência</a>
            </li>
            <?php
            if ($cargo_users === 'Admin') {
                echo '<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Administra&ccedil;&atilde;o<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="addProf.php">Adicionar Professores</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>';
            }
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->