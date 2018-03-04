<?php

$arr = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

var_dump(array_filter($arr, function($value) {
    return $value === 2;
}));

var_dump(array_filter($arr, function($key) {
    return $key === 'b';
}, ARRAY_FILTER_USE_KEY));

var_dump(array_filter($arr, function($value, $key) {
    return $key === 'b' || $value === 3;
}, ARRAY_FILTER_USE_BOTH));