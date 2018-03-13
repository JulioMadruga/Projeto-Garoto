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
 
$id = $usuario->getRca();
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

$bat = $result_cont[0][0];
$tal = $result_cont[0][1];
$ser = $result_cont[0][2];
$jum = $result_cont[0][4];





If (isset($_GET['regiao'])) {

    $regiao = $_GET['regiao'];



	
	$consulta_totalreal= $conn->prepare("SELECT sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes a, usuarios b where a.vendedor = b.rca and b.regiao = '$regiao' ");
    $consulta_totalreal->execute(array('id' => $id));
    $result_totalreal= $consulta_totalreal->fetchAll();


    $consulta_totalmeta= $conn->prepare("SELECT ROUND(SUM(a.kg), 2) as peso, ROUND(SUM(a.valor), 2) as Total FROM $meta a, usuarios b where a.vendedor = b.nome and b.regiao = '$regiao'");
    $consulta_totalmeta->execute(array('id' => $id));
    $result_totalmeta= $consulta_totalmeta->fetchAll();

    $kg0 = ($result_totalreal[0][0] / $result_totalmeta[0][0])*100;

    $kg = 5 * round($kg0 / 5);


    $consulta_TOTAL = $conn->prepare("Select sum(meta_baton), sum(realizado), IF(sum(meta_baton) - sum(realizado)<0,0,sum(meta_baton) - sum(realizado)) AS DIF from ( SELECT VENDEDOR, meta_baton, 
    COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif 
    FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton FROM $mes a, $meta b, usuarios c 
    where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca and b.rca = c.rca and c.regiao = '$regiao' group by a.id)SUB GROUP BY VENDEDOR)sub");
    $consulta_TOTAL->execute(array('id' => $id));
    $result_BatonTOTAL = $consulta_TOTAL->fetchAll();

    $baton0 = ($result_BatonTOTAL[0][1] / $result_BatonTOTAL[0][0])*100;

    $baton = 5 * round($baton0 / 5);


    $consulta_bi = $conn->prepare("select sum(reali) as reali from(select vendedor,trimarca, Count(nome_parceiro)as reali, if(trimarca -Count(nome_parceiro)<0,0,trimarca -Count(nome_parceiro)) as dif from(Select vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca from (SELECT b.vendedor,a.nome_parceiro, a.quantidade, a.material in($bat) as Baton, a.material in($tal) as Talento, b.vendedor as vend, b.trimarca FROM $mes a, $meta b, usuarios c where a.material in ($bat,$tal) and a.quantidade>0 and a.vendedor= b.rca and b.rca = c.rca and c.regiao = '$regiao') sub group by nome_parceiro)sub where baton>0 and talento>0 group by vendedor)sub");
    $consulta_bi->execute();
    $result_biTOTAL = $consulta_bi->fetchAll();

    $consulta_tri = $conn->prepare(" select sum(trimarca) as tri from $meta order by vendedor");
    $consulta_tri->execute();
    $result_tri = $consulta_tri->fetchAll();

   // var_dump($result_biTOTAL);
   // var_dump($result_tri);

    $bi = ($result_biTOTAL[0][0] / $result_tri[0][0])*100;

    $bi = 5 * round($baton0 / 5);




}


