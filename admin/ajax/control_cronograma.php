<?php
	require_once('../verifica-logado.php');
	date_default_timezone_set("America/Sao_Paulo");
	
	$operation =	isset($_POST['operation']) ? $_POST['operation']:"";
	$case =		isset($_POST['case']) ? $_POST['case']:"";
	
	if($operation == "CRUD"){
		
		$start =                isset($_POST['start']) ? $_POST['start']:"";
		$end = 			isset($_POST['end']) ? $_POST['end']:"";
		$allday =		isset($_POST['allday']) ? $_POST['allday']:"";
		$idGrupo = 		isset($_POST['idGrupo']) ? $_POST['idGrupo']:"";
		$participantes = 	isset($_POST['participantes']) ? $_POST['participantes']:"";
		$nomeEvento = 		isset($_POST['nomeEvento']) ? $_POST['nomeEvento']:"";
		$descricao = 		isset($_POST['descricao']) ? $_POST['descricao']:"";
		$idCronograma = 	isset($_POST['idCronograma']) ? $_POST['idCronograma']:"";
		$idEvento = 		isset($_POST['idEvento']) ? $_POST['idEvento']:"";
		$idTipoEvento = 	isset($_POST['idTipoEvento']) ? $_POST['idTipoEvento']:"";
		$isClonclusion = 	isset($_POST['isClonclusion']) ? $_POST['isClonclusion']:"";
		
		if($allday == "false"){$allday = false;}else{$allday=true;}
		if($isClonclusion == "true"){$isClonclusion = true;}else{$isClonclusion=false;}
		$start = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $start)));
		$end = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $end)));
		
		switch ($case){
		
			case "INSERT":
				//Aqui para insert, mas antes vericica se existe um cronograma criado
				if($idCronograma == "" || $idCronograma == null){
					require_once('../includes/Cronograma.class.php');
					try {
						$Cronograma = new Cronograma(); 
						
						$Cronograma->start = $start;
						$Cronograma->end = $end;
						$Cronograma->allday = (bool)$allday;
						$Cronograma->idgrupo = (int)$idGrupo;
						$Cronograma->participantes = $participantes;
						$Cronograma->nomeEvento = $nomeEvento;
						$Cronograma->descricao = $descricao;
						$Cronograma->idCronograma = (int)$idCronograma;
						$Cronograma->idEvento = (int)$idEvento;
						$Cronograma->idTipoEvento = (int)$idTipoEvento;
						$Cronograma->aprovado = false;
						$Cronograma->analisando = true;
						$Cronograma->revisando = false;
						$Cronograma->enviado = true;
						$Cronograma->isClonclusion = (bool)$isClonclusion;
						$Cronograma->uid = (int)$id_users;
						
						$result = $Cronograma->insertCronograma();
						if($result != false){
							$res['msg'] = true;
							echo json_encode($res);
						}else{
							$res['msg'] = false;
							echo json_encode($res);
						}
					}catch (PDOException $e){
						echo json_encode($e->getMessage());
					}
				}else{
					require_once('../includes/Cronograma.class.php');
					try {
						$Cronograma = new Cronograma(); 
						
						$Cronograma->start = $start;
						$Cronograma->end = $end;
						$Cronograma->allday = (bool)$allday;
						$Cronograma->idgrupo = (int)$idGrupo;
						$Cronograma->participantes = $participantes;
						$Cronograma->nomeEvento = $nomeEvento;
						$Cronograma->descricao = $descricao;
						$Cronograma->idCronograma = (int)$idCronograma;
						$Cronograma->idEvento = (int)$idEvento;
						$Cronograma->idTipoEvento = (int)$idTipoEvento;
						$Cronograma->isClonclusion = (bool)$isClonclusion;
						$Cronograma->uid = (int)$id_users;

						$result = $Cronograma->insertEvento();
						if($result != false){
							$res['msg'] = true;
							echo json_encode($res);
						}else{
							$res['msg'] = false;
							echo json_encode($res);
						}
					}catch (PDOException $e){
						echo json_encode($e->getMessage());
					}	
					
				}
			break;
			
			case "DELETE":
				require_once('../includes/Cronograma.class.php');
				try {
					$Cronograma = new Cronograma(); 
					
					$Cronograma->idEvento = (int)$idEvento;
                                        $Cronograma->uid = (int)$id_users;
                                        $Cronograma->idgrupo = (int)$idGrupo;
					
					$result = $Cronograma->deleteCronograma();
					if($result != false){
						$res['msg'] = true;
						echo json_encode($res);
					}else{
						$res['msg'] = false;
						echo json_encode($res);
					}
				}catch (PDOException $e){
					echo json_encode($e->getMessage());
				}	
			
			break;
			
			case "UPDATE":
				require_once('../includes/Cronograma.class.php');
				try{
					$Cronograma = new Cronograma(); 
					
					$Cronograma->start = $start;
					$Cronograma->end = $end;
					$Cronograma->allday = (bool)$allday;
					$Cronograma->idgrupo = (int)$idGrupo;
					$Cronograma->participantes = $participantes;
					$Cronograma->nomeEvento = $nomeEvento;
					$Cronograma->descricao = $descricao;
					$Cronograma->idCronograma = (int)$idCronograma;
					$Cronograma->idEvento = (int)$idEvento;
					$Cronograma->idTipoEvento = (int)$idTipoEvento;
					$Cronograma->isClonclusion = (bool)$isClonclusion;
					$Cronograma->uid = (int)$id_users;

					$result = $Cronograma->updateEvento();
					if($result != false){
						$res['msg'] = true;
						echo json_encode($res);
					}else{
						$res['msg'] = false;
						echo json_encode($res);
					}
				}catch (PDOException $e){
					echo json_encode($e->getMessage());
				}
			break;
		}
	}
	if($operation == "dataTable"){
		
		$idGrupo =	isset($_POST['idGrupo']) ? $_POST['idGrupo']:"";
		
		if($idGrupo != ""){
			require_once('../includes/Cronograma.class.php');
			try {
				$Cronograma = new Cronograma(); 
				
				$Cronograma->idGrupo = (int)$idGrupo;
				
				$result = $Cronograma->getCompleteEvents();
					$html = '<table id="table" class="table table-striped" cellspacing="0" width="100%">';
					$html .='<thead><th width="80px">Data</th><th>Limite / Horário</th><th>Tipos Eventos</th><th>Responsavéis</th><th>Concluido</th><th>Info</th><th>Excluir</th></thead>';
					$html .='<tfoot><th>Data</th><th>Limite / Horário</th><th>Tipos Eventos</th><th>Responsavéis</th><th>Concluido</th><th>Info</th><th>Excluir</th></tfoot>';
					$html .="<tbody>";
					$form = "";
				if(count($result)){
					
					foreach($result as $res){
						
						$arrayIdusers = explode("," , $res['participantes']);
						$arrayIntegrantes = "";
						$readOnly = "disabled";
						
						foreach($arrayIdusers as $id ){
							$integrantes = $Cronograma->getUserNames($id);
							if($id == $id_users){
								$readOnly = "";
							}
							if(count($integrantes)){
								foreach($integrantes as $pegaUsers){
									$arrayIntegrantes .= $pegaUsers['username']." ; ";
								}
							}
						}
						
						$html .= "<tr value='".$res['idEvento']."'>";
						$html .= "<td>".date("d-m-Y", strtotime($res['start']))."</td>";
						if($res['id'] == 2){
							$html .= "<td>".date("H:i:s",strtotime($res['start']))."</td>";
						}else{
							$html .= "<td>".date("d-m-Y",strtotime($res['end']))."</td>";
						}
						$html .= "<td>".$res['nome']."</td>";
						$html .= "<td>".$arrayIntegrantes."</td>";
						if($res['concluido'] == 1 || $res['concluido'] == true){
							$html .= "<td>
										<input checked onchange='SetUpdates($(this));' $readOnly data-on-color='success' data-off-color='danger' data-size='mini' id='isClonclusion' name='isClonclusion' type='checkbox' data-off-text='Não' data-on-text='Sim'/>
									  </td>";
						}else{
							$html .= "<td>
										<input onchange='SetUpdates($(this));' $readOnly data-on-color='success' data-off-color='danger' data-size='mini' id='isClonclusion' name='isClonclusion' type='checkbox' data-off-text='Não' data-on-text='Sim'/>
									  </td>";
						}
						$html .= "<td>
									<div class='form-group input-group btn-group-xs'>
										<button onclick='GetInfo(".$res['idEvento'].");' style='margin: 0px auto;' class='btn btn-info'  type='button'><i class='fa fa-info-circle'></i></button>
									</div>
								  </td>";
						$html .= "<td>
									<div class='form-group input-group btn-group-xs'>
										<button $readOnly style='margin: 0px auto;' class='btn btn-danger' onclick='DeleteEvent($(this));' type='button'><i class='fa fa-times-circle'></i></button>
									</div>
								  </td>";
						$html .= "</tr>";
						
						$idcronograma = $res['idcronograma'];
					}
					
					$html .= "</tbody>";
					$html .= "</table>";
					
					if($tipo_users == 1 ){
					$form = "<form id='respostaCrono'>
								<div style='margin: 0px auto; width: 100%;'>
									<div class='form-group input-group' style='width: 100%;'>
										<h2>Mensagem <small>Observações sobre o cronograma</small></h2>
										<textarea style='resize: none;' class='form-control' id='analises' name='analises' rows='4' cols='100' placeholder='Descri&ccedil;&atilde;o' required></textarea>
									</div>
									<div class='form-group input-group'>
										<button onclick='sendMsg();' style='margin-left: 10px' class='btn btn-primary' type='button'>Enviar <i class='fa fa-share-square'></i></button>
										<button style='margin-left: 10px' class='btn btn-warning' id='resalvas' type='reset'>Limpar <i class='fa fa-eraser'></i></button>
									</div>
								</div>
							</form>";
					}
					echo $html.$form;
				}else{
					$html .= "</tbody></table>";
					echo $html;
				}
			}catch (PDOException $e){
				echo json_encode($e->getMessage());
			}	
		}else{
                    $html = '<table id="table" class="table table-striped" cellspacing="0" width="100%">';
                    $html .='<thead><th>Data</th><th>Limite / Horário</th><th>Tipos Eventos</th><th>Responsavéis</th><th>Concluido</th><th>Info</th><th>Excluir</th></thead>';
                    $html .='<tfoot><th>Data</th><th>Limite / Horário</th><th>Tipos Eventos</th><th>Responsavéis</th><th>Concluido</th><th>Info</th><th>Excluir</th></tfoot>';
                    $html .="<tbody></tbody>";
                    $html .="</table>";
                    echo $html;
		}
	}
	if($operation == "GetInfo"){
            $idEvento =	isset($_POST['idEvento']) ? $_POST['idEvento']:"";
            require_once('../includes/Cronograma.class.php');
            try {
                $Cronograma = new Cronograma(); 
                $Cronograma->idEvento = (int)$idEvento;

                $result = $Cronograma->getInfoTable();

                $html = "";

                if(count($result)){
                    foreach($result as $res){
                        $html .= "<h4>Nome do evento: <small>".$res['nomeEvento']."</small></h4>";
                        $html .= "<h4>Descrição: <small>".$res['descricao']."</small></h4>";
                    }
                }
                echo $html;
            }catch (PDOException $e){
                    echo json_encode($e->getMessage());
            }	
	}
	if($operation == "UpdateTable"){
		
            $idEvento =	isset($_POST['idEvento']) ? $_POST['idEvento']:null;
            $Checked =	isset($_POST['Checked']) ? $_POST['Checked']: null;
            $Delete =	isset($_POST['Delete']) ? $_POST['Delete']: null;

            if($Delete == "true" || $Delete == true){
                require_once('../includes/Cronograma.class.php');
                try {
                    $Cronograma = new Cronograma(); 
                    $Cronograma->idEvento = (int)$idEvento;

                    $result = $Cronograma->deleteCronograma();

                    if($result){
                        $res['msg'] = true;
                    }else{
                        $res['msg'] = false;
                    }
                    echo json_encode($res);
                }catch (PDOException $e){
                    echo json_encode($e->getMessage());
                }	
            }else{
                require_once('../includes/Cronograma.class.php');
                
                if($Checked == "true"){
                    $Checked = true;
                }else{
                    $Checked = false;
                }
                try {
                    $Cronograma = new Cronograma(); 
                    $Cronograma->idEvento = (int)$idEvento;
                    $Cronograma->isClonclusion = $Checked;

                    
                    $result = $Cronograma->checkedCronograma();

                    if($result){
                        $res['msg'] = true;
                    }else{
                        $res['msg'] = false;
                    }
                    echo json_encode($res);
                }catch (PDOException $e){
                    echo json_encode($e->getMessage());
                }	
            }
	}
	if($operation == "timeline"){
		
		$idGrupo = 	isset($_POST['idGrupo']) ? $_POST['idGrupo']:"";
		
		require_once('../includes/Cronograma.class.php');
		
		try {
                    $Cronograma = new Cronograma(); 
                    $Cronograma->idGrupo = (int)$idGrupo;

                    $result = $Cronograma->getListName();

                    $html = "";

                    if(count($result)){
                        $names = "";
                        foreach($result as $res){
                            $titulo = $res['titulo'];
                            $descricao = $res['descricao'];
                            if($res['tipo'] == 1){
                                $names .= "<h4>Aluno: <small>";
                            }else if($res['tipo'] == 2){
                                $names .= "<h4>Orientador: <small>";
                            }else{
                                $names .= "<h4>Co-Orientador: <small>";
                            }
                            $names .= $res['username']."</small></h4>";
                        }
                    }

                    $html .= "<div class='page-header'>
                                <h1 id='timeline'>Linha do Tempo </h1>
                                <h3>$titulo <small>$descricao</small></h3>
                                $names
                            </div>";

                    $result = $Cronograma->getCompleteEvents();

                    if(count($result)){

                        $html .= "<ul class='timeline'>";

                        foreach($result as $res){

                            $arrayIdusers = explode("," , $res['participantes']);
                            $arrayIntegrantes = "";


                            foreach($arrayIdusers as $id ){
                                $integrantes = $Cronograma->getUserNames($id);
                                if($id == $id_users){
                                    $readOnly = "";
                                }
                                if(count($integrantes)){
                                    foreach($integrantes as $pegaUsers){
                                        $arrayIntegrantes .= $pegaUsers['username']." ; ";
                                    }
                                }
                            }

                            $class = "";					

                            if(rand(1, 2) == 2){
                                $class = "class='timeline-inverted'";
                            }

                            $end = date('Y-m-d', strtotime($res['end']));

                            $situacao= "";
                            $dataConcluido= "";
                            
                            if($res['concluido'] == 1 ){
                                $situacao= "<div style='color: green;float: right!important;width: 25px;position: relative!important;right: 10px;'><i class='fa fa-2x fa-check-circle'></i></div>";
                                $dataConcluido = "<small class='text-muted'><i class='glyphicon glyphicon-time'></i> Concluido ".date("d-m-Y H:i:s", strtotime($res['data_conclusao']))."</small>";
                            }else if(strtotime($end) > strtotime(date('Y-m-d'))){
                                $situacao= "<div style='color: blue; float: right!important;width: 25px;position: relative!important;right: 10px;'><i class='fa fa-2x fa-exclamation'></i></div>";
                            }else{
                                $situacao = "<div style='color: red; float: right!important;width: 25px;position: relative!important;right: 10px;'><i class='fa fa-2x fa-pencil-square-o'></i></div>";
                            }
                            
                            
                            $html .= "<li $class>
                                        <div class='timeline-badge' style='background-color: ".$res['color']."!important;'>".$res['imagem']."</div>
                                            <div class='timeline-panel'>
                                                <div class='timeline-heading'>
                                                    <h4 class='timeline-title'>".$res['nome']."</h4>$situacao
                                                        <p>
                                                            <small class='text-muted'><i class='glyphicon glyphicon-time'></i> Data ".date("d-m-Y", strtotime($res['start']))."</small>
                                                            <br/><small class='text-muted'><i class='glyphicon glyphicon-time'></i> Limite ".date("d-m-Y", strtotime($res['end']))."</small>
                                                            <br/>$dataConcluido
                                                        </p>
                                                </div>
                                            <div class='timeline-body'>
                                                <h4><small>".$res['nomeEvento']."</small></h4>
                                                <hr></hr>
                                                <p>".$res['descricao']."</p>
                                                <hr></hr>
                                                <p>".$arrayIntegrantes."</p>
                                            </div>
                                        </div>	
                                </li>";
                    }

                    $html .= "</ul>";
                }else{
                    $html .= "<h1>Sem Cronograma :( </h1>";
                }
                echo $html;
            }catch (PDOException $e){
                echo json_encode($e->getMessage());
            }	
	
	}
	if($operation == "MSG"){
		
            $idGrupo = 	isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
            $msg = 	isset($_POST['msg']) ? $_POST['msg']:"";
            $uid = 	isset($_POST['myID']) ? $_POST['myID']:"";

            require_once('../includes/Cronograma.class.php');

            try {

                $Cronograma = new Cronograma(); 
                $Cronograma->idgrupo = (int)$idGrupo;
                $Cronograma->msg = $msg;
                $Cronograma->uid = (int)$uid;

                $result = $Cronograma->sendMsg();

                if($result){
                    $res['msg'] = true;
                }else{
                    $res['msg'] = false;
                }
                echo json_encode($res);
            }catch (PDOException $e){
                echo json_encode($e->getMessage());
            }	
	}
	
?>