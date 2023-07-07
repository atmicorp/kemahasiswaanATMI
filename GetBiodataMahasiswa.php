<?php

include('init.php');
include('koneksi.php');
include('db.php');

$filter = '';
$order = '';
$limit = 0;
$offset = 0;

$data = array(
    'act' => 'GetBiodataMahasiswa',
    'token' => $token,
    'filter' => $filter,
    'order' => $order,
    'limit' => $limit,
    'offset' => $offset,
);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);

    $table = 'biodata_mahasiswa'; $idtbl = 'id_mahasiswa';
    $kolom = array('id_mahasiswa', 'nama_mahasiswa', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'id_agama', 'nik', 'nisn', 'npwp', 'id_negara', 
            'jalan', 'dusun', 'rt', 'rw', 'kelurahan', 'kode_pos', 'id_wilayah', 'id_jenis_tinggal', 'id_alat_transportasi', 'telepon', 'handphone', 'email', 
            'penerima_kps', 'nomor_kps', 'nik_ayah', 'nama_ayah', 'tanggal_lahir_ayah', 'id_pendidikan_ayah', 'nama_pendidikan_ayah', 'id_pekerjaan_ayah', 
            'nama_pekerjaan_ayah', 'id_penghasilan_ayah', 'nama_penghasilan_ayah', 'nik_ibu', 'nama_ibu_kandung', 'tanggal_lahir_ibu', 
            'id_pendidikan_ibu', 'nama_pendidikan_ibu', 'id_pekerjaan_ibu', 'nama_pekerjaan_ibu', 'id_penghasilan_ibu', 'nama_penghasilan_ibu', 
            'nama_wali', 'tanggal_lahir_wali', 'id_pendidikan_wali', 'nama_pendidikan_wali', 'id_pekerjaan_wali', 'nama_pekerjaan_wali', 
            'id_penghasilan_wali', 'nama_penghasilan_wali', 'id_kebutuhan_khusus_mahasiswa', 'nama_kebutuhan_khusus_mahasiswa', 
            'id_kebutuhan_khusus_ayah', 'nama_kebutuhan_khusus_ayah', 'id_kebutuhan_khusus_ibu', 'nama_kebutuhan_khusus_ibu', 'status_sync');

    $i=0; $query=''; $id='';$showdata=''; $add=0; $edit=0;
    foreach ($result['data'] as $key) { $isikolom = array(); $values_update = array();
        // ambil id 
        $id = $key[$idtbl]; 
        //echo $i.'. '.$idtbl.' dan isinya = '.$id.'<br>';
        $query_select = "SELECT * FROM $table  WHERE $idtbl = '$id'";
        $showdata = $mysqli->query($query_select);

        if ($showdata->num_rows > 0) {
            //update
            foreach (array_keys($result['data'][$i]) as $col) {
                while ($row = $showdata->fetch_assoc()) {
                    for ($k=0; $k < count($kolom); $k++) { 
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
                                $data = $mysqli->real_escape_string($key[$namakolom]);
                                $values_update[] = " $namakolom='$data' ";
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
            //insert
            for ($k=0; $k < count($kolom); $k++) { 
                foreach (array_keys($result['data'][$i]) as $col) {

                    // filter data sesuai kolom
                    if ($col == $kolom[$k]) { //kolom
                        if ($col == "tanggal_lahir" || $col == "tanggal_lahir_ayah"|| $col == "tanggal_lahir_ibu"|| $col == "tanggal_lahir_wali"){
                            if($key[$col]){ $isikolom[] = date('Y-m-d', strtotime($key[$col])); } else { $isikolom[] = $key[$col]; }
                        } else {
                            $isikolom[] = $mysqli->real_escape_string($key[$col]);
                        }
                    }

                }
                
            }
        

            $values = " ('". implode("', '", $isikolom) . "')";
            $val = json_decode($values, true);
            $query_insert = "INSERT INTO $table (".implode(', ', $kolom).") VALUES $values;";
            // echo $query_insert."<br>";
            $input = $mysqli->query($query_insert);
            if ($mysqli->affected_rows > 0) {
                echo "--> $i INSERT sycn<hr>";
            } else {
                echo "--> $i INSERT GAGAL<hr>";
            }
            $add++;
        }
            $i++;
    }
        
    $mysqli->close();
//echo "<h3>Sudah Input</h3>";

echo "Total TAMBAH biodata mahasiswa : $add <br> Total EDIT biodata mahasiswa : $edit ";
if (($add==0) && ($edit==0)) {
    echo "<h3>Sudah Input</h3>";
}
// echo "<pre>";
// print_r($result);
// echo "</pre>";