if(!isset($_GET['regiao'] )|| $regiao == 'Todos'){


		
		$consulta_totalreal= $conn->prepare("SELECT sum(cast(replace(replace(Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes");
        $consulta_totalreal->execute(array('id' => $id));
        $result_totalreal= $consulta_totalreal->fetchAll();

        // var_dump($result_totalreal);


        $consulta_totalmeta= $conn->prepare("SELECT ROUND(SUM(kg), 2) as peso, ROUND(SUM(valor), 2) as Total FROM $meta");
        $consulta_totalmeta->execute(array('id' => $id));
        $result_totalmeta= $consulta_totalmeta->fetchAll();

         //var_dump($result_totalmeta);


        if( $result_totalmeta[0][0] != null ){

            $kg0 = ($result_totalreal[0][0] / $result_totalmeta[0][0])*100;

            $kg = 5 * round($kg0 / 5);

        }else{

            $kg=0;
    }


        $consulta_TOTAL = $conn->prepare("Select sum(meta_baton), sum(realizado), IF(sum(meta_baton) - sum(realizado)<0,0,sum(meta_baton) - sum(realizado)) AS DIF from ( SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, b.vendedor as vend, b.meta_baton FROM $mes a, $meta b where a.MATERIAL IN ($bat) AND a.QUANTIDADE>0 and a.vendedor = b.rca group by a.id)SUB GROUP BY VENDEDOR)sub");
        $consulta_TOTAL->execute();
        $result_BatonTOTAL = $consulta_TOTAL->fetchAll();

        //var_dump($result_BatonTOTAL);
        if($result_BatonTOTAL[0][1] == null){

            $baton = 0;

        }else{
            $baton0 = ($result_BatonTOTAL[0][1] / $result_BatonTOTAL[0][0])*100;
            $baton = 5 * round($baton0 / 5);
        }




        $consulta_bi = $conn->prepare("select  sum(reali) as reali from(select vendedor,trimarca, Count(nome_parceiro)as reali, if(trimarca -Count(nome_parceiro)<0,0,trimarca -Count(nome_parceiro)) as dif from(Select vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca from (SELECT b.vendedor,a.nome_parceiro, a.quantidade, a.material in($bat) as Baton, a.material in($tal) as Talento, b.vendedor as vend, b.trimarca FROM $mes a, $meta b where a.material in ($bat,$tal) and a.quantidade>0 and a.vendedor= b.rca) sub group by nome_parceiro)sub where baton>0 and talento>0 group by vendedor)sub");
        $consulta_bi->execute();
        $result_biTOTAL = $consulta_bi->fetchAll();

        $consulta_tri = $conn->prepare(" select sum(trimarca) as tri from $meta order by vendedor");
        $consulta_tri->execute();
        $result_tri = $consulta_tri->fetchAll();

       // var_dump($result_biTOTAL);
        //var_dump($result_tri);

        if( $result_totalmeta[0][0] != null ) {
            $bi0 = ($result_biTOTAL[0][0] / $result_tri[0][0]) * 100;

            $bi = 5 * round($bi0 / 5);
        }else{

            $bi=0;
        }
       $consulta_jum = $conn->prepare(" select sum(tab) as tab from $meta order by vendedor");
       $consulta_jum->execute();
       $result_jum = $consulta_jum->fetchAll();


       $consulta_jumTOTAL = $conn->prepare("Select sum(realizado) from (SELECT VENDEDOR, tab, COUNT(id) as realizado, 
       if(tab - COUNT(id)<0,0,tab - COUNT(id)) as dif  FROM (SELECT b.VENDEDOR, a.NOME_PARCEIRO, a.id, b.vendedor as vend, 
       b.tab FROM $mes a, $meta b where a.MATERIAL IN ($jum) AND a.QUANTIDADE>0 and a.vendedor = b.rca group by a.id)SUB GROUP BY VENDEDOR)sub");
        //print_r($consulta_TOTAL);
       $consulta_jumTOTAL->execute();
       $result_jumTOTAL = $consulta_jumTOTAL->fetchAll();

        if( $result_totalmeta[0][0] != null ) {
            $jum0 = ($result_jumTOTAL[0][0] / $result_jum[0][0]) * 100;

            $jum = 5 * round($jum0 / 5);

        }else{

            $jum=0;
        }

       $consulta_equipem = $conn->prepare("SELECT b.nome, ROUND(SUM(a.kg), 2) as kg FROM $meta a, supervisor b where a.Rca = b.RCA GROUP by b.nome");
       $consulta_equipem->execute();
       $result_equipeTOTALm = $consulta_equipem->fetchAll();

   // var_dump($result_equipeTOTALm);

       $consulta_equiper = $conn->prepare("SELECT b.nome, sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso FROM $mes a, supervisor b where a.VENDEDOR = b.RCA GROUP by b.Nome");
       $consulta_equiper->execute();
       $result_equipeTOTALr = $consulta_equiper->fetchAll();

      // var_dump($result_equipeTOTALr);


}



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


<html style="background: #737373;">
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
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100i,300i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
        <link rel="stylesheet" href="../css/bootstrap-theme.css">
       <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
    <link rel="stylesheet" href="../css/menu.css">
        <link rel="stylesheet" href="../css/graficos.css">
        <link rel="stylesheet" href="../css/grafico_principal.css?version=12">
        <link rel="stylesheet" href="../css/graf_percentual.css">
           <link rel="stylesheet" href="../css/tableexport.min.css">
     <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/npm.js"></script>
        <script src="../js/Chart.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

     <script>   // aqui eh a base da pagina

         window.onload = function(){

             document.getElementById('mes').onchange = function(){
                 window.location = '?mes=' + this.value;


             }

         }




