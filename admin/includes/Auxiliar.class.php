<?php
/*
  - PDO::PARAM_STR – para valores strings, datas, horas…
  - PDO::PARAM_INT – para valores inteiros
  - PDO::PARAM_BOOL – para valor booleano (true ou false)
  - PDO::PARAM_NULL – valor nulo (null)
  - PDO::PARAM_LOB – representa valores de grande quantidade de dados
  - PDO::PARAM_STMT – representa um conjunto de registros, atualmente não é suportado por nenhum
 */

function antiInjection($var, $q = '') {
    //Verifica se o parâmetro é um array
    if (!is_array($var)) {
        //identifico o tipo da variável e trato a string
        switch (gettype($var)) {
            case 'double':
            case 'integer':
                $return = $var;
                break;
            case 'string':
                /* Verifico quantas vírgulas tem na string.
                  Se for mais de uma trato como string normal,
                  caso contrário trato como String Numérica */
                $temp = (substr_count($var, ',') == 1) ? str_replace(',', '*;*', $var) : $var;
                //aqui eu verifico se existe valor para não adicionar aspas desnecessariamente    
                if (!empty($temp)) {
                    if (is_numeric(str_replace('*;*', '.', $temp))) {
                        $temp = str_replace('*;*', '.', $temp);
                        $return = strstr($temp, '.') ? floatval($temp) : intval($temp);
                    } elseif (get_magic_quotes_gpc()) {
                        //aqui eu verifico o parametro q para o caso de ser necessário utilizar LIKE com %
                        $return = (empty($q)) ? '\'' . str_replace('*;*', ',', $temp) . '\'' : '\'%' . str_replace('*;*', ',', $temp) . '%\'';
                    } else {
                        //aqui eu verifico o parametro q para o caso de ser necessário utilizar LIKE com %
                        $return = (empty($q)) ? '\'' . addslashes(str_replace('*;*', ',', $temp)) . '\'' : '\'%' . addslashes(str_replace('*;*', ',', $temp)) . '%\'';
                    }
                } else {
                    $return = $temp;
                }
                break;
            default:
                /* Abaixo eu coloquei uma msg de erro para poder tratar
                  antes de realizar a query caso seja enviado um valor
                  que nao condiz com nenhum dos tipos tratatos desta
                  função. Porém você pode usar o retorno como preferir */
                $return = 'Erro: O Tipo da Variável é Inválido!';
        }
        //Retorna o valor tipado
        return $return;
    } else {
        //Retorna os valores tipados de um array
        return array_map('antiInjection', $var);
    }
}

function converte_data($data) {
    if (isset($data)) {
        //recebe o parâmetro e armazena em um array separado por -
        $data = explode('-', $data);
        //armazena na variavel data os valores do vetor data e concatena /
        $data = $data[2] . '-' . $data[1] . '-' . $data[0]; // a/m/d
        //retorna a string da ordem correta, formatada
    }
    return $data;
}

function reverte_data($data) {
    if (isset($data)) {
        //recebe o parâmetro e armazena em um array separado por -
        $data = explode('-', $data);
        //armazena na variavel data os valores do vetor data e concatena /
        $data = $data[2] . '-' . $data[1] . '-' . $data[0]; // d/m/a
        //retorna a string da ordem correta, formatada
    }
    return $data;
}

function Getfloat($str) { //função pra transformar string em moeda ex (1.000,13 p/ 1003.13)
    if (strstr($str, ",")) {
        $str = str_replace(".", "", $str);
        $str = str_replace(",", ".", $str);
    }

    if (preg_match("#([0-9\.]+)#", $str, $match)) {
        return floatval($match[0]);
    } else {
        return floatval($str);
    }
}

function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

/* forma de uso

  $cnpj = "11222333000199";
  $cpf = "00100200300";
  $cep = "08665110";
  $data = "10102010";
  $valor = "100000";
  $hora = "021050";

  echo mask($hora,'Agora são ## horas ## minutos e ## segundos');
  echo mask($hora,'##:##:##');
  echo mask($valor,'#.###,##');
  echo mask($cnpj,'##.###.###/####-##');
  echo mask($cpf,'###.###.###-##');
  echo mask($cep,'#####-###');
  echo mask($data,'##/##/####');

 */

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        }else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function limString($string, $value, $clean = false) {
    if ($clean == true) {
        $string = strip_tags($string);
    }
    if (strlen($string) <= $value) {
        return $string;
    }

    $lim_String = substr($string, 0, $value);
    $last = strrpos($lim_String, ' ');
    return substr($string, 0, $last);
}

function removeAcentos($str) {
    $str = htmlentities($str, ENT_COMPAT, 'UTF-8');
    $str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1', $str);
    $str = preg_replace('/[,(),;:|!"$%~^><ªº&#@]/', "", $str);
    return html_entity_decode($str);
}

function getBase() {
    if (!defined('URLBASE')) {
        $_servidor = $_SERVER['SERVER_NAME'];
        if ($_servidor == 'localhost') {
            define("URLBASE", "http://" . $_servidor . "/gigasystems");
        } else {
            define('URLBASE', '/');
        }
    }
    return URLBASE;
}

function getAgent() {
    $navegador = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('?MSIE ([0-9].[0-20]{1,2})?', $navegador, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Internet Explorer';
    } elseif (preg_match('?Opera/([0-9].[0-9]{1,2})?', $navegador, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Opera';
    } elseif (strrpos($navegador, 'OPR')) {
        $posicao_inicial = strpos($navegador, 'OPR') + strlen('OPR');
        $browser_version2 = substr($navegador, $posicao_inicial, 5);
        $browser_version = str_replace("/", "", $browser_version2);

        $browser = 'Opera';
    } elseif (strrpos($navegador, 'Trident/7.0; rv:')) {
        $posicao_inicial = strpos($navegador, 'Trident/7.0; rv:') + strlen('Trident/7.0; rv:');
        $browser_version = substr($navegador, $posicao_inicial, 4);

        $browser = 'Internet Explorer';
    } elseif (preg_match('?Firefox/([0-9\\.]+)?', $navegador, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Firefox';
    } elseif (preg_match('?Chrome/([0-9\\.]+)?', $navegador, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Chrome';
    } elseif (preg_match('?Safari/([0-9\\.]+)?', $navegador, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Safari';
    } else {
        // browser not recognized!
        $browser_version = 0;
        $browser = 'Navegador Desconhecido';
    }

    return $browser . '(' . $browser_version . ')';
}
?>