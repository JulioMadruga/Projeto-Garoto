<?PHP

$username = "root";
$password = "";

$conn = new PDO('mysql:host=localhost;dbname=xls', $username, $password);

$senha1 = $_POST['senha'];

$senha2 = $_POST['senha2'];

$vendedor = $_GET['vend'];






if ($senha1 == $senha2){


    $atualizasenha= $conn->prepare("UPDATE usuarios set senha = '$senha1' where nome ='$vendedor' ");
    $atualizasenha->execute();

    echo ("<script>alert('Senha alterada com Sucesso !!!');</script>");
    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=interno.php'>";
    die;


}else {

    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=interno.php?cad=false'>";

}

?>