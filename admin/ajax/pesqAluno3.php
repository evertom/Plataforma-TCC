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
        $msg = "";
    } else {
        if (count($resultado)) {
            foreach ($resultado as $res) {
                $msg .="<input type='checkbox' name='pront3' required='required' value='" . $res['uid'] . "'> " . $res['username'] . " / " . $res['prontuario'] . "</input><br/>";
            }
        }
    }
echo $msg;
?>