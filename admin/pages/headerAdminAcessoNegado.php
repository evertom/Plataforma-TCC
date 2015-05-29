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
							
							$resultado = $pdo->select("SELECT count(*) as cont FROM avisos WHERE uid = ".$id_users." AND visto = 0");
							
							if(count($resultado)){
								foreach($resultado as $res){
									if($res['cont'] >0){
										echo '<span class="badgeRed">'.$res['cont'].'</span> <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>';
									}else{
										echo '<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>';
									}	
								}
							}
						?>
                        
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <?php
							$result = $pdo->select("SELECT a.idavisos,a.descricao, DATE_FORMAT(a.data, '%d/%m/%Y') as data, u.username,u.fotouser FROM avisos a INNER JOIN users u ON u.uid = a.de WHERE a.uid = ".$id_users." ORDER BY a.idavisos DESC LIMIT 10");
							
							if(count($result)){
								foreach($result as $ress){
									echo '<li>
											<a href="notificacaoEmpty.php?id='.$ress['idavisos'].'">
												<div style="margin-bottom:8px;">
													<strong><img src="'.$ress['fotouser'].'" width="25px"/> '.$ress['username'].'</strong>
													<span class="pull-right text-muted">
														<em><i class="fa fa-calendar"></i> '.$ress['data'].'</em>
													</span>
												</div>';
												if(strlen($ress['descricao']) > 130){
													$noticia = substr($ress['descricao'], 0, 130)."... <i class=\"fa fa-plus-square\"></i> leia mais";
												}else{
													$noticia = $ress['descricao'];
												}
									echo '	<div>'.$noticia.'</div>
											</a>
										</li><li class="divider"></li>';
								}
							}else{
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
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
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