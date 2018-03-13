<?php


$vendedor = $_POST['vendedor'];
$email = $_POST['email'];
$meta = $_POST['mes'];
$regiao = $_POST['regiao'];
$rca = $_POST['rca'];


if($vendedor == null  || $email == null || $regiao == null ){

    if($vendedor == null) {

        echo("<script>alert('Favor informar o vendedor');</script>");

    }

    if($email == null) {

        echo("<script>alert('Favor informar o email');</script>");

    }

    if($regiao == null) {

        echo("<script>alert('Favor Informar a Região');</script>");

    }

     echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cadastrar.php'>";



}else{


    $username = "root";
    $password = "";

    $conn = new PDO('mysql:host=localhost;dbname=xls', $username, $password);



    $Cad_Vend= $conn->prepare("INSERT INTO usuarios (rca,nome, email, senha, tipo, acesso, nacesso,regiao) values ('$rca','$vendedor','$email','agilvendas','logar','2015-09-23','0','$regiao')");
    var_dump($Cad_Vend);
    $Cad_Vend->execute();


    $Cad_Vend2= $conn->prepare("INSERT INTO $meta (vendedor,rca ,serenta_amor, candybar, talento_mini, talento, baton, cobertura_kg, cobertura_500g, cobertura_2kg, pastilha, baton_tab, tabletes, sortido, kg, valor, trimarca, result_tri, meta_baton) values ('$vendedor','$rca','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')");
    var_dump($Cad_Vend2);
    $Cad_Vend2->execute();

    echo ("<script>alert('O Vendedor ".$vendedor." foi cadastrado com Sucesso !!!');</script>");




   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cadastrar.php'>";
}

?>