<?php
    $host = "localhost";
    $port = "3307";
    $username_db = "root";
    $password_db = "root";
    $database_name = "uas_web";

    $conn = mysqli_connect($host . ":" . $port, $username_db, $password_db, $database_name);

    function amankanInputan($conn, $value){
        return htmlspecialchars($value);
    }

?>