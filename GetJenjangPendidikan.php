<?php

include('init.php');
include('koneksi.php');
include('db.php');

$filter = '';
$order = '';
$limit = 0;
$offset = 0;

$data = array(
    'act' => 'GetJenjangPendidikan',
    'token' => $token,
    'filter' => $filter,
    'order' => $order,
    'limit' => $limit,
    'offset' => $offset,
);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);

// $table = 'jenjang_pendidikan';
// $kolom = implode(", ", array_keys($result['data'][0]));

// $i=0; $query='';
// foreach ($result['data'] as $key => $value) {
//     $values = ' ("'. implode('", "', array_values($result['data'][$i])) . '")';
//     $query = "INSERT INTO $table ($kolom) VALUES $values;";
//     echo $query."<br>";
//     $input = $mysqli->query($query);
//     if ($mysqli->affected_rows > 0) {
//         echo "sycn <br>";
//     } else {
//         echo "nope <br>";
//     }
//     $i++;
// }
//     $mysqli->close();
echo "<h3>Sudah Input</h3>";

echo "<pre>";
print_r($result);
echo "</pre>";

