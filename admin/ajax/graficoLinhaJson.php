<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');    
    
    
    
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $idGrupo = isset($_GET['idGrupo']) ? $_GET['idGrupo']:"";
    
    $dataMin = null;
    $qtdDias = 0;
    
    $dias = $pdo->select("SELECT max(a.end) AS dataMax "
            . "             FROM evento a "
            . "             WHERE a.idGrupo = {$idGrupo} "
            . "             LIMIT 1 ;");
    $event = $pdo->select("SELECT * FROM evento a
                            INNER JOIN tipoevento b ON a.idTipoEvento = b.id
                            WHERE a.idGrupo = {$idGrupo} 
                            ORDER BY a.end ASC");
            
    $pdo->desconectar();
    
    if(count($event)){

        $labels = array();
        $data = array();

        $dataEvent = array();
        $dtMax = new DateTime($dias[0]['dataMax']);
        
        foreach ($event as $evento){
            $end = new DateTime($evento['end']);
            array_push($labels, strftime("%b-%y", strtotime($evento['end'])));
            $intervalo_end =  $dtMax->diff($end);
            array_push($data, $intervalo_end->days);
            
            if($evento['data_conclusao'] != null && !empty($evento['data_conclusao'])){
                $dataEntrega = new DateTime($evento['data_conclusao']);
                $intervalo_entrega =  $end->diff($dataEntrega);
                if($dataEntrega < $end){
                    array_push($dataEvent, $intervalo_end->days - ($intervalo_entrega->days) );
                }else{
                    array_push($dataEvent, $intervalo_end->days + ($intervalo_entrega->days) );
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