<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once '../usuario.php';
require_once '../sessao.php';
require_once '../autenticador.php';
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



$cont_tri = $conn->prepare("select * from trimarca");
$cont_tri->execute();
$result_cont = $cont_tri->fetchAll();

$bat = $result_cont[0][3];



    $consulta_ADAILTON = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
    FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a , $meta b, supervisor c
    where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Adailton' GROUP BY VENDEDOR");
    $consulta_ADAILTON->execute();
    $result_ADAILTON = $consulta_ADAILTON->fetchAll();




    $consulta_ADAILTON2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Adailton') order by vendedor");
    $consulta_ADAILTON2->execute(array('id' => $id));
    $result_ADAILTON2 = $consulta_ADAILTON2->fetchAll();

// var_dump($result_ADAILTON2);

    $consulta_TOTAL = $conn->prepare("Select sum(meta_baton), sum(realizado), IF(sum(meta_baton) - sum(realizado)<0,0,sum(meta_baton) - sum(realizado)) AS DIF from ( SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton FROM $mes a, $meta b where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca group by a.id)SUB GROUP BY VENDEDOR)sub");
    $consulta_TOTAL->execute(array('id' => $id));
    $result_TOTAL = $consulta_TOTAL->fetchAll();


$mes_sel = array(
    '1' => 'Janeiro',
    '2' => 'Fevereiro',
    '3' => 'Marco',
    '4' => 'Abril',
    '5' => 'Maio',
    '6' => 'Junho',
    '7' => 'Julho',
    '8' => 'Agosto',
    '11' => 'Novembro',
    '9' => 'Setembro',
    '10' => 'Outubro',
    '12' => 'Dezembro'
);



