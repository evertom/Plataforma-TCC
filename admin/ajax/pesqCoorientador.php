<?php
$parametro = isset($_POST['parametro']) ? $_POST['parametro'] : null;
require_once('../includes/Conexao.class.php');
try {
    $pdo = new Conexao();
    $resultado = $pdo->select("SELECT uid,username,prontuario FROM users "
            . "WHERE username LIKE '" . $parametro . "%' AND tipo = 1 ORDER BY username ASC LIMIT 1");
    $pdo->desconectar();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$msg = "";
if (count($resultado)) {
    foreach ($resultado as $res) {
        $msg .="<div class='col-lg-2'><input type='checkbox' class='form-control' name='coorient' value='" . $res['uid'] . "'/></div> " . $res['username'] . " / " . $res['prontuario'] . "<br/>";
    }
}
echo $msg;
?>