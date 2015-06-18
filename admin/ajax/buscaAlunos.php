<?php
$idGrupo =  isset($_POST['idGrupo']) ? $_POST['idGrupo']:'';
$myid =     isset($_POST['myid']) ? $_POST['myid']:'';

require_once '../includes/Conexao.class.php';
$Conexao = new Conexao();

$result = $Conexao->select("SELECT * FROM grupo_has_users gu "
        . "INNER JOIN users u ON u.uid = gu.uid "
        . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
        . "WHERE gu.uid <> {$myid} "
        . "AND gu.idgrupo = {$idGrupo}");

echo json_encode($result);