?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel Administrador</title>
        <style type="text/css">
        .link a { color: #000000;}
        .link a:hover {text-decoration: none; font-weight: bold;
        }
        .link:hover{ background: #9ef15c;}

        </style>

         <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
                <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.js"></script>
    <script src="../js/calc_total.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     
     <script>   // aqui eh a base da pagina
         window.onload = function(){
             document.getElementById('regiao').onchange = function(){
                 window.location = '?regiao=' + this.value + '&mes=' + document.getElementById('mes').value;

             }
             document.getElementById('mes').onchange = function(){
                 window.location = '?mes=' + this.value;


             }

         }


$(document).ready( function(){
    
$("#painel").hide(); 
$("#painel").slideDown(1500);  

$("tr:even").css("background","rgba(208, 63, 54, 0.63)");
//$("tr:last").css("background","#820505");


});

jQuery(document).ready(function (e) {
    function t(t) {
        e(t).bind("click", function (t) {
            t.preventDefault();
            e(this).parent().fadeOut()
        })
    }
    e(".dropdown-toggle").click(function () {
        var t = e(this).parents(".button-dropdown").children(".dropdown-menu").is(":hidden");
        e(".button-dropdown .dropdown-menu").hide();
        e(".button-dropdown .dropdown-toggle").removeClass("active");
        if (t) {
            e(this).parents(".button-dropdown").children(".dropdown-menu").toggle().parents(".button-dropdown").children(".dropdown-toggle").addClass("active")
        }
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-menu").hide();
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-toggle").removeClass("active");
    })
});

</script>
     
     
    </head>
    <body>
         <div id="nav" class="col-lg-12"  style="background: #121415;">
             <ul class="nav">
                 <li role="presentation"><a href="index.php">Parcial</a></li>
                 <li role="presentation"><a href="resumo.php">Resumo de vendas</a></li>
                 <li role="presentation"  ><a href="metas.php">Metas</a></li>
                 <li class="button-dropdown" id="active" ><a href="javascript:void(0)" class="dropdown-toggle">  Positivações  <span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li><a href="trimarca.php">Bi-Marca</a></li>
                         <li><a href="#">Baton</a></li>
                         <li><a href="jumbos.php">Jumbos</a></li>

                     </ul>

                 </li>
                 <li role="presentation"><a href="acessos.php">Relat. de Acessos</a></li>
                 <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle"> Cadastros <span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li role="presentation" ><a href="cadastrar.php">Cadastrar Metas</a></li>
                         <li role="presentation" ><a href="campanha.php">Cad. Campanhas</a></li>
                         <li role="presentation" ><a href="cadvend.php">Cad. Vendedores</a></li>
                         <li role="presentation" ><a href="solicitacao.php">Solic. Cadastros</a></li>

                     </ul>

                 </li>
                 < <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">Importacao<span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li><a href="Importacao.php">Resultados</a></li>
                         <li><a href="clientes.php">Clientes</a></li>
                         <li role="presentation" ><a href="financeiro.php">Financeiro</a></li>
                         <li role="presentation" ><a href="importDiario.php">Venda Diaria</a></li>


                     </ul>

                 </li>
                 <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;"><input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.  href='../controle.php?tipo=sair'"></li>
                 <li role="presentation" style="float: right;"><h5 style="color: #A6CFF3; font-family: sans-serif;padding-top: 4px;">Usuário: <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>

             </ul>
        </div>     <div class="row" style="padding-top: 50px;background: #737373;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div> 
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div> 
        <div class="col-md-2"></div>
        
       </div>     
        

         <div class="row" style="background: #737373;">   
         <div class="col-md-2"></div> 
         <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px; padding-top: 5px;"></div> 
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px;">
        Selecionar Mês: &nbsp&nbsp

            <?php echo' <select id="mes" name="mes"style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 200px; font-size: 18px;text-align: center; font-weight: bold;" > 
      
';

            $i=1;


            while ($i <= 12) {
                $consulta_mes = $conn->prepare("SELECT data_doc from " . $mes_sel [$i] . " limit 1");
                $consulta_mes->execute();
                $result_mes = $consulta_mes->fetchAll();


                echo '
    
     <option value="meta' . $i . '"';

                if ($i > 9) {
                    if ($i == substr($meta, -2)) {
                        echo 'selected';
                    }
                } else{
                    if ($i == substr($meta, -1)) {
                        echo 'selected';
                    }
                }

                if(empty($result_mes)){

                    echo '>'.$mes.' - '.$ano.'</option>';

                }else{

                    echo '>'.$mes_sel[$i].' - '.substr($result_mes[0][0], -4).'</option>';

                }

                $i++;
            };

            ?>

<?php

echo '         





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
    
<div id="baton" class="row" style="background: #737373;">
<div class="col-md-2" ></div>
<div class="col-md-1" style="background: #CED4D6; height: 90px;"></div>
<div class="col-md-6" style=" background: #CED4D6; height: 90px;">    
<table align="center" cellpadding="5"> 
           <tr style="background-color: #84071D; color: #FFFFFF; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 680px; height: 90px; text-align: center; font-size: 25px;background: #FF2012;"><img src="../images/baton2.png"></td>
           </tr>
</table>
           </div>
<div class="col-md-1" style="background: #CED4D6; height: 90px;"></div>
<div class="col-md-2"></div>

</div>

<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 15px; background-color:#CED4D6; font-family:Oswald; color:#270301;">




</div>

<div class="col-md-2"></div> 
</div>


    
<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 15px; background-color:#CED4D6; font-family:Oswald; color:#270301;">
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - ADAILTON</td>
</tr>
<tr style="font-size: 16px;background: #820505;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';


       
    
if (count($result_ADAILTON2) ) {
       $i=0;
    foreach($result_ADAILTON2 as $row) {
        
        extract($row);
       
                $verfic = true;
                           echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
                           echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
                           echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
                           foreach ($result_ADAILTON as $row2){
                               If($row[0] == $row2[0]){
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                           $verfic = false;
  
                           //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }
                                                                                         
                           } 
                           
                           If($verfic == true){
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
  
                           //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }
      echo "</tr>"; 
    
      
   $i++;
   
    }  
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;
   
  }



$consulta_ALDENOR = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Aldenor' GROUP BY VENDEDOR");
$consulta_ALDENOR->execute();
$result_ALDENOR = $consulta_ALDENOR->fetchAll();




$consulta_ALDENOR2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Aldenor') order by vendedor");
$consulta_ALDENOR2->execute(array('id' => $id));
$result_ALDENOR2 = $consulta_ALDENOR2->fetchAll();





    echo '</table>';
      echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - ALDENOR</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_ALDENOR2) ) {
       $i=0;
    foreach($result_ALDENOR2 as $row) {

        extract($row);

                $verfic = true;
                           echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
                           echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
                           echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
                           foreach ($result_ALDENOR as $row2){
                               If($row[0] == $row2[0]){
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                           $verfic = false;

                           //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }

                           }

                           If($verfic == true){
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
                           echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

                           //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }
      echo "</tr>";


   $i++;

    }
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;

  }

    echo '</table>';

$consulta_ANDERSON = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Anderson' GROUP BY VENDEDOR");
$consulta_ANDERSON->execute();
$result_ANDERSON = $consulta_ANDERSON->fetchAll();




$consulta_ANDERSON2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Anderson') order by vendedor");
$consulta_ANDERSON2->execute(array('id' => $id));
$result_ANDERSON2 = $consulta_ANDERSON2->fetchAll();





echo '</table>';
echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - ANDERSON</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_ANDERSON2) ) {
    $i=0;
    foreach($result_ANDERSON2 as $row) {

        extract($row);

        $verfic = true;
        echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
        echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
        echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
        foreach ($result_ANDERSON as $row2){
            If($row[0] == $row2[0]){
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                $verfic = false;

                //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
            }

        }

        If($verfic == true){
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

            //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
        }
        echo "</tr>";


        $i++;

    }
} else {
    echo "Nennhum resultado retornado.";
    echo $id;

}

echo '</table>';

$consulta_FABRICIO = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Fabricio' GROUP BY VENDEDOR");
$consulta_FABRICIO->execute();
$result_FABRICIO = $consulta_FABRICIO->fetchAll();




$consulta_FABRICIO2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Fabricio') order by vendedor");
$consulta_FABRICIO2->execute(array('id' => $id));
$result_FABRICIO2 = $consulta_FABRICIO2->fetchAll();





echo '</table>';
echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - FABRICIO</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_FABRICIO2) ) {
    $i=0;
    foreach($result_FABRICIO2 as $row) {

        extract($row);

        $verfic = true;
        echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
        echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
        echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
        foreach ($result_FABRICIO as $row2){
            If($row[0] == $row2[0]){
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                $verfic = false;

                //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
            }

        }

        If($verfic == true){
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

            //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
        }
        echo "</tr>";


        $i++;

    }
} else {
    echo "Nennhum resultado retornado.";
    echo $id;

}

