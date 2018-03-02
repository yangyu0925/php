<?php

$arr = ['name' => 'taylor', ['a' => 'php', 'b' => 'javascript']];

function array_change_value_case_recursive($arr, $case = CASE_LOWER)
{
    return array_map(function ($item) use ($case) {
        if (is_array($item)) {
            return array_change_value_case_recursive($item, $case);
        } else {
            return $case === CASE_LOWER ? strtolower($item) : strtoupper($item);
        }
    }, $arr);
}

print_r(array_change_value_case_recursive($arr, CASE_UPPER));