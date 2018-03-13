<?php

$username = "root";
$password = "";


$mes = $_GET['mes'];
$now = $_GET['now'];


$conn = new PDO('mysql:host=localhost;dbname=xls', $username, $password);

$atuames = $conn->prepare("Drop table $now");
$atuames-> execute();

$atuames2 = $conn->prepare("CREATE TABLE $now SELECT * FROM $mes");
$atuames2-> execute();




echo ("<script>alert('Dados Atualizado com Sucesso!!!');window.history.go(-1);</script>"); die;
      
      
      ?>