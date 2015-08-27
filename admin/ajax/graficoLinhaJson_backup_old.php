<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');    
    
    
    
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $idGrupo = isset($_GET['idGrupo']) ? $_GET['idGrupo']:"";
    
    $dataMin = null;
    $qtdDias = 0;
    
    $dias = $pdo->select("SELECT DATEDIFF(max(a.end), min(a.start)) AS dias, min(a.start) AS dataMin, max(a.end) AS dataMax "
            . "             FROM evento a "
            . "             WHERE a.idGrupo = {$idGrupo} "
            . "             LIMIT 1 ;");
    $event = $pdo->select("SELECT * FROM evento a
                            INNER JOIN tipoevento b ON a.idTipoEvento = b.id
                            WHERE a.idGrupo = {$idGrupo} 
                            ORDER BY a.start ASC");
            
    $pdo->desconectar();
    
    if(count($event)){

        $qtdDias = (int)$dias[0]['dias'];
        $diasTotais = (int)$dias[0]['dias'];
        $qtdEventos = (int)count($event);

        if($qtdEventos != 0){
            $razaoEvento = (int)($qtdDias / $qtdEventos);
        }else{
            $razaoEvento = 30;
        }

        $dataMin = date("Y-m-d", strtotime($dias[0]['dataMin']));
        $dtMax = new DateTime($dias[0]['dataMax']);
        $dtMin = new DateTime($dias[0]['dataMin']);

        $labels = array();
        $data = array();

        do{
            array_push($labels, strftime("%b-%y", strtotime($dataMin)));
            $dataMin = date("Y-m-d", strtotime("+ $razaoEvento days", strtotime($dataMin)));
            array_push($data, $qtdDias);
            $qtdDias -= $razaoEvento;
        }while($qtdDias > 0);

        $dataEvent = array();
        foreach ($event as $evento){
            if($evento['data_conclusao'] != null && !empty($evento['data_conclusao'])){
                $dataEntrega = new DateTime($evento['data_conclusao']);
                $intervalo =  $dtMin->diff($dataEntrega);
                if(($diasTotais - $intervalo->days > 0)){
                    array_push($dataEvent, $diasTotais - $intervalo->days);
                }else{
                    array_push($dataEvent, $intervalo->days - $diasTotais); 
                }
                
            }
        }


        $dataset_one = array("fillColor" => "rgba(220,220,220,0.5)",
                        "strokeColor" => "rgba(220,220,220,1)",
                        "pointColor" => "rgba(220,220,220,1)",
                        "pointStrokeColor" => "#fff",
                        "label" => 'Estimativa em dias',
                        "data" => $data
                    );

        $dataset_two = array("fillColor" => "rgba(151,187,205,0.5)",
                        "strokeColor" => "rgba(151,187,205,1)",
                        "pointColor" => "rgba(151,187,205,1)",
                        "pointStrokeColor" => "#fff",
                        "label" => 'Realizada em dias',
                        "data" => $dataEvent
                    );

        $arrdataset = array($dataset_one,$dataset_two);

        $data = array('labels' => $labels,
                'datasets' => $arrdataset
            );
    }else{
        $data = null;
    }
    echo json_encode($data);
            
?>