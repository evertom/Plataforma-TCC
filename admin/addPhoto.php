<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Gigasystems - Painel Administrativo</title>
        <link href='css/style.css' rel='stylesheet'/>
        <link href='bootstrap/css/bootstrap.min.css' rel='stylesheet'/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-pack.js"></script>
        <script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
        <script type="text/javascript">
            $(function ($) {
                var painel = $("#painel");
                var close = $("#closePainel");
                //fecha painel clicando na seta
                $(close).click(function () {
                    $(".insertForm > ").remove();
                    painel.fadeOut(500);
                    
                });
            });
            
            
            function alertMsg(text, classe, location){
                var div = $("<div class='msgAlert "+classe+"'>"+text+"</div>");
                $('body').append(div);
                $(div).fadeIn();
                setTimeout(closeAlertMsg, 5000, div, location);
            }
            
            function closeAlertMsg(div, location){
                $(div).fadeOut();
                $(div).remove();
                if(location !== null){
                    window.location=location;
                }
            }
        
        </script>
    </head>
    <body>
    <?php
    require_once('verifica-logado.php');

    error_reporting(E_ALL ^ E_NOTICE);
    session_start(); //Do not remove this
    ob_start();

//only assign a new timestamp if the session variable is empty
    if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key']) == 0) {
        $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
        $_SESSION['user_file_ext'] = "";
    }
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
    $upload_dir = "fotoUser";     // The directory for the images to be saved in
    $upload_path = $upload_dir . "/";    // The path to where the image will be saved
    $large_image_prefix = "resize_";    // The prefix name to large image
    $thumb_image_prefix = "thumbnail_";   // The prefix name to the thumb image
    $large_image_name = $large_image_prefix . $_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
    $thumb_image_name = $thumb_image_prefix . $_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
    $max_file = "3";        // Maximum file size in MB
    $max_width = "500";       // Max width allowed for the large image
    $thumb_width = "200";      // Width of thumbnail image
    $thumb_height = "200";      // Height of thumbnail image
// Only one of these image types should be allowed for upload
    $allowed_image_types = array('image/pjpeg' => "jpg", 'image/jpeg' => "jpg", 'image/jpg' => "jpg", 'image/png' => "png", 'image/x-png' => "png", 'image/gif' => "gif");
    $allowed_image_ext = array_unique($allowed_image_types); // do not change this
    $image_ext = ""; // initialise variable, do not change this.
    foreach ($allowed_image_ext as $mime_type => $ext) {
        $image_ext.= strtoupper($ext) . " ";
    }


##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################

    function resizeImage($image, $width, $height, $scale) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);

        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $image, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $image);
                break;
        }

        chmod($image, 0777);
        return $image;
    }

//You do not need to alter these functions
    function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);

        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $thumb_image_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $thumb_image_name, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $thumb_image_name);
                break;
        }
        chmod($thumb_image_name, 0777);
        return $thumb_image_name;
    }

//You do not need to alter these functions
    function getHeight($image) {
        $size = getimagesize($image);
        $height = $size[1];
        return $height;
    }

//You do not need to alter these functions
    function getWidth($image) {
        $size = getimagesize($image);
        $width = $size[0];
        return $width;
    }

//Image Locations
    $large_image_location = $upload_path . $large_image_name . $_SESSION['user_file_ext'];
    $thumb_image_location = $upload_path . $thumb_image_name . $_SESSION['user_file_ext'];

//Create the upload directory with the right permissions if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777);
        chmod($upload_dir, 0777);
    }

