<?php 
    // Create connection
    $mysqli = new mysqli('localhost', 'root', '', 'db_atmi');
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
        exit();
    }

    return $mysqli;
?>