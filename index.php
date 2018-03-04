<?php

$array = array(0 => 100, ["color" => "red"]);

function array_keys_recursive($arr) {
    foreach ($arr as $key => $value) {
        $result[] = $key;

        if (is_array($value)) {
            $result = array_merge($result, array_keys_recursive($value));
        }
    }
    return $result;
}

var_dump(array_keys_recursive($array));