<?php
require('class.mysql.php');
require('config.inc.php');

@session_start();
ob_start(); // Inicia o fluxo

$nick = $_SESSION['usu_nick']; 

	$sql = new Mysql;
	//conta quantos usuarios ainda estao no chat
	$result = $sql->Consulta("SELECT count(nick) as 'soma' FROM chat_usu");
	//recebe contagem
	$contagem = mysql_fetch_assoc($result);	
	$total = $contagem['soma'];
	
	//caso não tenha mais usuarios online paga todas as menssagens e imprime PDF, se não ele somente monta o PDF
	if($total == 0){
		$resultado = $sql->Consulta("Select usuario,msg FROM historico");
		$html = '';
		if(count($resultado)){
			while ($row = mysql_fetch_assoc($resultado)) {	
				$html.= '<div><strong>Usuario : </strong>'.$row['usuario'].'</div>
						 <div><strong>Mensagem : </strong>'.$row['msg'].'</div>
						';
			}
		}
		
		define('MPDF_PATH', 'MPDF57/');
		include(MPDF_PATH.'mpdf.php');
		$mpdf=new mPDF();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->useOnlyCoreFonts = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('TCC');
		$mpdf->SetWatermarkImage('icones/logoif.png', 1, '', array(140,10));
		$mpdf->showWatermarkImage = true;
		$mpdf->WriteHTML('<br/><h1>Ata de Reuni&atilde;o do TCC</h1><hr/>');
		$mpdf->SetFooter('{DATE j/m/Y  H:i}||Pagina {PAGENO}/{nb}');
		$mpdf->WriteHTML($html);
		
		$sql->Consulta("DELETE FROM $tabela_msg ");
		$sql->Consulta("DELETE FROM historico");
		@session_destroy();
		
		$mpdf->Output();
		exit(); 
		
	}else{
	
		$resultado = $sql->Consulta("Select usuario,msg FROM historico");
		$html = '';
		if(count($resultado)){
			while ($row = mysql_fetch_assoc($resultado)) {	
				$html.= '<div><strong>Usuario : </strong>'.$row['usuario'].'</div>
						 <div><strong>Mensagem : </strong>'.$row['msg'].'</div>
						';
			}
		}
		 
		if (count($resultado)){
			//imprime em pdf
				define('MPDF_PATH', 'MPDF57/');
				include(MPDF_PATH.'mpdf.php');
				$mpdf=new mPDF();
				$mpdf->SetDisplayMode('fullpage');
				$mpdf->useOnlyCoreFonts = true;
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$mpdf->SetWatermarkText('TCC');
				$mpdf->SetWatermarkImage('icones/logoif.png', 1, '', array(140,10));
				$mpdf->showWatermarkImage = true;
				$mpdf->WriteHTML('<br/><h1>Ata de Reuni&atilde;o do TCC</h1><hr/>');
				$mpdf->SetFooter('{DATE j/m/Y  H:i}||Pagina {PAGENO}/{nb}');
				$mpdf->WriteHTML($html);
				$mpdf->Output();
				@session_destroy();
				exit();
		}
	}
?>


<!-- echo "<script language='javascript'> 
window.open('impPdf.php', '_blank'); 
</script>"; -->