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
require_once '../Database/Conexao.php';

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

$bat = $result_cont[0][0];
$tal = $result_cont[0][1];
$ser = $result_cont[0][2];
          
 $consulta_baton= $conn->prepare("select id, rca, vendedor from(Select id, vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca, rca from (SELECT a.id, b.vendedor,a.nome_parceiro, a.quantidade, a.material in($bat) as Baton, a.material in($tal) as Talento, b.vendedor as vend, b.trimarca, b.rca FROM $mes a, $meta b where a.material in ($bat,$tal) and a.quantidade>0 and a.vendedor= b.rca) sub group by nome_parceiro)sub where baton>0 and talento>0 and rca = '$vendedor'");
 $consulta_baton->execute(array('id' => $id));
 $result_baton= $consulta_baton->fetchAll(); 

 
 $consulta_tri= $conn->prepare("SELECT Vendedor, Cod_Cliente, Nome FROM clientes WHERE rca = '$vendedor' order by nome");
 $consulta_tri->execute(array('id' => $id));
 $result_tri= $consulta_tri->fetchAll();
 
  //$arrayFinal = array_unique(array_merge($result_baton, $result_meta));
 

 $consulta_TOTAL= $conn->prepare("select sum(trimarca) as tri, sum(reali) as reali, sum(trimarca) - Sum(reali) as dif from(select vendedor,trimarca, Count(nome_parceiro)as reali, if(trimarca -Count(nome_parceiro)<0,0,trimarca -Count(nome_parceiro)) as dif from(Select vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca from (SELECT b.vendedor,a.nome_parceiro, a.quantidade,  a.material in($bat) as Baton, a.material in($tal) as Talento, b.vendedor as vend, b.trimarca FROM $mes a, $meta b where a.material in ($bat,$tal) and a.quantidade>0 and a.vendedor= b.rca) sub group by nome_parceiro)sub where baton>0 and talento>0 group by vendedor)sub");
 $consulta_TOTAL->execute(array('id' => $id));
 $result_TOTAL= $consulta_TOTAL->fetchAll();


$consulta_positivar= $conn->prepare("SELECT Vendedor,Cod_Cliente,Nome from clientes WHERE Cod_Cliente NOT IN 
(select id from(Select id, vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca, rca from 
(SELECT a.id, b.vendedor,a.nome_parceiro, a.quantidade, a.material in($bat) as Baton, a.material in($tal) as Talento, 
b.vendedor as vend, b.trimarca, b.rca FROM $mes a, $meta b where a.material in ($bat,$tal) and a.quantidade>0 and a.vendedor= b.rca) sub
 group by nome_parceiro)sub where baton>0 and talento>0 and rca = '$vendedor')and rca = $vendedor");
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
        <link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
        <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="css/bootstrap.css.map">
    <link rel="stylesheet" href="css/menu_mobile.css" >
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/calc_total.js"></script>
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
    <div id="navigation">
        <div id="menuToggle">

            <input id="menu_mob_imp" type="checkbox" />
            <!--
           Algumas ações do menu.

            Usando Before/After para conseguir o efeito burger.
            -->
            <span></span>
            <span></span>
            <span></span>

            <ul id="menu_mob">
                <li role="presentation" ><a href="interno.php">Metas</a></li>
                <li role="presentation"><a href="vendas.php">Vendas no mês</a></li>
                <li role="presentation"><a href="baton.php">Post. Baton</a></li>
                <li role="presentation" class="active"><a href="#">Post. Bimarca</a></li>
                <li role="presentation"><a href="jumbos.php">Post. Jumbos</a></li>
                <li role="presentation"><a href="solicitacao.php">Solicitação de Cadastro</a></li>
                <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;">
                    <input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.href='controle.php?tipo=sair'"></li>

                <li role="presentation" ><h5 style="color: #5d6267; font-family: sans-serif;padding-top: 4px; font-size: 35px">Você esta logado como <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>

            </ul>
        </div>
    </div>
    <div class="row" style="padding-top: 115px;">

        <div class="col-md-12" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 80px; padding-top: 5px;">
            <img style=" position: absolute; left: 40px; margin-top: 20px;" src="../images/disnorte.png">
            <h2>SISTEMA DE ACOMPANHAMENTO DE METAS</h2>
            <img style=" position: absolute; right: 50px; margin-top: -54px;" src="../images/garoto.png">
        </div>


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
           <tr style="background-color: #074456; color: #90ADB5; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 680px; height: 90px; text-align: center; font-size: 25px;"><img src="images/trimarca.png"></td>
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




       if (count($result_tri) ) {

           foreach($result_tri as $row) {

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
<h2 style="text-align:center;"class="btn btn-default btn-lg link2"><a style="padding:6px;"href="trimarca.php">Voltar</a><h2>
</div>

</div>

';
                 
       
       
       
       ?>
        
        
        
    </body>
</html>
