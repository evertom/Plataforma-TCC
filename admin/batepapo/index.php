<?php
require('class.mysql.php');
require('config.inc.php');

$pressionadoBotao = isset($_POST['Submit']) ? trim($_POST['Submit']) : false;
$erro = '';
if ($pressionadoBotao == true) {
    $nick = $_POST['nick'];

    if (substr_count($nick, ' ') == strlen($nick)) {
        $erro = 'Apelido não pode conter somente espaços em branco.';
    } else {
        //evitando problemas com javascript ',"",(,),|
        $nick = str_replace('"', ' ', $nick);
        $nick = str_replace(';', '', $nick);
        $nick = str_replace('(', '', $nick);
        $nick = str_replace(')', '', $nick);
        $nick = str_replace("'", " ", $nick);
        $nick = str_replace('|', '', $nick);
        $nick = sql_inject($nick);

        $sql = new Mysql;
        //deleta usuarios sem atividade
        $sql->Consulta("DELETE FROM $tabela_usu WHERE tempo < $tempovida");
        //deleta mensagens antigas
        $sql->Consulta("DELETE FROM $tabela_msg  WHERE tempo < $tempovida");

        //total de usuarios online
        $totalonline = $sql->Totalreg("SELECT COUNT(*) FROM $tabela_usu");
        if ($totalonline == 0) {
            include('deletarimg.php');
        }

        //verificando se ja tem este nick
        $total = $sql->Totalreg("SELECT COUNT(*) FROM $tabela_usu WHERE nick='$nick'");
        if ($total > 0) {
            $erro = 'Este apelido ja está em uso.';
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            //insere usuario
            $sql->Consulta("INSERT INTO $tabela_usu(nick,frase,cor,ip,tempo)VALUES('$nick','','#006699','$ip','$tempo_usu')");
            //insere no chat
            $sql->Consulta("INSERT INTO $tabela_msg(reservado,usuario,cor,msg,falacom,tempo)VALUES('0','$nick','#006699','entrou na sala.','Todos','$tempo_msg')");
            //inicia a sessao
            session_start();
            ob_start(); // Inicia o fluxo

            $_SESSION['usu_nick'] = $nick;
            //redireciona
            header('Location:principal.php');
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Chat TCC</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="fundo.css" rel="stylesheet" type="text/css">
        <link href="estilo.css" rel="stylesheet" type="text/css">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function desabilita() {
                document.form1.Submit2.disabled = true;
                //document.form1.Submit.value = 'Enviando...';
            }
        </script>

    </head>
    <body>
        <div id="caixaApelido" align="center">
            <table width="538" border="0" cellspacing="0" cellpadding="5" class="borda">
                <tr> 
                    <td height="71"><img src="icones/logoif.png" /></td>
                </tr>
                <tr> 
                    <td height="28" align="center" class="texto11"><?php ($erro != '' ? print $erro:"");?></td>
                </tr>
                <tr> 
                    <td height="58" align="center"> 
                        <form name="form1" method="post" action="index.php" onSubmit="desabilita()">
                            <table class=" table">
                                <tr>
                                    <td >
                                        <input type="text" name="nick"  class="form-control"  maxlength="20" placeholder="Digite seu apelido..." /> 
                                    </td>
                                    <td width="72">
                                        <input type="submit" name="Submit2" value="Entrar" class="btn btn-success">
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="Submit" value="1">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td height="5">&nbsp;</td>
                </tr>
                <tr> 
                    <td height="14" align="center">
                        <p><span class="style2">Escolha seu apelido e entre no Chat para reuni&atilde;o</span></p></td>
                </tr>
            </table>
        </div>
    </body>
</html>