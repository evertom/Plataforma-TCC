<?php

require_once '../verifica-logado.php';

function strClear($texto) {
    $texto = html_entity_decode($texto);
    $texto = strtolower($texto);
    $texto = str_replace('[ÁÀÂÃÄáàâãä]', 'a', $texto);
    $texto = str_replace('[ÉÈÊËéèêë]', 'e', $texto);
    $texto = str_replace('[ÍÌÎÏíìîï]', 'i', $texto);
    $texto = str_replace('[ÓÒÔÕÖóòôõö]', 'o', $texto);
    $texto = str_replace('[ÚÙÛÜúùûü]', 'u', $texto);
    $texto = str_replace('[Çç]', 'c', $texto);
    $texto = str_replace('[Ññ]', 'n', $texto);
    $texto = str_replace('[ +-,./\\?!;:()]', '', $texto);
    $texto = str_replace('\'', '', $texto);
    $texto = str_replace('[^a-z0-9 ]', ' ', $texto);
    $texto = trim($texto);
    $texto = str_replace(' ', '-', $texto);
    return $texto;
}

date_default_timezone_set('America/Sao_Paulo');
define('DS', DIRECTORY_SEPARATOR);
define('BASE', '../GerenciamentoGrupos' . DS . 'ArquivoFinal' . DS);

$idAtaDefesa = (filter_input(INPUT_POST, 'idAtaDefesa')) ? filter_input(INPUT_POST, 'idAtaDefesa') : "";
$idgrupo = (filter_input(INPUT_POST, 'idgrupo')) ? filter_input(INPUT_POST, 'idgrupo') : "";
$status = (filter_input(INPUT_POST, 'status')) ? filter_input(INPUT_POST, 'status') : "";
$titulo = (filter_input(INPUT_POST, 'titulo')) ? filter_input(INPUT_POST, 'titulo') : "";
$nota = (filter_input(INPUT_POST, 'nota')) ? filter_input(INPUT_POST, 'nota') : "";
$disponibilizar = (filter_input(INPUT_POST, 'disponibilizar')) ? filter_input(INPUT_POST, 'disponibilizar') : 0;

$ok = false;
$titulo = strClear($titulo);
$nota = str_replace(',', '.', $nota);

$dados['status'] = $status;
$dados['disponibilizar'] = $disponibilizar;
$dados['nota'] = $nota;

if (!empty($_FILES['file'])) {

    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    $caminho = BASE . $titulo . '.' . $ext;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $caminho)) {
        $dados['arqFinal'] = "GerenciamentoGrupos/ArquivoFinal/" . $titulo . '.' . $ext;
        $ok = true;
    }
}

$where = "  idAtaDefesa = {$idAtaDefesa}";
$tabela = "atadefesa";

require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$result = $pdo->update($dados, $tabela, $where);

if ($result === TRUE) {
    $retorno['msg'] = "Nota da Banca cadastrada com sucesso";
    $arr['descricao'] = "Atenção, o(a) Orientador(a) responsável pelo seu grupo, lançou sua nota no sistema";
    
    if ($ok === TRUE) {
        $retorno['msg'] .= " e Arquivo final disponibilizado para consulta com sucesso...";
        $arr['descricao'] .= " e disponibilizou o arquivo na plataforma para consulta.";
    }
    echo json_encode($retorno);
} else {
    $retorno['msg'] = "Falha ao cadastrar Nota final da Banca...";
    echo json_encode($retorno);
}


$sql = "SELECT * FROM grupo_has_users WHERE idgrupo = {$idgrupo} AND tipo = 1";
$resultado = $pdo->select($sql);

foreach($resultado as $res){
    $tabela = "avisos";
    $arr['data'] = date('Y-m-d');
    $arr['visto'] = 0;
    $arr['uid'] = $res['uid'];
    $arr['de'] = $id_users;
    
    $pdo->insert($arr, $tabela);
}