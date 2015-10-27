<?php
@session_start;
require_once('verifica-logado.php');
require_once('includes/functions.php');
require_once('includes/time_stamp.php');

$page = $_POST['page'];
$qntd = 10;

$inicio = $qntd * $page;

$Wall = new Wall_Updates();
$updatesarray = $Wall->UpdatesAjax($id_users, $inicio, $qntd);

if (count($updatesarray)) {
    $aux = 1;
    $_SESSION['primeiravez'] = 1;
    foreach ($updatesarray as $data) {
        $msg_id = $data['msg_id'];
        $message = $data['message'];
        $time = $data['created'];
        $username = $data['username'];
        $uid = $data['uid_fk'];
        $fotouserr = $data['fotouser'];
        //$face			= $Wall->Gravatar($id_users);
        ?>
        <div class="stbody" id="stbody<?php echo $msg_id; ?>">
            <div class="stimg">
                <img src="<?php echo $fotouserr; ?>" class='big_face'/>
            </div> 
            <div class="sttext">
                <b><?php echo $username; ?></b> 
                <?php
                if ($uid == $_SESSION['id_login']) {
                    echo '
					<div style="float:right;" class="btn-group">
						  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						  </button>
						  <ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
							<li><a  class="" onclick="EditarPostBt(this)"><i class="fa fa-edit"></i> Editar</a></li>
							<li><a class="" onclick="stdelete(this)" href="#" id="' . $msg_id . '" title="Delete update"><i class="fa fa-trash-o"></i> Excluir</a></li>
						  </ul>
						</div>
					';
                } else {
                    
                }
                ?>
                <div class="sttime">
                    <i class="fa fa-calendar"></i> <?php time_stamp($time); ?>
                </div><br/><br/>
            </div>
            <div class="boxPost">

                <?php
                if ($uid == $_SESSION['id_login']) {
                    echo '<div class="EditarPost postN">';
                } else {
                    echo '<div class="postN">';
                }
                ?>
                <?php echo $message; ?>

            </div>
            <div class="sttime">
                <?php
                require_once('includes/Conexao.class.php');
                $pdo = new Conexao();

                $result = $pdo->select("SELECT * FROM likes WHERE msg_id = " . $msg_id . " AND uid = " . $id_users . "");
                if (count($result)) {

                    $result = $pdo->select("SELECT count(msg_id) as total FROM likes WHERE msg_id = " . $msg_id . "");
                    foreach ($result as $res) {
                        $total = $res['total'];
                    }
                    echo "<a class='unlike' onclick='unlike(this)' ><i class='fa fa-thumbs-o-down'></i> Descutir</a> <div class='likethis'><span class='badge'>" . $total . "</span></div> | <a class='commentopen'  onclick='commentopen(this)' id='" . $msg_id . "' title='Comment'><i class='fa fa-comments-o'></i> Comentar </a>";
                } else {
                    $result = $pdo->select("SELECT count(msg_id) as total FROM likes WHERE msg_id = " . $msg_id . "");
                    foreach ($result as $res) {
                        $total = $res['total'];
                    }

                    if ($total == 0) {
                        echo "<a class='like' onclick='like(this)' ><i class='fa fa-thumbs-o-up'></i> Curtir</a> <div class='likethis'></div> | <a  class='commentopen' onclick='commentopen(this)' id='" . $msg_id . "' title='Comment'><i class='fa fa-comments-o'></i> Comentar </a>";
                    } else {
                        echo "<a class='like' onclick='like(this)' ><i class='fa fa-thumbs-o-up'></i> Curtir</a> <div class='likethis'><span class='badge'>" . $total . "</span></div> | <a  class='commentopen' onclick='commentopen(this)' id='" . $msg_id . "' title='Comment'><i class='fa fa-comments-o'></i> Comentar </a>";
                    }
                }
                ?>
            </div>

            <div id="stexpandbox">
                <div id="stexpand<?php echo $msg_id; ?>"></div>
            </div>

            <div class="commentcontainer" id="commentload<?php echo $msg_id; ?>">
                <?php
                $commentsarray = $Wall->Comments($msg_id);

                foreach ($commentsarray as $cdata) {
                    $msg_id_fk = $cdata['msg_id_fk'];
                    $com_id = $cdata['com_id'];
                    $comment = $cdata['comment'];
                    $time = $cdata['created'];
                    $username = $cdata['username'];
                    $uid_fk = $cdata['uid_fk'];
                    $fotouserr = $cdata['fotouser'];
                    //$cface		= $Wall->Gravatar($id_users);
                    ?>
                    <div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
                        <div class="stcommentimg">
                            <img src="<?php echo $fotouserr; ?>" class='small_face'/>
                        </div> 
                        <div class="stcommenttext" id="<?php echo $com_id; ?>">

                            <?php
                            if ($uid == $uid_fk) {
                                echo '
                                    <div style="float:right;" class="btn-group">
                                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
                                                    <li><a class="EditaComentPost" onclick="EditaComentPost(this)"><i class="fa fa-edit"></i> Editar</a></li>
                                                    <li><a class="stcommentdelete" onclick="stcommentdelete(this)" id="' . $com_id . '" title="Delete Comment"><i class="fa fa-trash-o"></i> Excluir</a></li>
                                              </ul>
                                            </div>
                                    ';
                            } else if ($uid == $_SESSION['id_login'] and $msg_id == $msg_id_fk) {
                                echo '
                                    <div style="float:right;" class="btn-group">
                                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
                                                    <li><a class="stcommentdelete" onclick="stcommentdelete(this)" id="' . $com_id . '" title="Delete Comment"><i class="fa fa-trash-o"></i> Excluir</a></li>												
                                              </ul>
                                            </div>
                                    ';
                            } else if ($uid_fk == $_SESSION['id_login']) {
                                echo '
                                    <div style="float:right;" class="btn-group">
                                              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <ul style="margin-left:-164px!important;margin-top:-25px!important;"class="dropdown-menu" role="menu">
                                                    <li><a class="EditaComentPost" onclick="EditaComentPost(this)"><i class="fa fa-edit"></i> Editar</a></li>
                                                    <li><a class="stcommentdelete" onclick="stcommentdelete(this)" id="' . $com_id . '" title="Delete Comment"><i class="fa fa-trash-o"></i> Excluir</a></li>
                                              </ul>
                                            </div>
                                    ';
                            }
                            ?>
                            <div class="stcommenttime"><b><?php echo $username; ?></b>

                                <?php
                                if ($uid_fk == $_SESSION['id_login']) {
                                    echo '<div class="EditarComment postC">';
                                } else {
                                    echo '<div class="postC">';
                                }
                                ?>

                                <?php echo $comment; ?>
                            </div>
                        </div>
                        <div class="stcommenttime">
                            <i class="fa fa-calendar"></i> <?php time_stamp($time); ?>
                        </div><br/>
                        <?php
                        $resComent = $pdo->select("SELECT * FROM likecomment WHERE com_id = {$com_id} AND uid = {$_SESSION['id_login']}");
                        $total = $pdo->select("SELECT COUNT(com_id) AS tot FROM likecomment WHERE com_id = {$com_id}");
                        
                        if(count($resComent)){
                            echo ' <a class="like stcommenttime curtirComments" onclick="unlikeComment(this)" ><i class="fa fa-thumbs-o-down"></i> Descurtir</a>';
                            echo ' <div class="commentThis" style="display: inline;"><span class="badge">'.$total[0]['tot'].'</span></div>';
                        }else{
                           if($total[0]['tot'] == 0){
                               echo ' <a class="like stcommenttime curtirComments" onclick="curtirComments(this)"><i class="fa fa-thumbs-o-up"></i> Curtir</a>';
                                echo ' <div class="commentThis" style="display: inline;"></div>';
                           } else{
                                echo ' <a class="like stcommenttime curtirComments" onclick="unlikeComment(this)"><i class="fa fa-thumbs-o-down"></i> Descurtir</a>';
                                echo ' <div class="commentThis" style="display: inline;"><span class="badge">'.$total[0]['tot'].'</span></div>';
                           }
                        }
                        
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>


        </div>
        <div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id; ?>'>
            <div class="stcommentimg">
                <img src="<?php echo $fotouser; ?>" class='small_face'/>
            </div> 
            <div class="stcommenttext" >
                <form method="post" action="">
                    <textarea name="comment" class="comment meuform" maxlength="200" id="ctextarea<?php echo $msg_id; ?>"></textarea>
                    <br />
                    <input type="button"  value=" Comentar "  id="<?php echo $msg_id; ?>" class="btn btn-primary btn-xs comment_button" onclick="comment_button(this)"/>
                </form>
            </div>
        </div>
        </div> 
        </div>
        <?php
    }
} else {
    if ($_SESSION['primeiravez'] == 1) {

        $_SESSION['primeiravez'] = 0;

        $condicao = chr(39) . "#painel" . chr(39);
        echo "<i class='fa fa-database'></i> N&atilde;o h&agrave; mais menssagens para exibir no feeds...";
    }
}