<?php
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $operation = isset($_POST['operation']) ? $_POST['operation']:"";
    $idGrupo = 	 isset($_POST['idGrupo']) ? $_POST['idGrupo']:"";
    
    $result = $pdo->select("SELECT b.username, c.titulo, a.tipo, c.descricao "
                    . "FROM grupo_has_users a INNER JOIN users b ON a.uid =  b.uid "
                    . "INNER JOIN grupo c ON c.idgrupo = a.idgrupo "
                    . "WHERE a.idgrupo = {$idGrupo} ORDER BY a.tipo ");
            
    $html = "";

    if (count($result)){
        $names = "";
        foreach ($result as $res) {
            $titulo = $res['titulo'];
            $descricao = $res['descricao'];
            if ($res['tipo'] == 1) {
                $names .= "<h4>Aluno: <small>";
            } else if ($res['tipo'] == 2) {
                $names .= "<h4>Orientador: <small>";
            } else {
                $names .= "<h4>Co-Orientador: <small>";
            }
            $names .= $res['username'] . "</small></h4>";
        }
    }

    $html .= "<div class='page-header'>"
            . "<h3>$titulo "
            . "<small>$descricao</small></h3>"
            . "$names</div>";