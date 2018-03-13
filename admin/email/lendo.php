<?php
require_once "Database/Conexao.php";

$directory = realpath('./arquivos/descompactados');
$pasta = $directory;

$dir = $pasta;

$scan = scandir($dir);

if(count($scan) > 2) {


}

else {

    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=processados.php'>";

}

if(is_dir($pasta))
{ $diretorio = dir($pasta);

$i = 0;

while(($arquivo = $diretorio->read()) !== false) {



    if($i>1) {

        echo $nome2 =$arquivo;

      //  echo '<a href="?nome=' . $arquivo . ' ">' . $arquivo . '</a><br />';

        $local = realpath('./arquivos/descompactados');

       $arquivo = $local . '\\' . $arquivo;
        $local2 = $local . '\\' . $arquivo;

        $nome = $arquivo;

// Abre o Arquvio no Modo r (para leitura)

        $arquivo = fopen($arquivo, 'r');

// Lê o conteúdo do arquivo
        while (!feof($arquivo)) {

            $linha = fgets($arquivo, 1024);
            // $result=explode(" ",$linha);
            // echo $linha.'<br />';}

            If (substr($linha, 0, 1) == '1') {

                $result = explode("  ", $linha);

                // var_dump($result);

                // Num pedido
                $num_ped = intval(substr($result[0], 5, 10));

                // cod. cli
                $cod_cli = intval(substr($result[11], 2, 12));

                //data
                $data = substr($result[26], 0, 4) . '-' . substr($result[26], 4, 2) . '-' . substr($result[26], 6, 2);


            }

            If (substr($linha, 0, 1) == '2') {

                $result2 = explode("  ", $linha);

                //  var_dump($result2);


                //Cod Produto
                $produto = intval(substr($result2[10], 19, 17));

                //Quant. Prod
                $quant = intval(substr($result2[10], 37, 14));

                $valor = intval(substr($result2[10], 51, 29));

                $valor2 = substr($valor, 0, -2) . '.' . substr($valor, -2, 2);

                $valor2 . '<br>';


                $consulta_ped= $conn->prepare("SELECT cod_ped FROM ped_flexx where cod_ped = $num_ped and cod_prod = $produto");
                // var_dump($consulta_nf);
                $consulta_ped-> execute();
                $result_ped= $consulta_ped->fetchAll();


                if (empty($result_ped)){

                    $insert_ped = $conn->prepare("INSERT INTO ped_flexx (cod_ped,cod_cli,cod_prod,quant,valor,data) values ('$num_ped','$cod_cli','$produto','$quant','$valor2','$data')");

                    var_dump($insert_ped);
                    $insert_ped->execute();
                }

            }


        }

        // Fecha arquivo aberto
        fclose($arquivo);

        $origem = $nome;
        $destino = realpath('./arquivos/processados/') . '\\' . $nome2;
       // var_dump($destino);
        copy($origem, $destino);
        chmod($origem, 0777);



         $arq = realpath('./arquivos/descompactados/' . '\\' . $nome2);
        var_dump(is_file($arq));
//chmod( $arq, 0777 );
        unlink($arq);

   }

$i++;

    }
    $diretorio->close();


}else{
    echo 'A pasta não existe.';
}



echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=processados.php'>";





?>