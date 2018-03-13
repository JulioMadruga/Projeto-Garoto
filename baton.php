<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'autenticador.php';
require_once 'Database/Conexao.php';

$aut = Autenticador::instanciar();

$usuario = null;
if ($aut->esta_logado()) {
    $usuario = $aut->pegar_usuario();
}
else {
    $aut->expulsar();
     
}
date_default_timezone_set('America/Cuiaba'); 
$id = $usuario->getNome();
$vendedor = $usuario->getRca();
$date = date('Ymd' );
 
  
    $data = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
    
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
    
     $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );
 
 $meta = $mes_meta["$mes"];
 
 $mes = $mes_extenso["$mes"];
// var_dump($mes);
 
 if (isset($_GET['mes'])){
    $meta = $_GET['mes'];
    
    $mes_select = array(
        'meta1' => 'Janeiro',
        'meta2' => 'Fevereiro',
        'meta3' => 'Marco',
        'meta4' => 'Abril',
        'meta5' => 'Maio',
        'meta6' => 'Junho',
        'meta7' => 'Julho',
        'meta8' => 'Agosto',
        'meta11' => 'Novembro',
        'meta9' => 'Setembro',
        'meta10' => 'Outubro',
        'meta12' => 'Dezembro'
    );
    
    $mes = $mes_select["$meta"];
}
 
          $check0 = $check1 = $check2 = $check3 = $check4 = $check5 = $check6 = $check7 = $check8 = $check9 = $check10 = $check11 ="";       
          switch ($meta) {
  case "meta1": {
    $check0 = "selected";
    break;
  }
  case "meta2": {
    $check1 = "selected";
    break;
  }
  case "meta3": {
    $check2 = "selected";
    break;
  }
  case "meta4": {
    $check3 = "selected";
    break;
  }
  case "meta5": {
    $check4 = "selected";
    break;
  }
  case "meta6": {
    $check5 = "selected";
    break;
  }
  case "meta7": {
    $check6 = "selected";
    break;
  }
  case "meta8": {
    $check7 = "selected";
    break;
  }
  case "meta9": {
    $check8= "selected";
    break;
  }
  case "meta10": {
    $check9 = "selected";
    break;
  }
  case "meta11": {
    $check10 = "selected";
    break;
  }
  case "meta12": {
    $check11 = "selected";
    break;
  }
}


if (isset($_POST['enviar'])){
$vendedor = $_POST['select_ved'];
$id = $vendedor;
$data = $_POST['select_mes'];
$mes = $data;
}else{
$vendedor=$vendedor;


}

$cont_tri = $conn->prepare("select * from trimarca");
$cont_tri->execute();
$result_cont = $cont_tri->fetchAll();

$bat = $result_cont[0][3];

 $consulta_baton= $conn->prepare("select id,vendedor, Nome from (SELECT a.VENDEDOR, a.ID, b.Nome,a.MATERIAL IN ($bat)AS baton, a.Quantidade FROM $mes a, clientes b where a.vendedor = b.rca AND a.ID=b.Cod_Cliente and a.MATERIAL IN ($bat) and a.VENDEDOR=$vendedor)sub GROUP by id");
 $consulta_baton->execute(array('id' => $id));
 $result_baton= $consulta_baton->fetchAll(); 

 
 $consulta_cli= $conn->prepare("SELECT Vendedor, Cod_Cliente, Nome FROM clientes WHERE rca = '$vendedor' order by nome");
 $consulta_cli->execute(array('id' => $id));
 $result_cli= $consulta_cli->fetchAll();
 
  //$arrayFinal = array_unique(array_merge($result_baton, $result_meta));


