<?php

$values = array
(
    'Article'=>'24497',
    'Type'=>'LED',
    'Socket'=>'E27',
    'Dimmable'=>'',
    'Wattage'=>'10W'
);

$keys = array_fill_keys(array('Article','Wattage','Dimmable','Type','Foobar'), ''); // wanted array with empty value

$allkeys = array_replace($keys, array_intersect_key($values, $keys));    // replace only the wanted keys

var_dump($allkeys);
