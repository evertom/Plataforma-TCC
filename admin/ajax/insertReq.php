<?php
//recebo as variaveis vindo do form
$pront1 =       (filter_input(INPUT_POST, 'pront1') ? filter_input(INPUT_POST, 'pront1') : "");
$pront2 =       (filter_input(INPUT_POST, 'pront2') ? filter_input(INPUT_POST, 'pront2') : 2);
$pront3 =       (filter_input(INPUT_POST, 'pront3') ? filter_input(INPUT_POST, 'pront3') : 3);
$titulo =       (filter_input(INPUT_POST, 'titulo') ? filter_input(INPUT_POST, 'titulo') : "");
$descri =       (filter_input(INPUT_POST, 'descri') ? filter_input(INPUT_POST, 'descri') : "");
$user =         (filter_input(INPUT_POST, 'user') ? filter_input(INPUT_POST, 'user') : "");
$orientador =   (filter_input(INPUT_POST, 'orientador') ? filter_input(INPUT_POST, 'orientador') : "");
$coorient =     (filter_input(INPUT_POST, 'coorient') ? filter_input(INPUT_POST, 'coorient') : "");
$acao =         (filter_input(INPUT_POST, 'acao') ? filter_input(INPUT_POST, 'acao') : "");

if ($acao == "inserir") {
    //cincluo minha classe
    require_once('../includes/Administracao.class.php');
    try {
        //instancio minha classe
        $Administracao = new Administracao();
        //seto minhas variaveis
        $Administracao->pront1 = $pront1;
        $Administracao->pront2 = $pront2;   
        $Administracao->pront3 = $pront3;
        $Administracao->titulo = $titulo;
        $Administracao->orientador = $orientador;
        $Administracao->coorient = $coorient;
        $Administracao->user = $user;
        $Administracao->descri = $descri;
        //chamo meu metodo
        $result = $Administracao->RequerimentoProf();
        //pego o resultado e verifico se retornou   TRUE
        if ($result != false) {
            $res['msg'] = true;
            echo json_encode($res);
        } else {
            $res['msg'] = false;
            echo json_encode($res);
        }
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
}
if ($acao == "editar") {
    require_once('../class-PDO/class/TabelasDePreco.class.php');
    try {
        $TabelasDePreco = new TabelasDePreco();

        $result = $TabelasDePreco->UpdateNcmSubs($ncm, $mva, $icms_destino, $uf_origem, $uf_destino);
        if ($result != false) {
            $res['msg'] = true;
            echo json_encode($res);
        } else {
            $res['msg'] = false;
            echo json_encode($res);
        }
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
}
if ($acao == "excluir") {
    require_once('../class-PDO/class/TabelasDePreco.class.php');
    try {
        $TabelasDePreco = new TabelasDePreco();

        $result = $TabelasDePreco->excluiNcmSubs($ncm, $uf_origem, $uf_destino);
        if ($result != false) {
            $res['msg'] = true;
            echo json_encode($res);
        } else {
            $res['msg'] = false;
            echo json_encode($res);
        }
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
}
?>