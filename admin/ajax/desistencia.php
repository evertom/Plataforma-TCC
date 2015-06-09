<?php
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : "";
$motivo = isset($_POST['motivo']) ? $_POST['motivo'] : "";
$idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
$descri = isset($_POST['descri']) ? $_POST['descri'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";

require_once '../includes/Administracao.class.php';
$Administracao = new Administracao();

$Administracao->iduser  = $iduser;
$Administracao->idgrupo = $idgrupo;
$Administracao->descri  = $descri;
$Administracao->name    = $name;
$Administracao->motivo  = $motivo;

$result = $Administracao->desistenciaGrupo();

if ($result != false) {
    $res['msg'] = true;
    echo json_encode($res);
} else {
    $res['msg'] = false;
    echo json_encode($res);
}