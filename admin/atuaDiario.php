<?php

require_once '../Database/Conexao.php';





$arquivo = $_FILES['filename']['tmp_name'];


$arquivo_entrada = fopen($arquivo,"r");

$deleterecords = "TRUNCATE TABLE venda_diaria"; //Esvaziar a tabela
$limpa = $conn->prepare($deleterecords);
$limpa->execute();


$vend = "";
while (!feof($arquivo_entrada)) {

    $linha=fgets($arquivo_entrada);
    //$result=explode("|",$linha);


/*
    If(substr($linha,0,3)== 'Ped') {
        $result=explode(";",$linha);





    }*/



    If(substr($linha,0,4)== 'Vend') {
        $result=explode(";",$linha);

  $vend = substr($result[1],0,3);
    var_dump($result);

        $result=explode(";",$linha);
        //  echo $vend . "-".$result[3]."-".$result[29]."<br>";
        $insert_vol = $conn->prepare("INSERT INTO venda_diaria (rca, cod_cli,valor) values ('$vend','$result[19]','$result[32]')");
        //var_dump($insert_vol);
        $insert_vol->execute();

    }

    if(substr($linha,0,3)== 'Ped'){




        $result=explode(";",$linha);
    //  echo $vend . "-".$result[3]."-".$result[29]."<br>";
        $insert_vol = $conn->prepare("INSERT INTO venda_diaria (rca, cod_cli,valor) values ('$vend','$result[3]','$result[29]')");
        //var_dump($insert_vol);
        $insert_vol->execute();


    }



}


$insert_vol = $conn->prepare("select rca, sum(cast(replace(replace(valor, '.', ''), ',', '.') as decimal(10,2)))  as valor from venda_diaria GROUP  by rca");
$insert_vol->execute();
$result_cli = $insert_vol->fetchAll();






echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=index.php'>";

?>


