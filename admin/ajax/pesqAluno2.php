<?php
error_reporting(0);
$parametro = isset($_POST['parametro']) ? $_POST['parametro'] : null;
require_once('../includes/Conexao.class.php');
try {
    $pdo = new Conexao();
    $resultado = $pdo->select("SELECT uid,username,prontuario FROM users "
            . "WHERE username LIKE '" . $parametro . "%' AND tipo = 0 "
            . "ORDER BY username ASC LIMIT 1");
    
} catch (PDOException $e) {
    echo $e->getMessage();
}
$msg = "";

    $busca = $pdo->select("SELECT * FROM grupo_has_users gh WHERE gh.uid = {$resultado[0]['uid']}");
    $pdo->desconectar();
    if (count($busca)) {
        $msg = "Aluno já está em um Grupo de TCC...";
    } else {
        if (count($resultado)) {
            foreach ($resultado as $res) {
                $msg .="<div class='col-lg-2'><input type='checkbox' class='form-control' name='pront2' required='required' value='" . $res['uid'] . "'/></div> " . $res['username'] . " / " . $res['prontuario'] . "<br/>";
            }
        }
    }
echo $msg;
?>