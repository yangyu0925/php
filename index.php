<?php

function array_insert(&$arr, $pos, $new_el=null) {
    $arraypad = array_pad($arr, count($arr)+1, 0);
    for ($i = count($arraypad) - 1; $i>=$pos; $i--) {
        $arr[$i] = $arr[$i-1];
        if ($i == $pos) {
            $arr[$i] = $new_el;
        }
    }
}

$digits = array();
$digits[0] = 0;
$digits[1] = 1;
$digits[2] = 2;
$digits[3] = 3;
$digits[4] = 4;
$digits[5] = 5;

array_insert($digits, 3, 100);
echo "new: "; var_dump($digits);






