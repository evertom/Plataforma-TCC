<?php
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $idGrupo = isset($_GET['idGrupo']) ? $_GET['idGrupo']:"";
    
    $dataMin = null;
    $qtdDias = 0;
    
    $dias = $pdo->select("SELECT DATEDIFF(max(a.end), min(a.start)) AS dias, min(a.start) AS dataMin, max(a.end) AS dataMax "
            . "             FROM evento a "
            . "             WHERE a.idGrupo = {$idGrupo} "
            . "             LIMIT 1 ;");
    $pdo->desconectar();
    $qtdDias = (int)$dias[0]['dias'];
    $dataMin = date("Y-m-d", strtotime($dias[0]['dataMin']));
    
    $labels = array();
    $data = array();
    
    do {
        array_push($labels, date('M-y', strtotime($dataMin)));
        $dataMin = date("Y-m-d", strtotime("+ 30days", strtotime($dataMin)));
        array_push($data, $qtdDias);
        $qtdDias -= 30;
    }while($qtdDias > 0);
    
    $dataset_one = array("fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(220,220,220,1)",
                    "pointStrokeColor" => "#fff",
                    "label" => 'Estimativa',
                    "data" => $data
                );
    
    $dataset_two = array("fillColor" => "rgba(151,187,205,0.5)",
                    "strokeColor" => "rgba(151,187,205,1)",
                    "pointColor" => "rgba(151,187,205,1)",
                    "pointStrokeColor" => "#fff",
                    "label" => 'Realizada',
                    "data" => array(28,48,40,19,96,27,100)
                );
    
    $arrdataset = array($dataset_one,$dataset_two);
    
    $data = array('labels' => $labels,
            'datasets' => $arrdataset
        );
    
    echo json_encode($data);
            
?>