//Check to see if any images with the same name already exist
    if (file_exists($large_image_location)) {
        if (file_exists($thumb_image_location)) {
            $thumb_photo_exists = "<img src=\"" . $upload_path . $thumb_image_name . $_SESSION['user_file_ext'] . "\" alt=\"Miniatura\" title=\"Miniatura\" />";
        } else {
            $thumb_photo_exists = "";
        }
        $large_photo_exists = "<img src=\"" . $upload_path . $large_image_name . $_SESSION['user_file_ext'] . "\" alt=\"Imagem Grande\" title=\"Imagem Grande\"/>";
    } else {
        $large_photo_exists = "";
        $thumb_photo_exists = "";
    }

    if (isset($_POST["upload"])) {
        
        //Get the file information
        $userfile_name = $_FILES['image']['name'];
        $userfile_tmp = $_FILES['image']['tmp_name'];
        $userfile_size = $_FILES['image']['size'];
        $userfile_type = $_FILES['image']['type'];
        $filename = basename($_FILES['image']['name']);
        $file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

        //Only process if the file is a JPG, PNG or GIF and below the allowed limit
        if ((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {

            foreach ($allowed_image_types as $mime_type => $ext) {
                //loop through the specified image types and if they match the extension then break out
                //everything is ok so go and check file size
                if ($file_ext == $ext && $userfile_type == $mime_type) {
                    $error = "";
                    break;
                } else {
                    $error = "Somente imagens com extens&atilde;o <strong>(" . $image_ext . ")</strong> ser&atilde;o aceitas para upload<br />";
                }
            }
            //check if the file size is above the allowed limit
            if ($userfile_size > ($max_file * 1048576)) {
                $error.= "As imagens devem ser menores que " . $max_file . "MB de tamanho";
            }
        } else {
            $error = "Selecione uma imagem para fazer upload...";
        }
        //Everything is ok, so we can upload the image.
        if (strlen($error) == 0) {
            if (isset($_FILES['image']['name'])) {
                //this file could now has an unknown file extension (we hope it's one of the ones set above!)
                $large_image_location = $large_image_location . "." . $file_ext;
                $thumb_image_location = $thumb_image_location . "." . $file_ext;

                //put the file ext in the session so we know what file to look for once its uploaded
                $_SESSION['user_file_ext'] = "." . $file_ext;

                move_uploaded_file($userfile_tmp, $large_image_location);
                chmod($large_image_location, 0777);

                $width = getWidth($large_image_location);
                $height = getHeight($large_image_location);
                //Scale the image if it is greater than the width set above
                if ($width > $max_width) {
                    $scale = $max_width / $width;
                    $uploaded = resizeImage($large_image_location, $width, $height, $scale);
                } else {
                    $scale = 1;
                    $uploaded = resizeImage($large_image_location, $width, $height, $scale);
                }
                //Delete the thumbnail file so the user can create a new one
                if (file_exists($thumb_image_location)) {
                    unlink($thumb_image_location);
                }
            }
            //Refresh the page to show the new uploaded image
            header("location:" . $_SERVER["PHP_SELF"]);
            exit();
        }
    }

    if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists) > 0) {
        //Get the new coordinates to crop the image.
        $x1 = $_POST["x1"];
        $y1 = $_POST["y1"];
        $x2 = $_POST["x2"];
        $y2 = $_POST["y2"];
        $w = $_POST["w"];
        $h = $_POST["h"];
        //Scale the image to the thumb_width set above
        $scale = $thumb_width / $w;
        $cropped = resizeThumbnailImage($thumb_image_location, $large_image_location, $w, $h, $x1, $y1, $scale);

        //Primeiro excluir a foto que esta
        $uid = $_SESSION['id_login'];
        $thumb = $_SESSION['fotouser'];

        $auxvar = explode('/', $thumb);
        if ($auxvar[1] != "padraoUser.jpg") {
            unlink($thumb);
        }

        //agora insere no BD
        require_once('includes/functions.php');
        $wall = new Wall_Updates();

        $wall->thumb = $upload_path . $thumb_image_name . $_SESSION['user_file_ext'];
        $wall->uid = $uid;

        $_SESSION['fotouser'] = $upload_path . $thumb_image_name . $_SESSION['user_file_ext'];
        if ($wall->AtualizaThumb()) {
            //deleta sessao e retira imagem 
            unset($_SESSION['random_key']);
            unset($_SESSION['user_file_ext']);

            unlink($large_image_location . $userfile_tmp);

            echo "<script type='text/javascript'>alertMsg('Foto adicionada com successo', 'success','index.php');</script>";
        } else {
            echo "<script type='text/javascript'>alertMsg('Falha ao tentar adicionar foto.', 'error','addPhoto.php');</script>";
        }
        exit();
    }

    if ($_GET['a'] == "delete" && strlen($_GET['t']) > 0) {
//get the file locations 
        $large_image_location = $upload_path . $large_image_prefix . $_GET['t'];
        $thumb_image_location = $upload_path . $thumb_image_prefix . $_GET['t'];
        if (file_exists($large_image_location)) {
            unlink($large_image_location);
        }
        if (file_exists($thumb_image_location)) {
            unlink($thumb_image_location);
        }
        header("location:" . $_SERVER["PHP_SELF"]);
        exit();
    }
    ?>
    
        <section>
            <div id="coontentsAuto">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Escolha uma nova foto para seu perfil
                            <div id="closePainel"><i class="fa fa-close"></i></div>
                        </div>
                        <div class="panel-body">
                            <div style="position: relative; overflow-y: auto; height: 275px; margin: 0px auto;">
                            <article>
                                <?php
