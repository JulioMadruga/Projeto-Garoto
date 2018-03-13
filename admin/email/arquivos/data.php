<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Importação de Aquivos Flexx</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
</head>
<body>


<?php



//echo date("j F Y");

//echo date('j F Y', strtotime('-1 day'));

$directory = realpath('./aprocessar');
$pasta = $directory;

$dir = $pasta;

$scan = scandir($dir);

if(count($scan) > 2) {


}

else {

    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=../lendo.php'>";

}


if(is_dir($pasta))
{ $diretorio = dir($pasta);

$i=0;

    echo '<div class="col align-self-center" style="width: 500px; margin: auto; text-align: center; top:20px"> ' ;
    echo '<h1 class="btn btn-primary btn-lg btn-block"> Arquivos Processados </h1>';
    echo '<ul class="list-group">' ;

    while(($arquivo = $diretorio->read()) !== false)
    {

        $ext = pathinfo($arquivo, PATHINFO_EXTENSION);

        if($ext == "zip"){

            echo ' <li class="list-group-item d-flex justify-content-between align-items-center">';
            echo $arquivo;
            echo '<a href="?descompact='.$arquivo.'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Descompactar</a>';
            echo ' </li>';

           // echo '<a href="?descompact='.$arquivo.' ">'.$arquivo.'</a><br />';

        }else{

            if($i>1) {

                $arquivo_antigo = $arquivo;
                $arquivo_novo = $arquivo_antigo . '.zip';

                rename($directory . "\\" . $arquivo_antigo, $directory . "\\" . $arquivo_novo);

                echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=data.php#'>";

            }

        }

       $i++;

    }
    $diretorio->close();


    echo '</ul>';
    echo '</div>';

}else{
    echo 'A pasta não existe.';
}
/*
if(isset($_GET['nome'])){

    $arquivo_antigo = $_GET['nome'];
    $arquivo_novo = $arquivo_antigo.'.zip';

    rename($directory."\\".$arquivo_antigo, $directory."\\".$arquivo_novo);

    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=data.php#'>";


}

*/
if(isset($_GET['descompact'])) {

    $local = realpath('./aprocessar');

   $arquivo = $local.'\\'.$_GET['descompact'];

    $directory = realpath('.');

    $zip = new ZipArchive();
    if ($zip->open($arquivo) === true) {
        $zip->setPassword('6627');
        $zip->extractTo($directory . '/descompactados');
        $zip->close();

        unlink($arquivo);

        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=data.php#'>";

    }


}



?>


</body>
</html>
