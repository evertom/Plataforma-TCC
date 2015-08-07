<?php
require_once('verifica-logado.php');
require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$idGrupo = $pdo->select("SELECT * FROM grupo_has_users WHERE uid = {$id_users}");

$concluido = 0;
$atrasado = 0;
$registros = 0;
$resultado = $pdo->select("SELECT * FROM evento WHERE idGrupo = {$idGrupo[0]['idgrupo']}");
if (count($resultado)) {
    foreach ($resultado as $ress) {
        $registros ++;
        if ($ress['concluido'] == 1) {
            $concluido ++;
            continue;
        }
        if (strtotime($ress['end']) < strtotime(date('Y-m-d'))) {
            $atrasado ++;
        }
    }
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
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- MetisMenu CSS -->
        <link href="metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Custom CSS -->
        <link href="sb-admin-2/css/sb-admin-2.css" rel="stylesheet"/>
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/chartJs.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/Chart.js"></script>
        <script type="text/javascript" src="js/legend.js"></script>
        <script type="text/javascript" src="js/legend.legacy.js"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
            else window.attachEvent('onload', main);

            function main() {
                pieChart();
            }

            function pieChart() {
                var data = [
                    {
                        value: <?php echo $registros ?>,
                        color:"#1E90FF",
                        label: 'Total de Eventos'
                    },
                    {
                        value : <?php echo $concluido ?>,
                        color : "#00FF00",
                        label: 'Eventos Concluidos'
                    },
                    {
                        value : <?php echo $atrasado ?>,
                        color : "#FF0000",
                        label: 'Eventos Atrasados'
                    }
                ];

                var ctx = document.getElementById("pieChart").getContext("2d");
                var pieChart = new Chart(ctx).Pie(data);

                legend(document.getElementById("pieLegend"), data, pieChart);
             }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php require_once('pages/headerAdmin.php'); ?>
                <?php require_once('pages/menuLateralAdmin.php'); ?>
            </nav>
            <?php
            $result = $pdo->select("SELECT b.username, c.titulo, a.tipo, c.descricao "
                    . "FROM grupo_has_users a INNER JOIN users b ON a.uid =  b.uid "
                    . "INNER JOIN grupo c ON c.idgrupo = a.idgrupo "
                    . "WHERE a.idgrupo = {$idGrupo[0]['idgrupo']} ORDER BY a.tipo ");
            
            $html = "";

            if (count($result)){
                $names = "";
                foreach ($result as $res) {
                    $titulo = $res['titulo'];
                    $descricao = $res['descricao'];
                    if ($res['tipo'] == 1) {
                        $names .= "<h4>Aluno: <small>";
                    } else if ($res['tipo'] == 2) {
                        $names .= "<h4>Orientador: <small>";
                    } else {
                        $names .= "<h4>Co-Orientador: <small>";
                    }
                    $names .= $res['username'] . "</small></h4>";
                }
            }

            $html .= "<div class='page-header'>"
                    . "<h3>$titulo "
                    . "<small>$descricao</small></h3>"
                    . "$names</div>";
            ?>   
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">Gr&aacute;fico 
                            <span class="text-danger">de acompanhamento</span></h2>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             <?php echo $html ;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div>
                                <canvas id="pieChart" width="600" height="400"></canvas>
                                <div id="pieLegend"></div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <div class="row"></div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
    </body>
</html>