echo '</table>';

$consulta_FERNANDO = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Fernando' GROUP BY VENDEDOR");
$consulta_FERNANDO->execute();
$result_FERNANDO = $consulta_FERNANDO->fetchAll();




$consulta_FERNANDO2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Fernando') order by vendedor");
$consulta_FERNANDO2->execute(array('id' => $id));
$result_FERNANDO2 = $consulta_FERNANDO2->fetchAll();





echo '</table>';
echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - FERNANDO</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_FERNANDO2) ) {
    $i=0;
    foreach($result_FERNANDO2 as $row) {

        extract($row);

        $verfic = true;
        echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
        echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
        echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
        foreach ($result_FERNANDO as $row2){
            If($row[0] == $row2[0]){
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                $verfic = false;

                //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
            }

        }

        If($verfic == true){
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

            //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
        }
        echo "</tr>";


        $i++;

    }
} else {
    echo "Nennhum resultado retornado.";
    echo $id;

}

echo '</table>';

$consulta_MARCIO = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Marcio Ferreira' GROUP BY VENDEDOR");
$consulta_MARCIO->execute();
$result_MARCIO = $consulta_MARCIO->fetchAll();




$consulta_MARCIO2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Marcio Ferreira') order by vendedor");
$consulta_MARCIO2->execute(array('id' => $id));
$result_MARCIO2 = $consulta_MARCIO2->fetchAll();





