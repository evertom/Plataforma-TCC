<?php
session_start();
ob_start();

	error_reporting(0);
	include_once 'includes/functions.php';
	include_once 'includes/tolink.php';
	include_once 'includes/time_stamp.php';
		
	$Wall = new Wall_Updates();
	
	if(isset($_POST['com_id'])){
		
		$com_id		= $_POST['com_id'];
		$data		= $Wall->Delete_Comment($_SESSION['id_login'],$com_id);
		echo $data;
	}
?>
