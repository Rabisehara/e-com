<?php

$arr = ['a' => 1, 'b' => '2', 'c' => 3, 'd' => 4];

$f_data = array_filter($arr, function ($k) {
    return $k != 'b';
}, ARRAY_FILTER_USE_KEY);

$items = ["a","b","c"];
$isExists = in_array("g", $items);

if( $isExists ) {
    print_r($arr);
} else {
    print_r("not");
}

// print_r($isExists);
