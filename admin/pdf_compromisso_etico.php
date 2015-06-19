<?php
date_default_timezone_set('America/Sao_Paulo');
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : "";

require_once './includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->select("SELECT * FROM users u WHERE u.uid = {$idUser}");
$html = "";

foreach($result as $res){
    $html .= "Eu, <strong><u>{$res['username']}</u></strong>, prontuário <b>{$res['prontuario']}</b> "
    . "Curso: Análise e Desenvolvimento de Sistemas, Semestre: ___________________________ ";
    
    $resultado = $pdo->select("SELECT * FROM grupo_has_users gu "
            . "INNER JOIN grupo g ON g.idgrupo = gu.idgrupo "
            . "WHERE gu.uid = {$idUser}");
    
    foreach($resultado as $resres){
        $html .= "<br><br>Título do Trabalho (provisório ou definitivo): <strong>{$resres['titulo']}</strong>";
        $idGrupo = $resres['idgrupo'];
    }
         
   $resultado = $pdo->select("SELECT * FROM grupo_has_users gu "
           . "INNER JOIN users u ON u.uid = gu.uid "
           . "WHERE gu.idgrupo = {$idGrupo} AND gu.tipo = 2");
      
    foreach($resultado as $resres){
         $html .= "<br><br><br>Orientador(a): {$resres['username']}";
    }     
    
    $html .="<br><br><br>Responsabilizo-me pela redação deste Trabalho de Conclusão de Curso, declarando que
todos os trechos que tenham sido transcritos de outros documentos (publicados ou não) e que não
sejam de minha autoria estão citados entre aspas e está identificada a fonte com data da publicação
da obra e da página de onde foram extraídos (se transcritos literalmente) ou somente indicada a fonte
com data da publicação da obra (se apenas utilizada a ideia do autor citado). Declaro, igualmente, ter
conhecimento de que posso ser responsabilizado(a) legalmente caso infrinja tais disposições. ";
           
    $html .= "<br><br><br>";
    $html .= "Bragança Paulista, ".date('d')." de ". date('M')." de ".date('Y');
    $html .= "<br><br><br>";
    $html .= "___________________________________________<br>";
    $html .= "           Assinatura do Aluno(a)";
    
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
$mpdf->WriteHTML('<h2><img src="img/if.png"/> Compromisso Ético(TCC)</h2><br>');
$mpdf->SetFooter('{DATE j/m/Y  H:i} Bragança Paulista||Pagina {PAGENO}/{nb}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();