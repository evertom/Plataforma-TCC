<?php
# PHPlot Example: Line graph, 2 lines
require_once './phplot-6.1.0/phplot.php';
//Define the object
$plot = new PHPlot(800,600);

//Set titles
$plot->SetTitle("Grafico de Acompanhamento de Evolucao");
$plot->SetXTitle('X Data');
$plot->SetYTitle('Y Data');

//Define some data
$example_data = array(
     array(date('M', mktime(37,16,16,06,19,2015)), mktime(37,16,16,07,19,2015), mktime(37,16,20,06,19,2015)),
     array('a', mktime(37,16,26,06,19,2015), mktime(37,16,10,07,19,2015)),
     array('a', mktime(37,16,06,12,19,2015), mktime(37,16,11,12,29,2015)),
     array('a', mktime(37,16,16,08,19,2015), mktime(37,16,23,08,14,2015)),
     array('a', mktime(37,16,22,09,19,2015), mktime(37,16,28,09,23,2015)),
     array('a', mktime(37,16,29,10,19,2015), mktime(37,16,03,10,21,2015)),
     array('a', mktime(37,16,01,11,19,2015), mktime(37,16,08,11,19,2015)),
    
);
$plot->SetDataValues($example_data);

$plot->SetLegend(array('Planejado', 'Executado'));

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

//Draw it
$plot->DrawGraph();