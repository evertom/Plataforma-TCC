<?php

date_default_timezone_set('America/Sao_Paulo');
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : "";

require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT * FROM grupo_has_users gu WHERE gu.uid = {$idUser}");

foreach ($result as $res) {
    $idGrupo = $res['idgrupo'];
}

$result = $pdo->select("SELECT * FROM grupo_has_users gu "
        . "INNER JOIN users u ON u.uid = gu.uid "
        . "WHERE gu.idgrupo = {$idGrupo} "
        . "AND gu.tipo <> 2 AND gu.tipo <> 3");

$html = "";
$html .= '1. COMPOSIÇÃO DO GRUPO DE TRABALHO
        <table border="1">
            <tr>
                <th style="width: 50px;padding: 5px;">Nº</th>
                <th style="width: 610px;padding: 5px;">Nome</th>
            </tr>';

$aux = 1;
foreach ($result as $res) {
    $html .= '<tr>'
            . '<td style="padding: 5px;">' . $aux . '</td>'
            . '<td style="padding: 5px;">' . $res['username'] . '</td>'
            . '</tr>';
    $aux++;
}
$html .='</table>
        <br>
        <br>
        1.1. PROFESSOR(ES) ORIENTADOR(ES)
        <table border="1">
            <tr>
                <th style="width: 100px;padding: 5px;">Cargo</th>
                <th style="width: 555px;padding: 5px;">Nome</th>
            </tr>';
$result = $pdo->select("SELECT * FROM grupo_has_users gu "
        . "INNER JOIN users u ON u.uid = gu.uid "
        . "WHERE gu.idgrupo = {$idGrupo} "
        . "AND gu.tipo in (2,3)");
        
$aux = 1;
foreach ($result as $res) {
    if ($aux === 1) {
        $cargo = 'Orientador';
    } else if ($aux === 2) {
        $cargo = 'Coorientador';
    }
    $html .= '<tr>'
            . '<td style="padding: 5px;">' . $cargo . '</td>'
            . '<td style="padding: 5px;">' . $res['username'] . '</td>'
            . '</tr>';
    $aux++;
}

$html .='</table>
        <br>
        <br>
        2. TÍTULO E PROPOSTA DO PROJETO
        <table border="1">';

$result = $pdo->select("SELECT * FROM grupo g WHERE g.idgrupo = {$idGrupo}");

foreach ($result as $res) {
    $html .='
            <tr>
                <th style="width: 150px;padding: 5px;">Título do Projeto</th>
                <td style="width: 510px;padding: 5px;">'.$res['titulo'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Problema</th>
                <td style="width: 490px;padding: 5px;">'.$res['descricao'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Objetivo Geral</th>
                <td style="width: 490px;padding: 5px;">'.$res['objetivoGeral'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Objetivo Específicos</th>
                <td style="width: 490px;padding: 5px;">'.$res['objetivoEspecifico'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Justificativa</th>
                <td style="width: 490px;padding: 5px;">'.$res['justificativa'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Tipo de Pesquisa</th>
                <td style="width: 490px;padding: 5px;">'.$res['tipodePesquisa'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Metodologia de Desenvolvimento</th>
                <td style="width: 490px;padding: 5px;">'.$res['metodologia'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Descrição do Sistema</th>
                <td style="width: 490px;padding: 5px;">'.$res['descricao'].'</td>
            </tr>
            <tr>
                <th style="width: 150px;padding: 5px;">Resultados Esperados</th>
                <td style="width: 490px;padding: 5px;">'.$res['resultadoEsperado'].'</td>
            </tr>';
}

$html .= '</table>
        <br>
        <br>
        <table border="1">
            <tr>
                <th style="width: 400px;padding: 5px;">Alunos</th>
                <th style="width: 260px;padding: 5px;">Assinaturas</th>
            </tr>
            <tr>
                <td style="padding: 5px;color:#fff;">oi</td>
                <td style="padding: 5px;color:#fff;">oi</td>
            </tr>
            <tr>
                <td style="padding: 5px;color:#fff;">oi</td>
                <td style="padding: 5px;color:#fff;">oi</td>
            </tr>
            <tr>
                <td style="padding: 5px;color:#fff;">oi</td>
                <td style="padding: 5px;color:#fff;">oi</td>
            </tr>
        </table>
        <br>
        <br>
        <table border="1">
            <tr>
                <th style="width: 400px;padding: 5px;">Orientador(es)</th>
                <th style="width: 260px;padding: 5px;">Assinaturas</th>
            </tr>
            <tr>
                <td style="padding: 5px;color:#fff;">oi</td>
                <td style="padding: 5px;color:#fff;">oi</td>
            </tr>
            <tr>
                <td style="padding: 5px;color:#fff;">oi</td>
                <td style="padding: 5px;color:#fff;">oi</td>
            </tr>
        </table>';

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
$mpdf->WriteHTML('<h2><img src="img/if.png"/> Proposta de Trabalho(TCC)</h2><br>');
$mpdf->SetFooter('{DATE j/m/Y  H:i}||Pagina {PAGENO}/{nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();

