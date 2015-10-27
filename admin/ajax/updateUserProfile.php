<?php

$id_users = isset($_POST['id_users']) ? $_POST['id_users'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$nick = isset($_POST['nick']) ? $_POST['nick'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$pass = isset($_POST['pass']) ? $_POST['pass'] : "";
$prontuario = isset($_POST['prontuario']) ? $_POST['prontuario'] : "";
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
$descri = isset($_POST['descri']) ? $_POST['descri'] : "";
$acao = isset($_POST['acao']) ? $_POST['acao'] : "";

if ($acao == "inserir") {
    require_once('../includes/Administracao.class.php');
    try {
        $Administracao = new Administracao();

        $Administracao->id_users = $id_users;
        $Administracao->nome = $name;
        $Administracao->nick = $nick;
        $Administracao->email = $email;
        $Administracao->pass = $pass;
        $Administracao->pront = $prontuario;
        $Administracao->cargo = $cargo;
        $Administracao->descri = $descri;

        $result = $Administracao->UpdateUserProfile();
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