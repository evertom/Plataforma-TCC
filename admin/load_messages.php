<?php
require_once('verifica-logado.php');

$Wall = new Wall_Updates();
$updatesarray = $Wall->Updates($id_users);

foreach ($updatesarray as $data) {
    $msg_id = $data['msg_id'];
    $message = $data['message'];
    $time = $data['created'];
    $username = $data['username'];
    $uid = $data['uid_fk'];
    $fotouserr = $data['fotouser'];
    //$face			= $Wall->Gravatar($id_users);
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#stexpand<?php echo $msg_id; ?>").oembed("<?php echo $message; ?>", {maxWidth: 400, maxHeight: 300});
        });
    </script>
    <div class="stbody" id="stbody<?php echo $msg_id; ?>">

        <div class="stimg">
            <img src="<?php echo $fotouserr; ?>" class='big_face'/>
        </div> 
        <div class="sttext">
            <?php
            if ($uid == $_SESSION['id_login']) {
                echo "<a class='stdelete' href='#' id='" . $msg_id . "' title='Delete update'><i class='fa fa-trash-o'></i></a>";
            }
            ?>
            <b><?php echo $username; ?></b> <?php echo $message; ?>
            <div class="sttime">
                <i class="fa fa-calendar"></i> <?php time_stamp($time); ?> | <a href='#' class='commentopen' id='<?php echo $msg_id; ?>' title='Comment'><i class='fa fa-comments-o'></i> Comentar </a>
            </div> 

            <div id="stexpandbox">
                <div id="stexpand<?php echo $msg_id; ?>"></div>
            </div>

            <div class="commentcontainer" id="commentload<?php echo $msg_id; ?>">
                <?php include('load_comments.php') ?>
            </div>
            <div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id; ?>'>
                <div class="stcommentimg">
                    <img src="<?php echo $fotouser; ?>" class='small_face'/>
                </div> 
                <div class="stcommenttext" >
                    <form method="post" action="">
                        <textarea name="comment" class="comment meuform" maxlength="200"  id="ctextarea<?php echo $msg_id; ?>"></textarea>
                        <br />
                        <input type="button"  value=" Comment "  id="<?php echo $msg_id; ?>" class="comment_button" onclick="comment_button(this)"/>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <?php
}
?>






