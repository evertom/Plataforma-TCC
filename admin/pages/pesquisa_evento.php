<?php
	function getJsonAgenda($start, $end, $id){
		
		require_once('../../includes/Conexao.class.php');
		
		$start = $start->format("Y-m-d H:i:s");
		$end = $end->format("Y-m-d H:i:s");
		
		try {
			$pdo = new Conexao(); 
			$sql = "SELECT * FROM evento a INNER JOIN tipoEvento b ON a.idTipoEvento = b.id WHERE idGrupo = $id ";
			$sql .= "ORDER BY a.start ;";
			$resultado = $pdo->select($sql);
			
		}catch (PDOException $e){
			echo $e->getMessage();
			$pdo->desconectar();
		}	
		
		$arr = array();
		
		if(count($resultado)){
			foreach($resultado as $res){
				
				$arrayIntegrantes = ""; 
				$arrayIdusers = explode("," , $res['participantes']);
			
				foreach($arrayIdusers as $id ){
					$integrantes = $pdo->select("SELECT uid, username FROM users WHERE uid = $id ORDER BY username ;");
					if(count($integrantes)){
						foreach($integrantes as $pegaUsers){
							$arrayIntegrantes .= $pegaUsers['username']." - " ;
						}
					}
				}
				
				$arr[] = array(
					'start'				=> $res['start'],
					'end'				=> $res['end'],
					'title'				=> "Evento: ".$res['nome']." - Titulo: ".$res['nomeEvento']." - Descrição: ".$res['descricao']."Participantes: ".$arrayIntegrantes,
					'nomeEvento'		=> $res['nomeEvento'],
					'descricao'			=> $res['descricao'],
					'participantes' 	=> $res['participantes'],
					'color'				=> $res['color'],
					'textColor'			=> $res['textcolor'],
					'concluido'			=> $res['concluido'],
					'allDay'			=> $res['allday'],
					'idEvento'			=> $res['idEvento'],
					'idGrupo'			=> $res['idGrupo'],
					'idcronograma'		=> $res['idcronograma'],
					'idTipoEvento'		=> $res['idTipoEvento'],
				);
			}
		}
		
		$pdo->desconectar();
		
		return json_encode($arr);
	}
?>