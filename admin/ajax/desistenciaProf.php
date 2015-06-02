<?php
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : "";
$opcaoProf = isset($_POST['opcaoProf']) ? $_POST['opcaoProf'] : "";
$idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
$descri = isset($_POST['descri']) ? $_POST['descri'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";


require_once '../includes/Administracao.class.php';
$Administracao = new Administracao();

$Administracao->iduser = $iduser;
$Administracao->idgrupo = $idgrupo;
$Administracao->descri = $descri;
$Administracao->name = $name;

$result = $Administracao->desistenciaProf();

if ($result != false) {
    $res['msg'] = true;
    $res['alerta'] = "Sua orientação/coorientação foi desfeita com sucesso...";
    echo json_encode($res);
} else {
    $res['msg'] = false;
    $res['alerta'] = "Sua orientação/coorientação não foi realizada...";
    echo json_encode($res);
}