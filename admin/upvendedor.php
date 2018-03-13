<?php

require_once '../Database/Conexao.php';

date_default_timezone_set('America/Cuiaba');
$date = date('M' );

$mes_meta = array(
    'Jan' => 'meta1',
    'Feb' => 'meta2',
    'Mar' => 'meta3',
    'Apr' => 'meta4',
    'May' => 'meta5',
    'Jun' => 'meta6',
    'Jul' => 'meta7',
    'Aug' => 'meta8',
    'Nov' => 'meta11',
    'Sep' => 'meta9',
    'Oct' => 'meta10',
    'Dec' => 'meta12'
);


$meta = $mes_meta["$date"];



echo $meta;

echo '<br>';

echo $rca = $_POST['vend'];
echo $vendedor = $_POST['vendedor'];
echo $email = $_POST['email'];
echo $super = $_POST['selSuper'];

$atuavendedor = $conn->prepare("UPDATE usuarios set nome = '$vendedor' WHERE  rca = $rca");
$atuavendedor-> execute();

$atuavendedor2 = $conn->prepare("UPDATE $meta set vendedor = '$vendedor' WHERE  rca = $rca");
$atuavendedor2-> execute();


$atuaemail = $conn->prepare("UPDATE usuarios set email = '$email' WHERE  rca = $rca");
$atuaemail-> execute();


$atuasuper = $conn->prepare("UPDATE supervisor set nome = '$super', email = '$email' WHERE  rca = $rca");
$atuasuper-> execute();



echo ("<script>alert('Solicitação Atualizada!!!');</script>");
header("Location:cadvend.php");