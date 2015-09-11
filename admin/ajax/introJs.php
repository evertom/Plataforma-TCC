<?php

    $id = isset($_POST['id']) ? $_POST['id']:"";
    
    require_once '../includes/Conexao.class.php';
    $pdo = new Conexao();
    
    $tabela = "users";
    $where = " uid = {$id}";
    $dados['primeiroacesso'] = 1;
    
    $result = $pdo->update($dados,$tabela,$where);
    
    if($result == true){
        return true;
    }else{
        return false;
    }