$(document).ready( function(){
$("#painel").hide();
$("#painel").slideDown(700);

$("tr:odd").css("background","#CED4D6");
$("tr:last").css("background","#074456");


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

           <li role="presentation"  id="active"><a href="#">Parcial</a></li>
           <li role="presentation"><a href="resumo.php">Resumo de Vendas</a></li>
           <li role="presentation"><a href="vendasflex.php">Venda Transmitida</a></li>
          <li role="presentation"><a href="metas.php">Metas</a></li>
          
          <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">  Positivações  <span>▼</span>  </a>
              <ul class="dropdown-menu">
                  <li><a href="trimarca.php">Bi-Marca</a></li>
                  <li><a href="baton.php">Baton</a></li>
                  <li><a href="jumbos.php">Jumbos</a></li>
                  <li><a href="ativoxpositivado.php">Cliente Ativos X Positivados</a></li>

              </ul>

          </li>

           <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle"> Relatórios <span>▼</span>  </a>
               <ul class="dropdown-menu">
                   <li role="presentation"><a href="acessos.php">Relat. de Acessos</a></li>
                   <li role="presentation"><a href="inadimplencia.php">Financeiro</a></li>

               </ul>

           </li>





           <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle"> Cadastros <span>▼</span>  </a>
               <ul class="dropdown-menu">
                   <li role="presentation" ><a href="cadastrar.php">Cadastrar Metas</a></li>
                   <li role="presentation" ><a href="campanha.php">Cad. Campanhas</a></li>
                   <li role="presentation" ><a href="cadvend.php">Cad. Vendedores</a></li>
                   <?php
                   if($usuario->getNome()=="Julio" || $usuario->getNome()=="Eweton"){

                       echo '<li role="presentation" ><a href="solicitacao.php">Solic. Cadastros</a></li>';
}

                        ?>
               </ul>

           </li>
           <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">Importacao<span>▼</span>  </a>

               <ul class="dropdown-menu">
                   <li><a href="Importacao.php">Resultados</a></li>
                   <li><a href="clientes.php">Clientes</a></li>
                   <li role="presentation" ><a href="financeiro.php">Financeiro</a></li>
                   <li role="presentation" ><a href="produtos.php">Produtos</a></li>
                   <li role="presentation" ><a href="email/index.php">Venda Diaria</a></li>

               </ul>

           </li>
  <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;"><input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.  href='../controle.php?tipo=sair'"></li>
  <li role="presentation" style="float: right;"><h5 style="color: #A6CFF3; font-family: sans-serif;padding-top: 4px;">Usuário: <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>

       </ul>
        </div>
     <div class="row" style="padding-top: 50px;background: #737373;">

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
            <?php echo' <select id="mes" name="mes"style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif;  font-size: 18px;text-align: center; font-weight: bold;" > 
      
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





      </select>


</div>
       
       <div class="col-md-2" style="margin: auto; background-color:#074456;font-family: 'Source Sans Pro', sans-serif;; color:#E4F3F7;height: 32px;">

</div>
       
        <div class="col-md-2"></div> 
       
    </div>    
    
<div  class="row" style="background: #737373;">

<div class="col-sm-2"></div> 

<div class="col-sm-2" style="height: 210px; background-color: #0e3946; ">
<div id="titulo" style="color: red;">
 Positivação Baton</div>
 
 <div class="chart" style="color: #e40808; margin-top: 80px;" data-percentage="<?php echo $baton; ?>">
  <div class="percentage"></div>
  <div class="completed active"></div>
</div>

</div>

<div class="col-sm-2" style="height: 210px; background-color: #0e3946; ">
<div id="titulo" style="color: #96d64d;">
 Positivação Bi-Marca</div>
 
 <div class="chart" style="color: #96d64d; margin-top: 80px;" data-percentage="<?php echo $bi; ?>">
  <div class="percentage"></div>
  <div class="completed2 active"></div>
</div>

</div>

<div class="col-sm-2" style="height: 210px; background-color: #0e3946;">
<div id="titulo" style="color: #f7de00;">
 Positivação Jumbos </div>
 
 <div class="chart" style="color: #f7de00; margin-top: 80px;" data-percentage="<?php echo $jum; ?>">
  <div class="percentage"></div>
  <div class="completed3 active"></div>
</div>

</div>

<div class="col-sm-2" style="height: 210px; background-color: #0e3946;">
<div id="titulo" style="color: #05cae0;">
Meta Kg </div>

 <div class="chart" style="color: #05cae0; margin-top: 80px;" data-percentage="<?php echo $kg; ?>">
  <div class="percentage"></div>
  <div class="completed4 active"></div>
</div>

</div>





<div class="col-sm-2"></div> 
</div>

<div class="row" style="background: #737373;">

 <div class="col-md-2"></div> 
 
 <div class="col-md-8" style="background-color: #0e3946; height: 600px ">

     <div id="bar-chart">
         <h2 STYLE="font-family: 'Roboto', sans-serif; font-weight: 100; text-align: center; padding-bottom: 15px">DESEMPENHO DE TONELADA POR EQUIPE</h2>
         <div class="graph">

             <ul class="x-axis">
                 <li><span>Disnorte</span></li>
                 <li><span>Adailton</span></li>
                 <li><span>Adilson</span></li>
                 <li><span>Aldenor</span></li>
                 <li><span>Anderson</span></li>
                 <li><span>Antônio</span></li>
                 <li><span>Fabricio</span></li>
                 <li><span>Fernando</span></li>
                 <li><span>Marcio</span></li>
                 <li><span>Paride</span></li>
             </ul>

             <?php

             $escala = array(0,2.5,5,7.5,10);
             $escala2 = array(0,5,10,15,20);

             if($result_equipeTOTALr == empty(true)){

                 $v_realizado =0;

             }else{
                 foreach ($result_equipeTOTALr as $row ){

                     $verfica_Metar[] = $row[1];

                 }

                 $v_realizado =round(max($verfica_Metar)/1000);


             }



             foreach ($result_equipeTOTALm as $row ){

                 $verfica_Metam[] = $row[1];

             }


             if( $result_totalmeta[0][0] != null ) {

                 $v_meta = round(max($verfica_Metam) / 1000);

             }else{

                 $v_meta=0;

             }

             if($v_meta>$v_realizado){

                 $vMax = $v_meta;

             }else{

                 $vMax = $v_realizado;
             }



             if($vMax<10){

                 $divisor = 10;

                echo'
                 <ul class="y-axis">
                 <li><span>10</span></li>
                 <li><span>7.5</span></li>
                 <li><span>5</span></li>
                 <li><span>2.5</span></li>
                 <li><span>0</span></li>
             </ul>
                 ';
             }else{

                 $divisor = 20;

                 echo'
                 <ul class="y-axis">
                 <li><span>20</span></li>
                 <li><span>15</span></li>
                 <li><span>10</span></li>
                 <li><span>5</span></li>
                 <li><span>0</span></li>
             </ul>
                 ';

             }




             ?>




             <div class="bars" >

             <?php


             foreach ( $result_equipeTOTALm as $row) {


                 $verfic = true;

                 echo '<div class="bar-group" >';

                   echo '<div class="bar bar-2 stat-2" style = "height:'.((round(($row[1]/1000))/$divisor)*100).'%;" >';
                   echo '<span>'.round(($row[1]/1000),1).'</span >';
                   echo ' </div >';

             foreach ($result_equipeTOTALr as $row2) {

                 If($row[0] == $row2[0]) {

                     echo ' <div class="bar bar-3 stat-3" style = "height: '.((round(($row2[1]/1000))/$divisor)*100).'%;" >';
                     echo '<span >'.round(($row2[1]/1000),1).'</span >';
                     echo '</div >';

                     $verfic = false;
                 }


             }

                 If($verfic == true){

                     echo ' <div class="bar bar-3 stat-3" style = "height: 0%;" >';
                     echo '<span >0</span >';
                     echo '</div >';


                 }

                 echo '</div >';








}

?>
             </div>

             <div class="col-md-4" style="position: absolute;top: -40px; right:10px; height: 28px;border: solid 1px; border-color: #4e5464">
                 <h5 style="position: absolute;top: -5px;">Legenda:</h5>
                 <label style="position: absolute; margin-left: 36%; top: 2px;">Meta</label>
                 <div class="bar bar-2 stat-2" style="position: absolute;width: 20px;height: 12px; bottom:9px; background-color: #2dff49;margin-left: 48%;"></div>
                 <label style="position: absolute;margin-left: 58%; top: 2px;">Realizado</label>
                 <div class="bar bar-3 stat-3" style="position: absolute;width: 20px;height: 12px; bottom:9px; background-color: #2dff49;margin-left: 82%;"></div>


             </div>




<div class="col-md-2"></div>

</div>




            <script src="../js/bootstrap.min_1.js" type="text/javascript"></script>
            <script src="../js/FileSaver.min.js" type="text/javascript"></script>




    </body>
</html>
