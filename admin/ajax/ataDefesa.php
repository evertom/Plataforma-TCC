<?php

$idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
$iduser = isset($_POST['iduser']) ? $_POST['iduser']:"";
$tituloGrupo2 = isset($_POST['tituloGrupo2']) ? $_POST['tituloGrupo2']:"";
$prof1 = isset($_POST['prof1']) ? $_POST['prof1']:"";
$prof2 = isset($_POST['prof2']) ? $_POST['prof2']:"";
$prof3 = isset($_POST['prof3']) ? $_POST['prof3']:"";
$dia = isset($_POST['dia']) ? $_POST['dia']:"";
$horas = isset($_POST['horas']) ? $_POST['horas']:"";

require_once '../includes/Administracao.class.php';
$Administracao = new Administracao();

$Administracao->iduser = $iduser;
$Administracao->idgrupo = $idgrupo;
$Administracao->prof1 = $prof1;
$Administracao->prof2 = $prof2;
$Administracao->prof3 = $prof3;
$Administracao->tituloGrupo2 = $tituloGrupo2;
$Administracao->dia = $dia;
$Administracao->horas = $horas;

$result = $Administracao->ataDefesa();

if ($result != false) {
    $res['idAta'] = $result;
    $res['msg'] = true;
    $res['alerta'] = "Ata de defesa criada com sucesso...";
    echo json_encode($res);
} else {
    $res['msg'] = false;
    $res['alerta'] = "Falha no procedimento...";
    echo json_encode($res);
}