<?php
@session_start();
ob_start();
$id_users = isset($_SESSION['id_login']) ? $_SESSION['id_login'] : "";
$nome_user = isset($_SESSION['user']) ? $_SESSION['user'] : "";
$email_users = isset($_SESSION['email_login']) ? $_SESSION['email_login'] : "";
$pass_users = isset($_SESSION['pass_login']) ? $_SESSION['pass_login'] : "";
$fotouser = isset($_SESSION['fotouser']) ? $_SESSION['fotouser'] : "";
$descricao_users = isset($_SESSION['descricao']) ? $_SESSION['descricao'] : "";
$cargo_users = isset($_SESSION['cargo']) ? $_SESSION['cargo'] : "";
$prontuario_users = isset($_SESSION['prontuario']) ? $_SESSION['prontuario'] : "";
$tipo_users = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : "";
$logado = isset($_SESSION['logado']) ? $_SESSION['logado'] : "N";

date_default_timezone_set('America/Sao_Paulo');

if ($logado == "N" && $id_users == "") {
    echo "<script type='text/javascript'>location.href='../'</script>";
    exit();
}