echo '</table>';
echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - MARCIO FERREIRA</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_MARCIO2) ) {
    $i=0;
    foreach($result_MARCIO2 as $row) {

        extract($row);

        $verfic = true;
        echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
        echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
        echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
        foreach ($result_MARCIO as $row2){
            If($row[0] == $row2[0]){
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                $verfic = false;

                //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
            }

        }

        If($verfic == true){
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

            //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
        }
        echo "</tr>";


        $i++;

    }
} else {
    echo "Nennhum resultado retornado.";
    echo $id;

}

echo '</table>';

$consulta_MARCUS = $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton, c.nome FROM $mes a, $meta b, supervisor c
 where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.Rca = c.RCA group by a.id)SUB where nome = 'Marcus' GROUP BY VENDEDOR");
$consulta_MARCUS->execute();
$result_MARCUS = $consulta_MARCUS->fetchAll();




$consulta_MARCUS2 = $conn->prepare(" select vendedor, meta_baton, rca from $meta where rca in(select rca from supervisor where nome = 'Marcus') order by vendedor");
$consulta_MARCUS2->execute(array('id' => $id));
$result_MARCUS2 = $consulta_MARCUS2->fetchAll();





echo '</table>';
echo '</br>';
echo '     
      
<table id="tabela" align="center" cellpadding="5">
<tr style = "height:40px">
        <td colspan="4" style="background: #820505; border-color: #84071d !important; color: aliceblue; border: solid; font-size:20px; text-align: center;">EQUIPE - MARCUS</td>
</tr>
<tr style="font-size: 16px;background: #cf7571;color: aliceblue; font-size:20px;"> 
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Vendedores</td>
<td style="width: 200px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Meta Positivação</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;border-right-color: aliceblue;">Realizado</td>
<td style="width: 150px; text-align: center; border: solid; border-color: #84071D;">A Realizar</td>




</tr>



';



if (count($result_MARCUS2) ) {
    $i=0;
    foreach($result_MARCUS2 as $row) {

        extract($row);

        $verfic = true;
        echo '<tr class="success" style="background: #C59C9C; font-size:20px;">';
        echo'<td class="link" style="width: 150px; text-align: center; border: solid; border-color: #245269;"><a id href="bat.php?mes='.$meta.'&vd='.$row[2].'">'.$row[0].'</a></td>';
        echo '<td  id="meta'.$i.'" style="width: 200px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';
        foreach ($result_MARCUS as $row2){
            If($row[0] == $row2[0]){
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[2].'</td>';
                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row2[3].'</td>';
                $verfic = false;

                //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
            }

        }

        If($verfic == true){
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[1].'</td>';

            //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
        }
        echo "</tr>";


        $i++;

    }
} else {
    echo "Nennhum resultado retornado.";
    echo $id;

}

echo '</table>';




echo '

</br>

</div>
<div class="col-md-2"></div> 
<div class="col-md-2"></div> 
</div>

';

echo '<script>
 
 calc_metatri(); 
 
  function getUrlVars() {
             var vars = {};
             var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                 vars[key] = value;
             });
             return vars;
         }
 
 
           teste = getUrlVars()["regiao"];
           
           if(teste == "Sul"){
                     document.getElementById("sul").selected = "true";
                      
                 }
                 if(teste == "Norte"){
                     document.getElementById("norte").selected = "true";
                     
                 }
             if(teste == "Todos"){
                 document.getElementById("todos").selected = "true";}
            
           


</script>';
       
       
       ?>
        
        
        
    </body>
</html>
