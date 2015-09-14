<?php
	//inicia a sessao e destroi todos os dados gravados em cache etc
    @session_start();
	ob_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    @session_destroy();
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>Plataforma de Gerenciamento de TCC</title>
        <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />

        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="pragma" content="no-cache" />

        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>
        <link rel="shortcut icon" href="favicon.ico"/>
        <script type="text/javascript">
            $(document).ready(function(){
                showAlert('alert',{title: ';D!!!', message:'Volte sempre :)', type: BootstrapDialog.TYPE_PRIMARY, location: '../'}, null);
            });
        </script>
    </head>
    <body>
        
    </body>
</html>