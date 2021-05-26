<?php

require "vendor/autoload.php";

$data = [
    [
        123124124123123,
        "0123124124123123",
        "数字字符串和数字",
    ],
    [
        "b1",
        "b2中文",
        "b3",
    ]
];


$file = "./out/data.xlsx";
$res = \tools\Excel::putExcel($data, $file);
var_dump($res);


