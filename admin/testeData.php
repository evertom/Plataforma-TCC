<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo strtotime(date('d-m-Y'));

$data1 =  mktime(37,16,16,06,19,2015);
$data2 =  mktime(37,16,11,06,19,2015);

if($data1 > $data2){
    echo "data 1 ".$data1;
}else{
    echo "data 2 ".$data2;
}