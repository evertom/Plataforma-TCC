<?php

class ConexaoCfg {

    private $data = array();
    protected $pdo = null;

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } $trace = debug_backtrace();
        trigger_error('Undefined property via __get(): ' . $name 
                . ' in ' . $trace[0]['file'] . ' on line ' 
                . $trace[0]['line'], E_USER_NOTICE);
        return null;
    }

    public function getPdo() {
        return $this->pdo;
    }

    function __construct($pdo = null) {
        $this->pdo = $pdo;
        if ($this->pdo == null) $this->conectar();
    }

    public function conectar() {
        try {
            $this->pdo = new PDO("mysql:host=186.202.152.241;dbname=vertice4", "vertice4", "V@it14", 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function desconectar() {
        $this->pdo = null;
    }

    public function select($sql) {
        if ($this->getPDO() == null) {
            $this->conectar();
        } 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contaReg($sql) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function insert(array $dados, $tabela) {
        $campos = implode(", ", array_keys($dados));
        $valores = "'" . implode("', '", array_values($dados)) . "'";
        $stmt = $this->pdo->prepare("INSERT INTO {$tabela} ({$campos}) VALUES ({$valores})");
        if ($stmt->execute()) {
            return true;
        } else {
            $this->erro = "<br/>Erro ao Cadastrar {$tabela}!!!";
            return false;
        }
    }

    public function update(array $dados, $tabela, $where) {
        foreach ($dados as $indice => $valor) {
            $campos[] = "{$indice} = '{$valor}'";
        } $campos = implode(', ', $campos);
        $stmt = $this->pdo->prepare("UPDATE {$tabela} SET {$campos} WHERE {$where}");
        if ($stmt->execute()) {
            return true;
        } else {
            $this->erro = "<br/>Erro ao atualizar {$tabela}!!!";
            return false;
        }
    }

    function converte_data($data) {
        if (isset($data)) {
            $data = explode('-', $data);
            $data = $data[2] . '/' . $data[1] . '/' . $data[0];
        } return $data;
    }

    function download($path, $fileName = '') {
        if ($fileName == '') {
            $fileName = basename($path);
        } header("Content-Type: application/force-download");
        header("Content-type: application/octet-stream;");
        header("Content-Length: " . filesize($path));
        header("Content-disposition: attachment; filename=" . $fileName);
        header("Pragma: no-cache");
        header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");
        readfile($path);
        flush();
    }

} ?>