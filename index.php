<?php

$a = array(
    array(
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ),
    array(
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    )
);

print_r(array_column($a, 'first_name'));

array_walk($a, function (&$value, $key, $return) {
    $value = $value[$return];
}, 'first_name');

print_r($a);