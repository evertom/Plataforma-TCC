<?php
$parametro = isset($_POST['parametro']) ? $_POST['parametro'] : null;
require_once('../includes/Conexao.class.php');
try {
    $pdo = new Conexao();
    $resultado = $pdo->select("SELECT uid,username,prontuario FROM users "
            . "WHERE username LIKE '" . $parametro . "%' AND tipo = 0 "
            . "ORDER BY username ASC LIMIT 1");
    $pdo->desconectar();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$msg = "";
if (count($resultado)) {
    foreach ($resultado as $res) {
        $msg .="<input type='checkbox' name='pront3' value='" . $res['uid'] . "'> " . $res['username'] . " / " . $res['prontuario'] . "</input><br/>";
    }
}
echo $msg;
?>