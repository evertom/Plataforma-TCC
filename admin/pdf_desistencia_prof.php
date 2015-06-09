<?php

date_default_timezone_set('America/Sao_Paulo');
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : "";

require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT u.username,u.prontuario, "
        . "date_format(d.dataDesistencia, '%d-%m-%Y') as dataDesistencia, "
        . "d.motivo,d.descricao,d.idGrupo "
        . "FROM desistenciaProf d "
        . "INNER JOIN users u ON u.uid = d.idUsers "
        . "WHERE d.idUsers = {$idUser} "
        . "AND d.dataDesistencia = current_date()");

$html = "";

foreach ($result as $res) {
    $idGrupoDel = $res['idGrupo'];
    
    $html .= "Eu, <strong><u>{$res['username']}</u></strong>, "
            . "prontuário <strong><u>{$res['prontuario']}</u></strong>  "
            . "comunico que, a partir desta data, não serei mais o responsável ";

    if ($res['motivo'] == 1) {
        $html .= "pela (x) orientação / ( ) coorientação do TCC do(as) aluno(as), ";
    } else {
        $html .= "pela ( ) orientação / (x) coorientação do TCC do(as) aluno(as), ";
    }
    
    $resu = $pdo->select("SELECT * FROM grupo_has_users gu "
            . "INNER JOIN users u ON u.uid = gu.uid "
            . "WHERE gu.idgrupo = {$res['idGrupo']} "
            . "AND gu.tipo <> 2 AND gu.tipo <> 3");
    
            foreach($resu as $resss){
                $html .= "<strong>{$resss['username']}</strong>, ";
            }
    
    $html .= "matriculados(as) no Curso de Tecnologia em Análise e "
        . "Desenvolvimento de Sistemas no Campus Bragança "
        . "Paulista do IFSP, neste período letivo de ".date('d-m-Y')." justificativa da desistência:<br><br><br>";
    
    $html .= "{$res['descricao']}<br><br><br>";
    $html .= "Bragança Paulista, ".date('d')." de ". date('M')." de ".date('Y');
    $html .= "<br><br><br>";
    $html .= "_______________________________________________________<br>";
    $html .= "Professor(a) Orientador(a)/ Coorientador(a) Assinatura";
}

require_once './includes/Administracao.class.php';
$Administracao = new Administracao();

$Administracao->idgrupo =  $idGrupoDel;
$Administracao->deleteGrupo();

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