<?php
require_once('verifica-logado.php');
require_once('includes/Conexao.class.php');
date_default_timezone_set("America/Sao_Paulo");

$pdo = new Conexao();
$result = $pdo->select("SELECT idgrupo FROM grupo_has_users WHERE uid = $id_users ORDER BY idgrupo desc;");

if (count($result)) {
    foreach ($result as $res) {
        $idgrupo = $res['idgrupo'];
        $array_grupos = array('id' => $idgrupo);
    }
    $result = $pdo->select("SELECT idcronograma FROM cronograma WHERE idgrupo = $idgrupo");
    if (count($result)) {
        foreach ($result as $res) {
            $idcronograma = $res['idcronograma'];
        }
    } else {
        $idcronograma = null;
    }
} else {
    echo "<script type='text/javascript'>location.href='panel.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>

        <title>Admin</title>
        <style>
            .foo{
                position: fixed!important;
                z-index: 99999!important;
                overflow-y: auto!important;
                background-color: #FFF!important;
                width: 100%!important;
                height:100%!important;
                top:0px!important;
                left:0px!important;
            }
        </style>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- TimeLine Core CSS -->
        <link href="css/timeline.css" rel="stylesheet"/>

        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

        <!-- Jquery -->
        <script src="js/jquery-2.1.3.js"></script>

        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- FullCallender -->
        <link href="fullcalendar-2.3.1/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
        <script src="fullcalendar-2.3.1/lib/moment.min.js"></script>
        <script src="fullcalendar-2.3.1/fullcalendar.min.js"></script>
        <script src="fullcalendar-2.3.1/lang-all.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>

        <!-- select bootstrap -->
        <link href="js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-select/js/bootstrap-select.min.js"></script>

        <!-- bootstrap-switch-master -->
        <link href="js/bootstrap-switch-master/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap-switch-master/js/bootstrap-switch.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            $(document).ready(function () {
                var IDGRUPO = $("#idgrupo").val();

                Load(IDGRUPO);

                $('#select-idgrupo').on('change', function () {
                    var id = $(this).val();
                    if (id !== null) {
                        var idO;
                        for (var i = 0; i < id.length; i++) {
                            idO = id[i];
                        }
                        IDGRUPO = idO;
                        $("#idgrupo").val(IDGRUPO);
                        Load(IDGRUPO);
                    } else {
                        IDGRUPO = "";
                        $("#idgrupo").val(IDGRUPO);
                        $("#timeline").fadeOut(250);
                    }
                });
            });

            function Load(id) {
                $.ajax
                ({
                    type: "POST", //metodo POST
                    dataType: 'html',
                    url: "ajax/control_cronograma.php",
                    data: {operation: "timeline", idGrupo: id},
                    success: function (data)
                    {
                        $("#timeline").html(data).fadeIn(100);
                    }
                });
            }
        </script>
    </head>
    <body>

        <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $idgrupo; ?>"/>

        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?php
                            if ($tipo_users > 0) {
                                echo '<h4> Selecione o Grupo</h4>'
                                . '<div class="form-group input-group">'
                                    . '<select name="select-idgrupo" id="select-idgrupo"'
                                    . ' class="selectpicker" multiple  data-max-options="1" '
                                    . 'data-min-options="1" required data-style="btn-info" '
                                    . 'title="Selecione o grupo de trabalho?" data-live-search="true" >';


                                $pdo = new Conexao();
                                echo "<optgroup label='Grupos - Títulos'>";

                                foreach ($array_grupos as $id) {
                                    $result = $pdo->select("SELECT * FROM grupo_has_users a INNER JOIN grupo b ON a.idgrupo = b.idgrupo WHERE a.uid = {$id_users} ORDER BY titulo");
                                    foreach ($result as $res) {
                                        if ($idgrupo == $res['idgrupo']) {
                                            echo "<option selected value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        } else {
                                            echo "<option value='" . $res['idgrupo'] . "'>" . $res['titulo'] . "</option>";
                                        }
                                    }
                                }
                                echo "</optgroup></select></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" id="timeline">
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <!-- /.row -->
                <div class="row">

                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    </body>
</html>