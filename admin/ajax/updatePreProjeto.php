<?php

$tabela = 'grupo';
$where = NULL;
$idgrupo = NULL;

$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
(isset($getPost) ? $setPost = array_map('strip_tags', $getPost) : "");
(isset($setPost) ? $post = array_map('trim', $setPost) : "");
extract($post);

require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$dados['objetivoGeral'] = $objGeral;
$dados['objetivoEspecifico'] = $objEspec;
$dados['justificativa'] = $justificativa;
$dados['tipodePesquisa'] = $tipoPesquisa;
$dados['metodologia'] = $metodologia;
$dados['resultadoEsperado'] = $resultados;

$where = " idgrupo = {$idgrupo}";

$resposta = $pdo->update($dados, $tabela, $where);

if($resposta === TRUE){
    $res['ok'] = true;
    $res['msg'] = "Pré projeto atualizado com sucesso...";
    echo json_encode($res);
}  else {
    $res['ok'] = false;
    $res['msg'] = "Falha ao atualizar Pré Projeto...";
    echo json_encode($res);
}