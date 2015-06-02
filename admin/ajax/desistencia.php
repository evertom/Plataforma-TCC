<?php
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : "";
$motiProf = isset($_POST['motiProf']) ? $_POST['motiProf'] : "";
$motiGrupo = isset($_POST['motiGrupo']) ? $_POST['motiGrupo'] : "";
$idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
$descri = isset($_POST['descri']) ? $_POST['descri'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";

if ($motiProf === "" && $motiGrupo === "") {
    $res['msg'] = false;
    $res['escrita'] = "Marque uma das caixas de seleção";
    echo json_encode($res);
} else {
    require_once '../includes/Administracao.class.php';
    $Administracao = new Administracao();

    $Administracao->iduser = $iduser;
    $Administracao->idgrupo = $idgrupo;
    $Administracao->descri = $descri;
    $Administracao->name = $name;

    $result = $Administracao->desistenciaGrupo();

    if ($result != false) {
        $res['msg'] = true;
        echo json_encode($res);
    } else {
        $res['msg'] = false;
        echo json_encode($res);
    }
}
    