//Only display the javacript if an image has been uploaded
                                if (strlen($large_photo_exists) > 0) {
                                    $current_large_image_width = getWidth($large_image_location);
                                    $current_large_image_height = getHeight($large_image_location);
                                    ?>
                                    <script type="text/javascript">
                                        function preview(img, selection) {
                                            var scaleX = <?php echo $thumb_width; ?> / selection.width;
                                            var scaleY = <?php echo $thumb_height; ?> / selection.height;

                                            $('#thumbnail + div > img').css({
                                                width: Math.round(scaleX * <?php echo $current_large_image_width; ?>) + 'px',
                                                height: Math.round(scaleY * <?php echo $current_large_image_height; ?>) + 'px',
                                                marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                                                marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                                            });
                                            $('#x1').val(selection.x1);
                                            $('#y1').val(selection.y1);
                                            $('#x2').val(selection.x2);
                                            $('#y2').val(selection.y2);
                                            $('#w').val(selection.width);
                                            $('#h').val(selection.height);
                                        }

                                        $(document).ready(function () {
                                            $('#save_thumb').click(function () {
                                                var x1 = $('#x1').val();
                                                var y1 = $('#y1').val();
                                                var x2 = $('#x2').val();
                                                var y2 = $('#y2').val();
                                                var w = $('#w').val();
                                                var h = $('#h').val();
                                                if (x1 == "" || y1 == "" || x2 == "" || y2 == "" || w == "" || h == "") {
                                                    alertMsg('Você deve fazer a seleção primeiro.', 'error', null);
                                                    return false;
                                                } else {
                                                    return true;
                                                }
                                            });
                                        });

                                        $(window).load(function () {
                                            $('#thumbnail').imgAreaSelect({aspectRatio: '1:<?php echo $thumb_height / $thumb_width; ?>', onSelectChange: preview});
                                        });

                                    </script>
                                <?php } ?>
                                <h3>Carregar Imagem e Recortar Miniatura</h3>
                                <?php
//Display error message if there are any
                                if (strlen($error) > 0) {
                                    echo "<ul><li><strong>Erro!</strong></li><li>" . $error . "</li></ul>";
                                }
                                if (strlen($large_photo_exists) > 0 && strlen($thumb_photo_exists) > 0) {
                                    echo $large_photo_exists . "&nbsp;" . $thumb_photo_exists;
                                    echo "<p><a href=\"" . $_SERVER["PHP_SELF"] . "?a=delete&t=" . $_SESSION['random_key'] . $_SESSION['user_file_ext'] . "\">Excluir Imagens</a></p>";
                                    echo "<p><a href=\"" . $_SERVER["PHP_SELF"] . "\">Carregar outra Imagem</a></p>";
                                    //Clear the time stamp session and user file extension
                                    $_SESSION['random_key'] = "";
                                    $_SESSION['user_file_ext'] = "";
                                } else {
                                    if (strlen($large_photo_exists) > 0) {
                                        ?>
                                        <h2>Criar Miniatura</h2>
                                        <div align="center">
                                            <img src="<?php echo $upload_path . $large_image_name . $_SESSION['user_file_ext']; ?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Criar Miniatura" />
                                            <div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width; ?>px; height:<?php echo $thumb_height; ?>px;">
                                                <img src="<?php echo $upload_path . $large_image_name . $_SESSION['user_file_ext']; ?>" style="position: relative;" alt="Visualizar Miniatura" />
                                            </div>
                                            <br style="clear:both;"/>
                                            <form name="thumbnail" id="newPost" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                                <input type="hidden" name="x1" value="" id="x1" />
                                                <input type="hidden" name="y1" value="" id="y1" />
                                                <input type="hidden" name="x2" value="" id="x2" />
                                                <input type="hidden" name="y2" value="" id="y2" />
                                                <input type="hidden" name="w" value="" id="w" />
                                                <input type="hidden" name="h" value="" id="h" />
                                                <input type="submit" name="upload_thumbnail" class="btn btn-primary" value="Salvar" id="save_thumb" />
                                            </form>
                                        </div>
                                        <hr />
                                    <?php } ?>
                                    <hr/>
                                    <br clear="all" />
                                    <form name="photo" id="newPost"  enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                                        Photo 
                                        <input type="file" name="image" class="btn btn-primary" /> 
                                        <br>
                                        <input type="submit" name="upload" value="Upload" class="btn btn-primary"/>
                                    </form>
                                <?php } ?>

                            </article>
                            </div>
                            <br clear="all"/>
                        </div>
                        <div class="panel-footer">
                           
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->

            </div>
        </section>
    </body>
</html>