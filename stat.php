<?php 
require_once(dirname(__DIR__).'/wp-load.php');  //Подключаем wordpress
//wp_head();   //подгружаем стили которые в шапке

require 'class/db.php';

//для получения лиги
$tx = get_terms(array(
    "taxonomy" => "joomsport_tournament",
    "hide_empty" => false
));

$json= array();//массив для json
$mas = [];//массив для php
foreach ($tx as $txitem) {

$json[$txitem->term_id] = $txitem ->name;

}

foreach ($json as $team => $value) {
    array_push($mas,$json[$team]);  
}
echo "подключён";
var_dump($mas);


?>