$consulta_positivar= $conn->prepare("SELECT Vendedor,Cod_Cliente,Nome from clientes WHERE Cod_Cliente NOT IN 
(select id from (SELECT a.VENDEDOR, a.ID, b.Nome,a.MATERIAL IN ($bat)AS baton, a.Quantidade 
FROM $mes a, clientes b where a.vendedor = b.rca AND a.ID=b.Cod_Cliente and a.MATERIAL IN ($bat) 
and a.VENDEDOR=$vendedor)sub GROUP by id ORDER BY id)and rca = $vendedor");
$consulta_positivar->execute();
$result_positivar= $consulta_positivar->fetchAll();





?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel Administrador</title>
        <style type="text/css">
          .link a { color: #000000;}
          .link a:hover {text-decoration: none; font-weight: bold;
          background: #9ef15c;
          }
          .link2 a { color: #000000;}
          .link2 a:hover {text-decoration: none; font-weight: bold;
                  }
            table, th, td {
   border: none;  border-bottom:solid; border-collapse: collapse; border-color: #245269; padding: 3px;
}  </style>


         <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
        <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="css/bootstrap.css.map">
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/calc_total.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

     <script>   // aqui eh a base da pagina
window.onload = function(){

    document.getElementById('mes').onchange = function(){
        vd = document.getElementById('vendedor').innerText;
        window.location = '?mes=' + this.value +'&vd='+vd;
    }

}



</script>


    </head>
    <body>
    <div class="row">

        <div class="col-md-12" style="text-align: right; background-color:#000000; color: #ffffff; padding-top:3px; padding-bottom:3px;">
            <ul class="nav nav-pills" style="padding-left: 10px; padding-right: 10px;">

                <li role="presentation" ><a href="interno.php">Metas</a></li>
                <li role="presentation"><a href="vendas.php">Vendas no mês</a></li>
                <li role="presentation" class="active"><a href="#">Post. Baton</a></li>
                <li role="presentation"><a href="bimarca.php">Post. Bimarca</a></li>
                <li role="presentation"><a href="jumbos.php">Post. Jumbos</a></li>
                <li role="presentation"><a href="solicitacao.php">Solicitação de Cadastro</a></li>
                <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;"><input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.  href='controle.php?tipo=sair'"></li>
                <li style="float: right; padding-top: 1px; margin-top: -5px;"> <h5 style=" height: 30px; padding-top: 5px; padding-right: 5px; text-align:center; color: #0D3744">
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Trocar Senha <i class="glyphicon glyphicon-lock" aria-hidden="true"></i></button>
                    </h5></li>

                <li role="presentation" style="float: right;"><h5 style="color: #A6CFF3; font-family: sans-serif;padding-top: 4px;">Você esta logado como <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>
            </ul>

        </div>

    </div>
        <div id="nav" class="col-lg-12" style="background: #121415;">

        </div>
     <div class="row" style="padding-top: 50px;background: #737373;">

        <div class="col-md-2"></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="images/disnorte.png"></div>
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="images/garoto.png"></div>
        <div class="col-md-2"></div>

       </div>

       <?php
       echo '
         <div class="row" style="background: #737373;">   
         <div class="col-md-2"></div> 
         <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px; padding-top: 5px;"></div> 
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px;">
        Selecionar Mês: &nbsp&nbsp
       <select id="mes" name="mes"style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 200px; font-size: 18px;text-align: center; font-weight: bold;" > 
      option value="">-   -    -   - Selecionar   -   -   -   -</option>
    <option value="meta1"'.$check0.'>Janeiro</option>   
      <option value="meta2"'.$check1.'>Fevereiro</option>
      <option value="meta3"'.$check2.'>Março</option>
      <option value="meta4"'.$check3.'>Abril</option>
      <option value="meta5"'.$check4.'>Maio</option>
      <option value="meta6"'.$check5.'>Junho</option>
      <option value="meta7"'.$check6.'>Julho</option>
      <option value="meta8"'.$check7.'>Agosto</option>
      <option value="meta9"'.$check8.'>Setembro</option>
      <option value="meta10"'.$check9.'>Outubro</option>
      <option value="meta11"'.$check10.'>Novembro</option>
      <option value="meta12"'.$check11.'>Dezembro</option> 
      </select>


</div>
       
       <div class="col-md-2" style="margin: auto; background-color:#074456;font-family:Oswald; color:#E4F3F7;height: 32px;"> 

</div>
       
        <div class="col-md-2"></div> 
       
    </div>  
    
<div class="row" style="background: #737373; height:15px;">
<div class="col-md-2"></div>
<div class="col-md-8" style="background: #CED4D6; height: 15px;"></div>
<div class="col-md-2"></div>

</div>
    
<div id="tri" class="row" style="background: #737373;">
<div class="col-md-2" ></div>
<div class="col-md-1" style="background: #CED4D6; height: 90px;"></div>
<div class="col-md-6" style=" background: #CED4D6; height: 90px;">    
<table align="center" cellpadding="5"> 
           <tr style="background-color: #84071D; color: #FFFFFF; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 680px; height: 90px; text-align: center; font-size: 25px;background: #FF2012;"><img src="images/baton2.png"></td>
           </tr>
</table>
           </div>
<div class="col-md-1" style="background: #CED4D6; height: 90px;"></div>
<div class="col-md-2"></div>

</div>







<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 20px; background-color:#CED4D6; font-family:Oswald; color:#270301;">
<table id="tabela" align="center" cellpadding="5" style="color:#0F4150;">


<tr style="font-size: 16px;background: #095409;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Cod. Cliente</td>
<td style="width: 350px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Razão Social</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Status</td>





</tr>



';




       if (count($result_cli) ) {

           foreach($result_cli as $row) {

               $verfic = true;


               foreach ($result_baton as $row2){

                   if($row[1] == $row2[0]){
                       echo '<tr class="success" style="background: #5cb85c; font-size:20px;">';
                       echo'<td id="vendedor"style="width: 150px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[1].'</td>';
                       echo '<td style="width: 350px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[2].'</td>';
                       echo '<td style="width: 200px; text-align: center; border: solid; border-color: #CED4D6;">Positivado</td>';
                       $verfic = false;

                   }

               }




               echo "</tr>";




           }
       } else {
           echo "Nennhum resultado retornado.";
           echo $id;

       }

       echo '


</table>

<div class="col-md-12" style="height: 50px;"></div> 


<table id="tabela" align="center" cellpadding="5" style="color:#0F4150;">
  
<tr style="font-size: 16px;background: #860c0a;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Cod. Cliente</td>
<td style="width: 350px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Razão Social</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: aliceblue;">Status</td>


</tr>


';



       if (count($result_positivar) ) {

           foreach($result_positivar as $row) {




               echo '<tr class="success" style="background: #b7afaf; font-size:20px; color: #9c1c1c;">';
               echo '<td id="vendedor"style="width: 150px; text-align: center; border: solid; border-color: #CED4D6;">' . $row[1] . '</td>';
               echo '<td style="width: 350px; text-align: center; border: solid; border-color: #CED4D6;">' . $row[2] . '</td>';
               echo '<td style="width: 200px; text-align: center; border: solid; border-color: #CED4D6;"></td>';



           }




           echo "</tr>";




       }
       else {
           echo "Nennhum resultado retornado.";
           echo $id;

       }






       echo '
</table>
</br>
<h2 style="text-align:center;"class="btn btn-default btn-lg link2"><a style="padding:6px;"href="baton.php">Voltar</a><h2>
</div>

</div>

';




       ?>



    </body>
</html>
