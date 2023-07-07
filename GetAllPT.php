<?php

include('init.php');
include('koneksi.php');
include('db.php');

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

$table = 'perguruan_tinggi';
$idtbl = 'id_perguruan_tinggi';
$kolom = implode(", ", array_keys($result['data'][0]));

$i=0; $query='';
foreach ($result['data'] as $key => $value) {
    $id = $key[$idtbl];
    $query_select = "SELECT * FROM $table  WHERE $idtbl = '$id'";
    $showdata = $mysqli->query($query_select);

    if ($showdata->num_rows > 0) {
        //update
        foreach (array_keys($result['data'][$i]) as $col) {
            while ($row = $showdata->fetch_assoc()) {
                for ($k=0; $k < count(array_keys($result['data'][0])); $k++) { 
                    $namakolom = $kolom[$k];

                    //format tgl key[namakolom]
                    if ($namakolom == "tanggal_lahir" || $namakolom == "tanggal_lahir_ayah"|| $namakolom == "tanggal_lahir_ibu"|| $namakolom == "tanggal_lahir_wali"){
                        if($key[$namakolom]){ $key[$namakolom] = date('Y-m-d', strtotime($key[$namakolom])); } else { $key[$namakolom] = $key[$namakolom]; }
                    } else {
                        $key[$namakolom] = $key[$namakolom];
                    }
                    if($key[$namakolom]!=''){
                        // filter data sesuai kolom
                        if ($key[$namakolom] != $row[$namakolom]) { //kolom
                            //echo "baru -> $namakolom : $key[$namakolom] | lama $row[$namakolom] <br>";
                            $values_update[] = " $namakolom='$key[$namakolom]' ";
                        }
                    }
                }
            }
        }
        if($values_update){
             $query_update = "UPDATE $table SET " . implode(", ", $values_update) . " WHERE $idtbl = '$id';";
             echo $query_update."<br>";
            $update = $mysqli->query($query_update);
            if ($mysqli->affected_rows > 0) {
                echo "--> $i Update sycn<hr>";
            } else {
                echo "--> $i Update GAGAL<hr>";
            }
            $edit++;
        }
    } else {

    }

    $values = ' ("'. implode('", "', array_values($result['data'][$i])) . '")';
    $query = "INSERT INTO $table ($kolom) VALUES $values;";
    echo $query."<br>";
    $input = $mysqli->query($query);
    if ($mysqli->affected_rows > 0) {
        echo "simpan";
    } else {
        echo "gagal";
    }
    $i++;
}
    $mysqli->close();

echo "<h3>Sudah Input</h3>";


echo "<hr><pre>";
print_r($result);
echo "</pre>";

