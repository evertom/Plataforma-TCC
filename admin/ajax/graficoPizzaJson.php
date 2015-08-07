<?php
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $idGrupo = isset($_GET['idGrupo']) ? $_GET['idGrupo']:"";
    
    $concluido = 0;
    $atrasado = 0;
    $registros = 0;
    $resultado = $pdo->select("SELECT * FROM evento WHERE idGrupo = $idGrupo");
    if (count($resultado)) {
        foreach ($resultado as $ress) {
            $registros ++;
            if ($ress['concluido'] == 1) {
                $concluido ++;
                continue;
            }
            if (strtotime($ress['end']) < strtotime(date('Y-m-d'))) {
                $atrasado ++;
            }
        }
    
        $data[0] = array(
                'value' => $registros,
                'color' => '#1E90FF',
                'label' => 'Total de Eventos'
                );

        $data[1] = array(
                'value' => $concluido,
                'color' => '#00FF00',
                'label' => 'Eventos Concluidos'
                );

        $data[2] = array(
                'value' => $atrasado,
                'color' => '#FF0000',
                'label' => 'Eventos Atrasados'
                );
        

        echo json_encode($data); 
        
    }else{
        $data[0] = null;
        echo json_encode($data);
    }
    
    
    