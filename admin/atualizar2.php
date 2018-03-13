<?php

$username = "root";
$password = "";

$baton = $_POST['baton'];
$talento = $_POST['talento'];
$serenata =  $_POST['serenata'];
$baton2 =  $_POST['baton2'];
$jumbos =  $_POST['jumbos'];



$conn = new PDO('mysql:host=localhost;dbname=xls', $username, $password);

$atuaBaton = $conn->prepare('UPDATE trimarca set baton = "'.$baton.'"');
 $atuaBaton-> execute();


$atuaTalento = $conn->prepare('UPDATE trimarca set talento = "'.$talento.'"');
$atuaTalento-> execute();


$atuaSerenata = $conn->prepare('UPDATE trimarca set serenata = "'.$serenata.'"');
$atuaSerenata-> execute();

$atuaBaton2 = $conn->prepare('UPDATE trimarca set baton2 = "'.$baton2.'"');
$atuaBaton2-> execute();


$atuaJumbos = $conn->prepare('UPDATE trimarca set jumbos = "'.$jumbos.'"');
$atuaJumbos-> execute();





echo ("<script>alert('Dados Atualizado com Sucesso!!!');window.history.go(-1);</script>"); die;
     
      
      
      ?>