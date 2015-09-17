<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Admin</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"/></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"/></script>
        <![endif]-->
        <link rel="stylesheet" href="bootstrap3-dialog-master/src/css/bootstrap-dialog.css"/>
        <!-- jQuery -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
        <script src="bootstrap3-dialog-master/src/js/bootstrap-dialog.js"></script>
        <script src="bootstrap3-dialog-master/alertsMsg.js"></script>
    </head>
    <body>
    <?php
    error_reporting(0);
    require_once('verifica-logado.php');
    require_once('includes/Conexao.class.php');
    $pdo = new Conexao();

    $result = $pdo->select("SELECT tipo FROM users WHERE uid = " . $id_users . "");
    foreach ($result as $res) {
        $tipo = $res['tipo'];
        $_SESSION['tipoUser'] = $tipo; 
    }
    //tipo igual a zero e aluno e tipo igual a 1 e professor
    if ($tipo == 0) {
        $result = $pdo->select("SELECT gu.idgrupo FROM grupo_has_users gu "
                . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo where g.aceito = 1 "
                . "AND gu.uid = " . $id_users . "");

        if (count($result)) {
            foreach ($result as $res) {
                $idGrupo = $res['idgrupo'];
            }
        } else {
            echo "<script type='text/javascript'>showAlert('alert',{type: BootstrapDialog.TYPE_WARNING, title: 'AVISO!!!', message:'Para poder acessar o painel ADM voc\u00ea deve requisitar um professor para orienta\u00e7\u00e3o e formar um grupo de TCC, volte para tela principal e escolha seu orientador...', location:'./index.php'}, null);</script>";
            exit();
        }
    } else if ($tipo == 1) {
        $result = $pdo->select("SELECT gu.idgrupo FROM grupo_has_users gu INNER JOIN grupo g ON g.idgrupo = gu.idgrupo where g.aceito = 1 AND gu.tipo = 2 AND gu.uid = " . $id_users . "");

        $idGrupo = null;
        if (count($result)) {
            foreach ($result as $res) {
                $idGrupo .= $res['idgrupo'] . ',';
            }
        }

        $size = strlen($idGrupo);
        $condicao = substr($idGrupo, 0, $size - 1);
    }
    ?>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>
            <?php
            if ($tipo == 0) {
                require_once('pages/perfilAluno.php');
            } else {
                require_once('pages/perfilProfessor.php');
            }
            ?>
        </div>
        <!-- /#wrapper -->
    </body>
</html>