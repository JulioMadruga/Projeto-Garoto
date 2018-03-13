<?php

require '../Database/Conexao.php';
require '../PHPMailer/PHPMailerAutoload.php';

$razao = $_POST['razao'];
$cnpj = $_POST['cnpj'];
$status = $_POST['selEstado'];
$cnpj2 = str_replace('/','',str_replace('-','',str_replace('.','',$cnpj)));
$datafim = $_POST['datafim'];
$obs = $_POST['obs'];
$Rca = $_POST['rca'];

$data = str_replace('/','-',$datafim);

$time = strtotime($data);

$newformat = date('Y-m-d',$time);



$atuaStatus = $conn->prepare("UPDATE solicitacao set estado = '$status' WHERE cnpj = $cnpj2");
$atuaStatus -> execute();


$atuadata = $conn->prepare("UPDATE solicitacao set datafim = '$newformat' WHERE cnpj = $cnpj2");
$atuadata -> execute();


$atuaObs = $conn->prepare("UPDATE solicitacao set obs = '$obs' WHERE cnpj = $cnpj2");
$atuaObs -> execute();

$atuaemail = $conn->prepare("SELECT a.email, a.nome, b.email, b.nome from usuarios a, supervisor b  where a.rca = b.rca and a.rca = $Rca");
$atuaemail -> execute();
$result_email = $atuaemail->fetchAll();
var_dump($result_email);

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.terra.com.br';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'julio@disnorteagil.com.br';                 // SMTP username
$mail->Password = '712196j';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->CharSet = 'UTF-8';

$mail->setFrom('julio@disnorteagil.com.br','Julio');
$mail->addAddress($result_email[0][0], $result_email[0][1]);     // Add a recipient
//$mail->addAddress('ewerton@disnorteagil.com.br');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC($result_email[0][2], $result_email[0][3]);
$mail->addBCC('ewerton@disnorteagil.com.br');
$mail->addBCC('julio@disnorteagil.com.br');

if ($status == "Aprovado"){

    $mail->addCC('fabiano@disnorteagil.com.br');
    $mail->addCC('sarah@disnorteagil.com.br');

}

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'STATUS DE SUA SOLICITAÇÃO';

    $mail->Body = '<p style="font-family:Dosis; font-size: 20px; color: #335a67; ">Ol&aacute; <strong style="color: #164c5d; "> '.str_replace('VG','',str_replace('CBA','',$result_email[0][1])).'
    </strong> segue para acompanhamento sua Solicitação referente ao cliente: <strong>'.$razao.' </strong></p>
 <p style="font-family:Dosis; font-size: 20px; color: #335a67; "> O estatus de seu pedido foi alterado para: <strong>'.$status.'</strong></p>
 <p style="font-family:Dosis; font-size: 20px; color: #335a67; ">Obs: <strong style = "background:#f5d986">'.$obs .' </strong> </p>
 ';

//$mail->msgHTML(file_get_contents('../PHPMailer/examples/contents.html'), dirname(__FILE__));
$mail->AltBody = 'email teste';

if (!$mail->send()) {
    echo 'Mensagem não enviada';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Mensagem enviada - '.$result_email[0][1].'-'.$result_email[0][0].'<br>';
}






   echo ("<script>alert('Solicitação Atualizada!!!');</script>");
   header("Location:solicitacao.php");



?>