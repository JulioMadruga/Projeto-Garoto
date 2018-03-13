<?php
require '../Database/Conexao.php';

$razao = $_POST['razao'];
$cnpj = $_POST['cnpj'];
$rca = $_GET['rca'];
$cnpj2 = str_replace('/','',str_replace('-','',str_replace('.','',$cnpj)));

echo $razao.'<br>';
echo $rca.'<br>';
echo str_replace('/','',str_replace('-','',str_replace('.','',$cnpj))).'<br>';

$verif = $conn->prepare("select cnpj from solicitacao where cnpj = $cnpj2");
$verif -> execute();
$result_verif= $verif ->fetchAll();

if(empty($result_verif)) {


    $cadcliente = $conn->prepare("Insert into solicitacao (rca,cnpj,razao,estado,obs,dataini,datafim) VALUES ('$rca','$cnpj2','$razao','Pendente','',curdate(),CURDATE() + INTERVAL 20 DAY)");
    $cadcliente->execute();

    echo ("<script>alert('Solicitação Enviada com Sucesso!!!');</script>");
    header("Location:solicitacao.php?rca=$rca");

}

echo '<script> alert("JÁ EXISTE UMA SOLICITAÇÃO PARA ESTE CNPJ'.$CNPJ.'");window.history.go(-1); </script>';die;

echo ("<script>alert('Dados Atualizado com Sucesso!!!');window.history.go(-1);</script>"); die;


?>