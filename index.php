<?php

$a = array(1, 2, 3, 4, 5);

$b = array_map(function ($n) {
    return $n * $n * $n;
}, $a);

var_dump($a, $b);
