<?php

include('init.php');
include('koneksi.php');
include('db.php');

$data = array(
    'act' => 'GetProfilPT',
    'token' => $token,
);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);

// $table = 'profil_pt';
// $kolom = implode(", ", array_keys($result['data'][0]));
// $values = '"'. implode('", "', array_values($result['data'][0])) . '"';
// $query = "INSERT INTO $table ($kolom) VALUES ($values);";

//     echo "<h3>Sudah Input</h3>";
//     $input = $mysqli->query($query);

//     if ($mysqli->affected_rows > 0) {
//         echo "simpan";
//     } else {
//         echo "gagal";
//     }
//     $mysqli->close();
echo "<h3>Sudah Input</h3>";

echo "<br><br><pre>";
print_r($result);
echo "</pre>";