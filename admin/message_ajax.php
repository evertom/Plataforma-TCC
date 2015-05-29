<?php
	require_once('verifica-logado.php');
	
	error_reporting(0);
	include_once 'includes/functions.php';
	include_once 'includes/tolink.php';
	include_once 'includes/time_stamp.php';
		
	$Wall = new Wall_Updates();
	
	if(isSet($_POST['update'])){
		$update	= $_POST['update'];
		
		$data	= $Wall->Insert_Update($id_users,$update);
		if(isset($data)){
			foreach($data as $res){
				$msg_id		= $res['msg_id'];	
				$message	= $res['message'];
				$time		= $res['created'];
				$uid		= $res['uid_fk'];
				$username	= $res['username'];
			}
			$face		= $Wall->Gravatar($id_users);
?>
			<div class="stbody" id="stbody<?php echo $msg_id;?>">
				<div class="stimg">
					<img src="<?php echo $face;?>" class='big_face'/>
				</div> 
				<div class="sttext">
					<b><?php echo $username;?></b>
					<div style="float:right;" class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
							<li><a class="EditarPostBt"><i class="fa fa-edit"></i> Editar</a></li>
							<li><a class="stdelete" href="#" id="<?php echo $msg_id;?>" title="Delete update"><i class="fa fa-trash-o"></i> Excluir</a></li>
						</ul>
					</div>
					<div class="sttime">
						<i class="fa fa-calendar"></i> <?php time_stamp($time);?>
					</div><br/> <br/> 
				</div> 
				<div class="boxPost">
					<div class="EditarPost postN">
						<?php echo $message;?>
					</div>
					<div class="sttime">
						<i class='fa fa-thumbs-o-up'></i> Curtir | <a href='#' class='commentopen' id='<?php echo $msg_id;?>' title='Comment'><i class='fa fa-comments-o'></i> Comentar </a>
					</div>
					<div id="stexpandbox">
						<div id="stexpand"></div>
					</div>
					<div class="commentcontainer" id="commentload<?php echo $msg_id;?>">
						<?php// include('load_comments.php') ?>
					</div>
					<div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id;?>'>
						<div class="stcommentimg">
							<img src="<?php echo $face;?>" class='small_face'/>
						</div> 
						<div class="stcommenttext" >
							<form method="post" action="">
								<textarea name="comment" class="comment meuform" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>
								<br/>
								<input type="submit"  value=" Comentar "  id="<?php echo $msg_id;?>" class="comment_button btn btn-primary btn-xs"></input>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
?>
