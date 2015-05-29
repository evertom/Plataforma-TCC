<?php
	require_once('verifica-logado.php');
	
	error_reporting(0);
	include_once 'includes/functions.php';
	include_once 'includes/tolink.php';
	include_once 'includes/time_stamp.php';
	include_once 'session.php';

	$Wall = new Wall_Updates();
	
	if(isSet($_POST['comment'])){
		$comment	= $_POST['comment'];
		$msg_id		= $_POST['msg_id'];
		$ip			= $_SERVER['REMOTE_ADDR'];
		
		$cdata		= $Wall->Insert_Comment($id_users,$msg_id,$comment,$ip);
		
		if($cdata){
			foreach($cdata as $rescom){
				$com_id		= $rescom['com_id'];
				$comment	= $rescom['comment'];
				$time		= $rescom['created'];
				$username	= $rescom['username'];
				$uid		= $rescom['uid_fk'];
			}
			//$cface		= $Wall->Gravatar($id_users);
?>
			<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
				<div class="stcommentimg">
					<img src="<?php echo $fotouser; ?>" class='small_face'/>
				</div> 
				<div class="stcommenttext" id="<?php echo $com_id; ?>">
					<div style="float:right;" class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
							<li><a class="EditaComentPost"><i class="fa fa-edit"></i> Editar</a></li>
							<li><a class="stcommentdelete" href="#" id="<?php echo $com_id; ?>" title="Delete Comment"><i class="fa fa-trash-o"></i> Excluir</a></li>	
						</ul>
					</div>
					<b><?php echo $username; ?></b>
					<div class="EditarComment postC">
						<?php echo $comment; ?>
					</div>
					<div class="stcommenttime"><i class="fa fa-calendar"></i> <?php time_stamp($time); ?></div><br/>
					<div class="stcommenttime"><i class='fa fa-thumbs-o-up'></i> Curtir</div>
				</div>
			</div>
<?php
		}
	}
?>