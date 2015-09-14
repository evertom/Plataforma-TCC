<?php
    session_start();
    ob_start();
    error_reporting(0);
    include_once 'includes/functions.php';
    include_once 'includes/tolink.php';
    include_once 'includes/time_stamp.php';

    $Wall = new Wall_Updates();
    $com_id = isset($_POST['com_id'])?$_POST['com_id']: null;
    
    if($com_id != null){
        $data = $Wall->Delete_Comment($_SESSION['id_login'],$com_id);
        $res['ok'] = $data;
        echo json_encode($res);
    }else{
        $res = null;
        echo json_encode($res);
    }
?>
