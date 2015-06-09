<?php
date_default_timezone_set('America/Sao_Paulo');
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : "";

require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT u.username,u.prontuario, "
        . "date_format(d.dataDesistencia, '%d-%m-%Y') as dataDesistencia, "
        . "d.motivo,d.descricao,d.idGrupo "
        . "FROM desistenciaaluno d "
        . "INNER JOIN users u ON u.uid = d.idUsers "
        . "WHERE d.idUsers = {$idUser} "
        . "AND d.dataDesistencia = current_date()");

$html = "";

foreach($result as $res){
    $html .= "Eu, <strong><u>{$res['username']}</u></strong>, "
            . "prontuário <strong><u>{$res['prontuario']}</u></strong>  "
            . "aluno(a) do Curso de Tecnologia em Análise e Desenvolvimento "
            . "de Sistemas no Campus Bragança Paulista do IFSP, neste "
            . "período letivo de {$res['dataDesistencia']} declaro, para os devidos fins: ";

    if($res['motivo'] == 1){
        $html .= "<br><br>";
        $html .= "Desistir do desenvolvimento do Trabalho de Conclusão de Curso "
                . "no grupo formado pelos seguintes integrantes: ";
        
        $resu = $pdo->select("SELECT * FROM grupo_has_users gu "
            . "INNER JOIN users u ON u.uid = gu.uid "
            . "WHERE gu.tipo <> 2 AND gu.tipo <> 3 "
            . "AND gu.idgrupo = {$res['idGrupo']} AND gu.uid <> 2");
            
    }else if($res['motivo'] == 2){
        $html .= "<br><br>";
        $html .= "Desistir da orientação do Trabalho de Conclusão de Curso do(a) professor(a) ";
        
        $resu = $pdo->select("SELECT * FROM grupo_has_users gu "
            . "INNER JOIN users u ON u.uid = gu.uid "
            . "WHERE gu.idgrupo = {$res['idGrupo']} AND gu.tipo <> 1");
    }
            
    foreach($resu as $resss){
          $html .= "<strong>{$resss['username']}, </strong>" ;
    }
    
    $html .= "motivo da desistência:<br><br>";
    $html .= "{$res['descricao']}<br><br><br>";
    $html .= "Bragança Paulista, ".date('d')." de ". date('M')." de ".date('Y');
    $html .= "<br><br><br>";
    $html .= "___________________________________________<br>";
    $html .= "           Assinatura Aluno(a)";
    
}


define('MPDF_PATH', 'mpdf60/');
include(MPDF_PATH . 'mpdf.php');
$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
$mpdf->useOnlyCoreFonts = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->showWatermarkText = true;
$mpdf->SetWatermarkText('TCC');
$mpdf->SetWatermarkImage('img/if.png', 1, '', array(10, 10));
$mpdf->showWatermarkImage = false;
$mpdf->WriteHTML('<h2><img src="img/if.png"/> Desistência de Grupo(TCC)</h2><br>');
$mpdf->SetFooter('{DATE j/m/Y  H:i} Bragança Paulista||Pagina {PAGENO}/{nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();