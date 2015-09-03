<?php
require_once '../verifica-logado.php';
require_once '../includes/Conexao.class.php';
$pdo = new Conexao();

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
@extract($post);

$tabela = "avisos";
$dados['descricao'] = "O professor enviou as seguintes considerações ao Grupo sobre a monografia: <b>{$consideracoes}</b>";
$dados['data'] = date('Y-m-d');
$dados['visto'] = 0;
$dados['de'] = $id_users;

$result = $pdo->select("SELECT * FROM grupo_has_users gu WHERE gu.idgrupo = {$idgrupo} AND gu.tipo = 1");

foreach($result as $res){
    $dados['uid'] = $res['uid'];
    
    $insert = $pdo->insert($dados,$tabela);
}