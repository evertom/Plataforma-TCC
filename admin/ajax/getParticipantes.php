<?php
	$idgrupo = 	isset($_POST['idgrupo']) ? $_POST['idgrupo']:"";
	
	require_once('../includes/Administracao.class.php');
	require_once('../includes/Conexao.class.php');
	
	$pdo = new Conexao();
	$result = $pdo->select("SELECT * FROM grupo_has_users a 
                                INNER JOIN users b ON a.uid = b.uid 
                                WHERE a.idgrupo = $idgrupo ORDER BY b.username;");
        $cronograma = $pdo->select("SELECT * FROM cronograma a WHERE a.idgrupo = $idgrupo ;");
        $pdo->desconectar();
        $data = "<select name='idParticipantes[]' id='idParticipantes' class='selectpicker' multiple  data-max-options='5' data-min-options='1' required data-style='btn-info' title='De quem é a tarefa?' data-live-search='true' data-selected-text-format='count>2' >"
              . "<optgroup label='Participantes'>";
        
	if(count($result)){
            try {
                foreach ($result as $res){
                    $data .= "<option value='".$res['uid']."'>".$res['username']."</option>";
                }
                $data .= "</optgroup>";
                if(count($cronograma)){
                    $data .= "<input id='idcronograma' name='idcronograma' type='hidden' value='".$cronograma[0]['idcronograma']."'></input>";
                }else{
                    $data .= "<input id='idcronograma' name='idcronograma' type='hidden' value=''></input>";
                }
                $data .= "</select>";
                echo $data;
            }catch (PDOException $e){
                echo json_encode($e->getMessage());
            }
        }else{
            $data .= "<option value=''>Sem participantes</option>";
            $data .= "</optgroup>";
            $data .= "</select>";
            $data .= "<input id='idcronograma' name='idcronograma' type='hidden' value=''></input>";
            echo $data;
	}
?>