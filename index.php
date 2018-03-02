<?php

function flipAndGroup($input) {
    $outArr = array();
    array_walk($input, function($value, $key) use (&$outArr) {
        if(!isset($outArr[$value]) || !is_array($outArr[$value])) {
            $outArr[$value] = [];
        }
        $outArr[$value][] = $key;
    });
    return $outArr;
}

$users_countries = array(
    'username1' => 'US',
    'user2' => 'US',
    'newuser' => 'GB'
);
print_r(flipAndGroup($users_countries));