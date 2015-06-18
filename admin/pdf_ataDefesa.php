<?php
date_default_timezone_set('America/Sao_Paulo');
$idAta = isset($_GET['idAta']) ? $_GET['idAta'] : "";

require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT a.idgrupo,a.titulo,a.prof1,a.prof2,"
        . "a.prof3,a.`status`,a.nota,date_format(a.dia, '%d-%m-%Y') as dia,"
        . "a.hora FROM atadefesa a WHERE a.idAtaDefesa = {$idAta}");
        
$html = "CURSO SUPERIOR DE TECNOLOGIA EM 
ANÁLISE E DESENVOLVIMENTO DE SISTEMAS
<br><br>";

foreach($result as $res){
    $html .= "Aos, <b>{$res['dia']}</b> às <b>{$res['hora']}</b>,sito à rua Francisco "
        . "Samuel Lucchesi, 770 – Penha – Bragança Paulista – deste Instituto de "
        . "Ensino, reuniu-se em sessão pública a comissão julgadora da "
        . "Monografia de Tecnologia de Análise e Desenvolvimento de Sistemas "
        . "desenvolvida pelo(s) alunos(as): ";
        
        $result2 = $pdo->select("SELECT * FROM grupo_has_users gu "
                . "INNER JOIN users u ON u.uid = gu.uid "
                . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
                . "WHERE gu.idgrupo = {$res['idgrupo']} AND gu.tipo = 1");
        
        foreach($result2 as $res2){
            $html .= "<b>".$res2['username']."</b>, ";
            $titulo = $res2['titulo'];
        }
        
        $html .= "sob o título: <b>{$titulo}</b>.";
    
    $html .="<br><br>Integraram a comissão os Professores: "
            . "<b>{$res['prof1']}</b> (orientador(a)), <b>"
            . "{$res['prof2']},{$res['prof3']} </b>"
            . "sob a presidência do primeiro. A Banca Examinadora, tendo"
            . " decidido aceitar a monografia de Trabalho de Conclusão de"
            . " Curso (TCC), passou à arguição pública dos candidatos. "
            . "Encerrados os trabalhos os examinadores deram parecer final "
            . "sobre a apresentação.";
            
    $html .= "<br><br>Menbro 1 {$res['prof1']} (Presidente) - __________________________________________<br><br>";     
    $html .= "Menbro 2 {$res['prof2']} - __________________________________________<br><br>";     
    $html .= "Menbro 3 {$res['prof3']} - __________________________________________<br><br>";     
           
    $html .= "Parecer:______________________________________________________________________________________________<br><br>"
            . "_______________________________________________________________________________________________________<br><br>";
    
    $html .= "Em conclusão os(as) candidatos(as) ";
           
            foreach($result2 as $res2){
                $html .= "<b>".$res2['username']."</b>, ";
            }
            
    $html .= "foram considerados(as) ___________________, na graduação da Monografia "
            . "em Tecnologia de Análise e Desenvolvimento de Sistemas. "
            . "E, para constar, eu, ___________________________________, "
            . "Coordenador do referido curso, lavrei a presente Ata "
            . "que assino juntamente com os membros da Banca Examinadora.<br><br>";
    
    $html .="__________________________________________________    &nbsp;&nbsp;&nbsp;__________________________________________________<br>"
            . "Assinatura do Presidente da Banca Examinadora         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assinatura do Membro da Banca (2)<br>"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "Membro da Banca (1)<br><br>";
    
    $html .="__________________________________________________    &nbsp;&nbsp;&nbsp;__________________________________________________<br>"
            . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura do Membro da Banca (3) "
            . "        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aluno/Prontuário<br><br>";
            
    $html .="__________________________________________________    &nbsp;&nbsp;&nbsp;__________________________________________________<br>"
            . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp; Aluno/Prontuário "
            . "        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aluno/Prontuário<br><br><br>";
     
    $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "__________________________________________________<br>       "
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
            . "<b>Prof. MSc. Wilson Vendramel</b><br>         "
            . "Coordenador do Curso de Tecnologia em Análise e "
            . "Desenvolvimento de Sistemas - Bragança Paulista";
}

$pdo->desconectar();

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
$mpdf->WriteHTML('<h2><img src="img/if.png"/> Ata de Defesa(TCC)</h2><br>');
$mpdf->SetFooter('{DATE j/m/Y  H:i} Bragança Paulista||Pagina {PAGENO}/{nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();