
<?php


    require '../PHPMailer/PHPMailerAutoload.php';
    require '../Database/Conexao.php';



$consulta_metatri = $conn->prepare("SELECT c.Rca, c.nome as vendedor, c.email, d.Email, d.nome, b.Nome, a.* FROM financeiro a, clientes b, usuarios c, supervisor d
 where a.Cod_Cli = b.Cod_Cliente and b.rca = c.rca and c.Rca = d.RCA and Cond_Pag in('z016','z859','z014') and a.Dt_Atraso > 15 GROUP by c.nome");
$consulta_metatri->execute();
$result_cli= $consulta_metatri->fetchAll();





    foreach ($result_cli as $i => $row){

        $verfic = true;

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.terra.com.br';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'julio@disnorteagil.com.br';        // SMTP username
    $mail->Password = '712196j';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('julio@disnorteagil.com.br', 'Julio');
    $mail->addAddress($row[2], $row[1]);     // Add a recipient
    //$mail->addAddress('julio@disnorteagil.com.br');
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC($row[3],$row[4]);
    $mail->addCC('n1.6627fi@garoto.com.br','Paulo Financeiro');
    $mail->addCC('fabiano@disnorteagil.com.br','Fabiano');
    $mail->addCC('sarah@disnorteagil.com.br','Sarah');
        $mail->addCC('nabil.cba@disnorteagil.com.br','Nabil');
    $mail->addBCC('julio@disnorteagil.com.br');
    //$mail->addBCC('bcc@example.com');
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'CLIENTE COM FATURAS EM ABERTO';

        $consulta_tri = $conn->prepare("SELECT c.nome, c.email, b.Nome, a.* FROM financeiro a, clientes b, usuarios c
        where a.Cod_Cli = b.Cod_Cliente and b.rca = c.rca and Cond_Pag in('z016','z859','z014') and a.Dt_Atraso > 15 and 
        c.Rca ='$row[0]' order by a.Dt_Atraso DESC");
        $consulta_tri->execute();
        $result_cob = $consulta_tri->fetchAll();


    $mail->Body = '
      
    <table style="width: 100%;background: #164c5d;border: solid;border-color: #ffffff;border-style: double;">
    
        <tr>
            <td style="width:200px; padding: 10px;"><img style="margin: 8px;" src="http://disnorteagil.no-ip.biz:8090/objetivos/images/garoto.png"></td>

            <td style="width:400px"></td>

            <td style="width:200px; padding: 10px;"><img style="float: right" src="http://disnorteagil.no-ip.biz:8090/objetivos/images/disnorte.png"></td>

        </tr>

    </table>



<p style="font-family:Dosis; font-size: 20px; color: #335a67; ">Ol&aacute; <strong style="color: #164c5d; "> '.str_replace('VG','',str_replace('CBA','',$row{'vendedor'})).'</strong> Segue list de cliente com débitos há mais de 15 dias</p>
<p style="font-family:Dosis; font-size:18px; color: #335a67;"><strong style="color: #164c5d; ">Favor lembrar o cliente do débito</strong></p>


<h3 style="font-family:Dosis; font-size: 20px; color: #335a67; ">Segue lista:</h3>

<table cellpadding="5" style="color:#0F4150; font-family:Dosis;  ">

<tr style = "height:40px">
        <td colspan="7" style="background: #FFC107;color: #E91E63;  font-size:20px; text-align: center;">CLIENTES INADIMPLENTES</td>
</tr>

<tr style="background: #FFEB3B;color: #E91E63; font-size:20px;">
 <td style="width: 150px; text-align: center; ">Cod. Cliente</td>
 <td style="width: 250px; text-align: center; ">Razão</td>
 <td style="width: 100px; text-align: center; ">NF</td>
 <td style="width: 100px; text-align: center; ">DT. FATURAMENTO</td>
 <td style="width: 100px; text-align: center; ">DT. VENCIMENTO</td>
 <td style="width: 80px; text-align: center; ">DIAS DE ATRAZO</td>
 <td style="width: 80px; text-align: center; ">VALOR</td>

</tr>
';
    foreach ($result_cob as $row2) {
        $mail->Body .='

        <tr style = "background: #fbf196;color: #3f4142; font-size:20px;" >
        <td style = "width: 150px; text-align: center; " > '.$row2[3].'</td >
        <td style = "width: 250px; text-align: left; padding-left: 8px; " > '.$row2[2].'</td >
        <td style = "width: 100px; text-align: center; " > '.substr($row2[4], 4, 5).'</td >
        <td style = "width: 100px; text-align: center; " > '.date('d/m/Y',strtotime($row2[5])).'</td >
        <td style = "width: 100px; text-align: center; " > '.date('d/m/Y',strtotime($row2[7])).'</td >
        <td style = "width: 50px; text-align: center; " > '.$row2[8].'</td >
        <td style = "width: 50px; text-align: right; padding-right: 8px;; " >R$ '.$row2[9].'</td >
        

    </tr >
';
}
        $mail->Body .='
</table>




    ';

    //$mail->msgHTML(file_get_contents('../PHPMailer/examples/contents.html'), dirname(__FILE__));
    $mail->AltBody = 'email teste';

    if (!$mail->send()) {
        echo 'Mensagem não enviada';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensagem enviada - '.$row{'vendedor'}.'-'.$row{'email'}.'<br>';
    }

        if ($i > 0 && $i % 10 == 0) {
            sleep(30);
        }


}






