<?php

require_once 'config.php';


$conn = new PDO('mysql:host ='. HOST.';dbname='. DATABASE,USER,PASS,
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    )
);



?>
