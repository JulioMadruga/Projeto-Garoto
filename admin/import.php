<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Importação</title>
    </head>
    <body>
<div id="container">
<div id="form">

<?php

$username = "root";
$password = "";

$conn = new PDO('mysql:host=localhost;dbname=agil', $username, $password);

//Transferir o arquivo
if (isset($_POST['submit'])) {


$deleterecords = "TRUNCATE TABLE outubro"; //Esvaziar a tabela
$limpa = $conn->prepare($deleterecords);
 $limpa->execute();
  /*
    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
        echo "<h1>" . "File ". $_FILES['filename']['name'] ." transferido com sucesso ." . "</h1>";
        echo "<h2>Exibindo o conteúdo:</h2>";
        readfile($_FILES['filename']['tmp_name']);
    }*/

    //Importar o arquivo transferido para o banco de dados
    $handle = fopen($_FILES['filename']['tmp_name'], "r");

    while (($dados = fgetcsv($handle, 1000, ";")) !== FALSE) {
      $import= $conn->prepare("INSERT INTO outubro (RCA,Cod_Forn,Desc_Forn,Posit,Valor_Venda) Values ('$dados[0]','$dados[1]','$dados[2]','$dados[3]','$dados[4]')");
        $import->execute();
         //mysql_query($import) or die(mysql_error());
         //var_dump($import);
    }

    fclose($handle);

    print "Importação Realizada.";
    echo '<input type="button" value="Voltar" onClick="history.go(-1)"> ';

//Visualizar formulário de transferência
} else {



    print "Transferir novos arquivos CSV selecionando o arquivo e clicando no botão Upload<br />\n";

    print "<form enctype='multipart/form-data' action='#' method='post'>";

    print "Nome do arquivo para importar:<br />\n";

    print "<input size='50' type='file' name='filename'><br />\n";

    print "<input type='submit' name='submit' value='Upload'></form>";

}

?>

</div>
</div>
</body>
</html>
z