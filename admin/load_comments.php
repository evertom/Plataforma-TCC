<?php
	require_once('verifica-logado.php');
	
	$commentsarray	= $Wall->Comments($msg_id);
	
	foreach($commentsarray as $cdata){
		$msg_id_fk	= $cdata['msg_id_fk'];
		$com_id		= $cdata['com_id'];
		$comment	= $cdata['comment'];
		$time		= $cdata['created'];
		$username	= $cdata['username'];
		$uid		= $cdata['uid_fk'];
		$fotouserr	= $cdata['fotouser'];
		//$cface		= $Wall->Gravatar($id_users);
?>
		<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
			<div class="stcommentimg">
				<img src="<?php echo $fotouserr; ?>" class='small_face'/>
			</div> 
			<div class="stcommenttext">
				<?php
					if($uid == $_SESSION['id_login']){
						echo "<a class='stcommentdelete' href='#' id='".$com_id."' title='Delete Comment'><i class='fa fa-trash-o'></i></a>";	
					}
				?>
				<b><?php echo $username; ?></b> <?php echo $comment; ?>
				<div class="stcommenttime"><i class="fa fa-calendar"></i> <?php time_stamp($time); ?></div> 
			</div>
		</div>
<?php 
	}
?>