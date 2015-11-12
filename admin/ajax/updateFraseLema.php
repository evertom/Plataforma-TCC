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

$dados['fraselema'] = $fraselema;
$where = " idgrupo = {$idgrupo}";

$resposta = $pdo->update($dados, $tabela, $where);

if($resposta === TRUE){
    $res['ok'] = true;
    $res['msg'] = "Frase Lema atualizado com sucesso...";
    echo json_encode($res);
}  else {
    $res['ok'] = false;
    $res['msg'] = "Falha ao atualizar Frase Lema...";
    echo json_encode($res);
}