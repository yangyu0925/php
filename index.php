<?php

$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");

function array_diff_ci($arr1, $arr2) {
    $result = [];

    foreach ($arr1 as $key => $value) {
        if (!in_array($value, $arr2)) {
            $result[$key] = $value;
        }
    }

    return $result;
}

print_r(array_diff_ci($array1, $array2));