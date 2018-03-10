<?php

$a = array(1, 2, 3, 4, 5);

$b = array_reduce($a, function ($item, $value) {
    $item *= $value;
    return $item;
}, 10);

var_dump($b);