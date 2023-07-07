<?php

include('init.php');
include('koneksi.php');

$filter = '';
$order = '';
$limit = 0;
$offset = 0;

$data = array(
    'act' => 'GetAllPT',
    'token' => $token,
    'filter' => $filter,
    'order' => $order,
    'limit' => $limit,
    'offset' => $offset,
);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);
echo "<pre>";
print_r($result);
echo "</pre>";

