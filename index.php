<?php

$arr = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

var_dump(($arr));

function array_flip_ci($input)
{
    $output = [];
    foreach ($input as $key => $values) {
            $output[$values] = $key;
    }
    return $output;
}

var_dump(array_flip_ci($arr));