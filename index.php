<?php

$arr = ['name' => 'taylor', 'languages' => ['a' => 'php', 'b' => 'javascript']];

function array_change_key_case_recursive($arr, $case = CASE_LOWER)
{
    return array_map(function($item) use ($case){

        if (is_array($item)) {
            $item = array_change_key_case_recursive($item, $case);
        }

        return $item;

    }, array_change_key_case($arr, $case));
}

var_dump(array_change_key_case_recursive($arr, CASE_UPPER));