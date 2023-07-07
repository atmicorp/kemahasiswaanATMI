<?php

include('init.php');
include('koneksi.php');
include('db.php');

$filter = '';
$order = '';
$limit = 0;
$offset = 0;

$data = array(
    'act' => 'GetPeriode',
    'token' => $token,
    'filter' => $filter,
    'order' => $order,
    'limit' => $limit,
    'offset' => $offset,
);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);

    $table = 'periode'; $idtbl = 'id_periode';
    $kolom = array('id_prodi', 'periode_pelaporan', 'tipe_periode');
    $i=0; $query='';
    foreach ($result['data'] as $key) { $isikolom = array();
        for ($k=0; $k < count($kolom); $k++) { 
            foreach (array_keys($result['data'][$i]) as $col) {
                if ($col == $kolom[$k]) { //kolom
                    $isikolom[] = $key[$col];
                }
            }
            
        }
        
        $values = ' ("'. implode('", "', $isikolom) . '")';
        $val = json_decode($values, true);
        $query = "INSERT INTO $table (".implode(', ', $kolom).") VALUES $values;";
        //echo $query."<hr>";
        $input = $mysqli->query($query);
        if ($mysqli->affected_rows > 0) {
            echo "sycn <br>";
        } else {
            echo "nope <br>";
        }
        $i++;
    }
//         $mysqli->close();
// echo "<h3>Sudah Input</h3>";

echo "<pre>";
print_r($result);
echo "</pre>";