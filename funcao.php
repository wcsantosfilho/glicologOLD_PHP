<?php

$nome = "Walter";

$exibe = function ($x) use (&$nome) {
    echo $nome," - Valor de X:",$x,"<br>";
    $nome = "Joao";
    echo "Nome :",$nome,"<br>";
    };

$arrayX = [0,1,1,2,3,5,8,13,21];
echo "Nome :",$nome,"<br>";
array_walk ($arrayX, $exibe);
echo "Nome :",$nome,"<br>";

//function somar($x, $y) {
//    return $x+$y;
//}
//
//$valor = somar(10,20)+somar(40,50);
//echo $valor,"<br>";
//

?>