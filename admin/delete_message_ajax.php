<?php 
session_start();
ob_start();

	error_reporting(0);
	include_once 'includes/functions.php';
	include_once 'includes/tolink.php';
	include_once 'includes/time_stamp.php';

	$Wall = new Wall_Updates();
	
	if(isset($_POST['msg_id'])){
		$msg_id		= $_POST['msg_id'];
		$data		= $Wall->Delete_Update($_SESSION['id_login'],$msg_id);
		echo $data;
	}
?>
