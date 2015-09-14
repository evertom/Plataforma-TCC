<?php 
    session_start();
    ob_start();

    error_reporting(0);
    include_once 'includes/functions.php';
    include_once 'includes/tolink.php';
    include_once 'includes/time_stamp.php';

    $Wall = new Wall_Updates();
    $msg_id = isset($_POST['msg_id'])? $_POST['msg_id']: null;
    
    if($msg_id != null){
        $data = $Wall->Delete_Update($_SESSION['id_login'],$msg_id);
         $res['ok'] = $data;
        echo json_encode($res);
    }else{
        $res = null;
        echo json_encode($res);
    }
?>
