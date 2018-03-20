<?php

if (!($fp = fopen('date.txt', 'w'))) {
    return;
}

$year = 2018;
$month = 3;
$day = 20;

$a = fprintf($fp, "%04d---%02d---%02d", $year, $month, $day);

echo $a;