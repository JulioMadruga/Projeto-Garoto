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



If (isset($_GET['regiao'])) {

    $regiao = $_GET['regiao'];


    $consulta_sup = $conn->prepare("SELECT DISTINCT a.nome FROM supervisor a, usuarios b WHERE a.rca = b.rca and  b.regiao = '$regiao' ORDER by nome");

    $consulta_sup->execute();
    $result_sup = $consulta_sup->fetchAll();

//var_dump($result_sup);


    $i = 0;

    foreach ($result_sup as $row) {


        $consulta_vendas[$i] = $conn->prepare("SELECT b.VENDEDOR, sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) 
                                          as Total, b.Vendedor, b.kg, b.valor FROM $mes a, $meta b, usuarios c where a.VENDEDOR = b.rca and a.vendedor = c.rca and c.regiao = '$regiao' and c.super = '$row[0]' group by c.nome");
        //var_dump($consulta_vendas[$i]);
        $consulta_vendas[$i]->execute();
        $result_vendas[$i] = $consulta_vendas[$i]->fetchAll();

        // var_dump($result_vendas[$i]);


        $consulta_meta[$i] = $conn->prepare("select a.vendedor, a.kg, a.valor, b.Rca from $meta a, usuarios b where a.Vendedor=b.nome and b.regiao = '$regiao' and b.super = '$row[0]' order by a.vendedor");
        //var_dump($consulta_meta[$i]);
        $consulta_meta[$i]->execute();
        $result_meta[$i] = $consulta_meta[$i]->fetchAll();

        $consulta_dev[$i] = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 and b.regiao = '$regiao' and b.super = '$row[0]' GROUP by b.nome");
        //var_dump($consulta_dev[$i]);
        $consulta_dev[$i]->execute();
        $result_dev[$i] = $consulta_dev[$i]->fetchAll();

        //var_dump($result_meta[$i]);

        $consulta_real_super[$i] = $conn->prepare("SELECT sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes a, usuarios b where a.vendedor = b.rca and b.regiao ='$regiao' and b.super = '$row[0]'");
        // var_dump($consulta_real_super);
        $consulta_real_super[$i]->execute();
        $result_real_super[$i] = $consulta_real_super[$i]->fetchAll();

        $consulta_meta_super[$i] = $conn->prepare("SELECT ROUND(SUM(a.kg), 2) as peso, ROUND(SUM(a.valor), 2) as Total FROM $meta a, usuarios b WHERE a.rca = b.rca and b.regiao = '$regiao' and b.super = '$row[0]'  ");
        $consulta_meta_super[$i]->execute();
        $result_meta_super[$i] = $consulta_meta_super[$i]->fetchAll();

        $consulta_dev_super[$i] = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 and b.regiao = '$regiao' and b.super = '$row[0]'");
        //var_dump($consulta_dev[$i]);
        $consulta_dev_super[$i]->execute();
        $result_dev_super[$i] = $consulta_dev_super[$i]->fetchAll();



        $consulta_totalreal = $conn->prepare("SELECT sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes a, usuarios b where a.vendedor = b.rca and b.regiao = '$regiao' ");
        $consulta_totalreal->execute();
        $result_totalreal = $consulta_totalreal->fetchAll();

        $consulta_totalmeta = $conn->prepare("SELECT ROUND(SUM(a.kg), 2) as peso, ROUND(SUM(a.valor), 2) as Total FROM $meta a, usuarios b where a.rca = b.rca and b.regiao = '$regiao'");
        $consulta_totalmeta->execute();
        $result_totalmeta = $consulta_totalmeta->fetchAll();

        $consulta_totalDev = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 and b.regiao = '$regiao' ");
        $consulta_totalDev->execute();
        $result_totalDev = $consulta_totalDev->fetchAll();

        $i++;


    }

    
	
	
	
}


if(!isset($_GET['regiao'] )|| $regiao == 'Todos'){


$consulta_sup = $conn->prepare("SELECT DISTINCT nome FROM supervisor ORDER by nome");

$consulta_sup->execute();
$result_sup = $consulta_sup->fetchAll();

//var_dump($result_sup);


$i = 0;

foreach ($result_sup as $row) {


    $consulta_vendas[$i] = $conn->prepare("SELECT b.VENDEDOR, sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) 
                                          as Total, b.Vendedor, b.kg, b.valor FROM $mes a, $meta b, usuarios c where a.VENDEDOR = b.rca and a.vendedor = c.rca  and c.super = '$row[0]' group by c.nome");
    //var_dump($consulta_vendas[$i]);
    $consulta_vendas[$i]->execute();
    $result_vendas[$i] = $consulta_vendas[$i]->fetchAll();

    // var_dump($result_vendas[$i]);


    $consulta_meta[$i] = $conn->prepare("select a.vendedor, a.kg, a.valor, b.Rca from $meta a, usuarios b where a.Vendedor=b.nome and b.super = '$row[0]' order by a.vendedor");
    //var_dump($consulta_meta[$i]);
    $consulta_meta[$i]->execute();
    $result_meta[$i] = $consulta_meta[$i]->fetchAll();

    //var_dump($result_meta[$i]);


    $consulta_dev[$i] = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 and b.super = '$row[0]' GROUP by b.nome");
    //var_dump($consulta_dev[$i]);
    $consulta_dev[$i]->execute();
    $result_dev[$i] = $consulta_dev[$i]->fetchAll();

    //var_dump($result_dev[$i]);



    $consulta_real_super[$i] = $conn->prepare("SELECT sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes a, usuarios b where a.vendedor = b.rca and b.super = '$row[0]'");
    // var_dump($consulta_real_super);
    $consulta_real_super[$i]->execute();
    $result_real_super[$i] = $consulta_real_super[$i]->fetchAll();

    $consulta_meta_super[$i] = $conn->prepare("SELECT ROUND(SUM(a.kg), 2) as peso, ROUND(SUM(a.valor), 2) as Total FROM $meta a, usuarios b WHERE a.rca = b.rca and b.super = '$row[0]'  ");
    $consulta_meta_super[$i]->execute();
    $result_meta_super[$i] = $consulta_meta_super[$i]->fetchAll();


    $consulta_dev_super[$i] = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 and b.super = '$row[0]'");
    //var_dump($consulta_dev[$i]);
    $consulta_dev_super[$i]->execute();
    $result_dev_super[$i] = $consulta_dev_super[$i]->fetchAll();



    $consulta_totalreal = $conn->prepare("SELECT sum(cast(replace(replace(Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes");
    $consulta_totalreal->execute();
    $result_totalreal = $consulta_totalreal->fetchAll();

    $consulta_totalmeta = $conn->prepare("SELECT ROUND(SUM(kg), 2) as peso, ROUND(SUM(valor), 2) as Total FROM $meta");
    $consulta_totalmeta->execute();
    $result_totalmeta = $consulta_totalmeta->fetchAll();

    $consulta_totalDev = $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total from $mes a, usuarios b where a.VENDEDOR = b.Rca and a.Valor_total <0 ");
    $consulta_totalDev->execute();
    $result_totalDev = $consulta_totalDev->fetchAll();


    $i++;


}



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
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
        <link rel="stylesheet" href="../css/bootstrap-theme.css">
       <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
    <link rel="stylesheet" href="../css/menu.css">
        <link rel="stylesheet" href="../css/graf_percentual.css">
           <link rel="stylesheet" href="../css/tableexport.min.css">
     <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/npm.js"></script>
        <script src="../js/Chart.js"></script>
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


         $(function(){
             var $ppc = $('.progress-pie-chart'),
                 percent = parseInt($ppc.data('percent')),
                 deg = 360*percent/100;
             if (percent > 100){
                 deg = 360;
             }
             if (percent > 50) {
                 $ppc.addClass('gt-50');
             }
             $('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
             $('.ppc-percents span').html(percent+'%');
         });

         $(function(){
             var $ppc2 = $('.progress2-pie-chart'),
                 percent2 = parseInt($ppc2.data('percent2')),
                 deg2 = 360*percent2/100;

             if (percent2 > 100){
                 deg2 = 360;
             }
             if (percent2 > 50) {
                 $ppc2.addClass('gt2-50');
             }

             $('.ppc-progress2-fill').css('transform','rotate('+ deg2 +'deg)');
             $('.ppc-percents2 span').html(percent2+'%');
         });




$(document).ready( function(){
$("#painel").hide();
$("#painel").slideDown(1500);

//$("tr:odd").css("background","#CED4D6");
//$("tr:last").css("background","#074456");


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
           <li role="presentation" ><a href="index.php">Parcial</a></li>
           <li role="presentation"  id="active"><a href="#">Resumo de vendas</a></li>
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
                   if($usuario->getNome()=="Julio" || $usuario->getNome()=="Ewweton"){

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

        <div class="col-md-1"></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div>
        <div class="col-md-6" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div>
        <div class="col-md-1"></div>

       </div>



         <div class="row" style="background: #737373;">
         <div class="col-md-1"></div>
         <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px; padding-top: 5px;"></div>

        <div class="col-md-6" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 32px;">

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

<?php

echo '         

      </select>


</div>
       
       <div class="col-md-2" style="margin: auto; background-color:#074456;font-family:Oswald; color:#E4F3F7;height: 32px;"> 

</div>
       
        <div class="col-md-1"></div> 
       
    </div>    
    
<div id="painel" class="row" style="background: #737373;">
<div class="col-md-1"></div> 

<div class="col-md-10" style="text-align:center; padding-top: 20px; background-color:#CED4D6; font-family:Oswald; color:#074456;">
<div class="col-md-9">       
<div class="table-responsive">
<table id="resultados" align="center" cellpadding="5">


';



if (count($result_meta) ) {

    $z =0;

    foreach ($result_sup as $row){



        echo '<tr class="success" style="height: 15px;">';
        echo '<td colspan="5"></td>';
        echo '</tr>';

        $color = array (
            0 => "#c5edf7",
            1 => "#55b2ca",
            2 => "#c5edf7",
            3 => "#55b2ca",
            4 => "#c5edf7",
            5 => "#55b2ca",
            6 => "#c5edf7",
            7 => "#55b2ca",
            8 => "#c5edf7",
            9 => "#55b2ca",
            10 => "#c5edf7",
            11 => "#55b2ca"



        );

        echo '<tr class="success" style="background: #226a80; font-size:16px;color: aliceblue;height: 30px; border: solid; border-color: #226a80;">';
        echo '<td colspan="6">'.$row[0].'</td>';
        echo '</tr>';

        echo '<tr style="font-size: 16px;background: #074456;color: aliceblue;">';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Vendedores</td>';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Meta em Kg</td>';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Realizado Kg</td>';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Meta em Valor</td>';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Realizado</td>';
        echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">Devoluções</td>';



echo '</tr>';





        foreach($result_meta[$z] as $row) {

            //var_dump($row);
            $verfic = true;

            echo '<tr class="success" style="background-color: '.$color[$z]. '!important;">';
            echo '<td class="link" style="width: 150px; text-align: left; border: solid; border-color: #245269; padding-left: 10px;"><a id href="vendas.php?mes=' . $meta . '&vd=' . $row[3] . '">' . $row[0] . '</a></td>';
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">' . number_format($row[1], 2, ',', '.') . '</td>';
           //var_dump($result_vendas);

            foreach ($result_vendas[$z] as $row2) {


                If ($row[0] == $row2[0]) {
                    echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">' . number_format($row2[1], 2, ',', '.') . '</td>';
                    $verfic = false;


                }

            }

            If ($verfic == true) {

                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
                //echo  '<script> alert("'.$row[0].'");</script>';
                // echo  '<script> alert("'.$row2[0].'");</script>';

            }

            //
            echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">R$  ' . number_format($row[2], 2, ',', '.') . '</td>';

            foreach ($result_vendas[$z] as $row2) {
                If ($row[0] == $row2[0]) {
                    echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">R$  ' . number_format($row2[2], 2, ',', '.') . '</td>';
                    $verfic = false;

                    //echo  '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                }

            }

            If ($verfic == true) {

                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';

            }

            foreach ($result_dev[$z] as $row2) {

               // echo $row[3]; echo '-'; echo $row2[1]; echo '<br>';

                If ($row[3] == $row2[0]) {
                    echo '<td style="width: 150px; text-align: center; border: solid; border-color: #245269;">' . number_format($row2[1], 2, ',', '.') . '</td>';

                  $verfic = false;

                  break;

                }else {

                    $verfic = true;

                }



            }


            If (empty($result_dev[$z])) {

                echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
                //echo  '<script> alert("'.$row[0].'");</script>';
                // echo  '<script> alert("'.$row2[0].'");</script>';

            }else{

                If ($verfic == true) {

                    echo '<td style="width: 150px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';
                    //echo  '<script> alert("'.$row[0].'");</script>';
                    // echo  '<script> alert("'.$row2[0].'");</script>';

                }


            }





            //


            echo "</tr>";




        }




        echo '<tr class="success" style="background: #074456; font-size:16px;color: aliceblue;height: 30px;">';
        echo'<td style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">Total</td>';
        echo '<td id="kgmeta" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">'. number_format($result_meta_super[$z][0][0], 2, ',', '.').' Kg</td>';
        echo '<td id="Rkg" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">'. number_format($result_real_super[$z][0][0], 2, ',', '.').' Kg</td>';
        echo '<td id="metav" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">R$ ' . number_format($result_meta_super[$z][0][1], 2, ',', '.').'</td>';
        echo '<td id="metar" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;"> R$ ' . number_format($result_real_super[$z] [0][1], 2, ',', '.').'</td>';
        echo '<td id="metar" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-left-color: #CED4D6;"> R$ ' . number_format($result_dev_super[$z] [0][1], 2, ',', '.').'</td>';

        echo "</tr>";


        $z++;

    }

  } else {
    echo "Nennhum resultado retornado.";
    echo $id;

  }

    echo '</table>';
      echo '</br>';
      echo '<table align="center" cellpadding="5">';




                           echo '<tr class="success" style="background: #074456; font-size:16px;color: aliceblue;height: 40px;">';
                           echo'<td style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">Total</td>';
                           echo '<td id="kgmeta" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">'. number_format($result_totalmeta[0][0], 2, ',', '.').' Kg</td>';
                           echo '<td id="Rkg" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">'. number_format($result_totalreal[0][0], 2, ',', '.').' Kg</td>';
                           echo '<td id="metav" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">R$ ' . number_format($result_totalmeta[0][1], 2, ',', '.').'</td>';
                           echo '<td id="metar" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;"> R$ ' . number_format($result_totalreal[0][1], 2, ',', '.').'</td>';
                           echo '<td id="metar" style="width: 150px; text-align: center; border: solid; border-color: #074456;border-left-color: #CED4D6;"> R$ ' . number_format($result_totalDev[0][1], 2, ',', '.').'</td>';



      if($result_totalmeta[0][0] !== null){

          $percent_kg = (number_format($result_totalreal[0][0], 2, ',', '.')/number_format($result_totalmeta[0][0], 2, ',', '.'))*100;
          $percent_valor = ($result_totalreal[0][1]/$result_totalmeta[0][1])*100;

      }




  echo '
</table>
</div>
</br>
</div>
<div class="col-md-3">

<select id="regiao"  name="regiao " style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; font-size: 18px;text-align: center; font-weight: bold;">

<option value="#">Selecionar Regiao</option>


<option>Norte</option>
<option>Sul</option>
<option>Todos</option>

</select> 

<h2>GRÁFICO KG</h2>
<canvas id="myChart" ></canvas>
';
if($result_totalmeta[0][0] !== null){
echo'<div class="progress-pie-chart" data-percent="'.round($percent_kg).'">';
}else{echo'<div class="progress-pie-chart" data-percent="0">'; };
  echo '<div class="ppc-progress">
    <div class="ppc-progress-fill"></div>
  </div>
  <div class="ppc-percents">
    <div class="pcc-percents-wrapper">
      <span>%</span>
    </div>
  </div>
</div>



<br> <br><br>
<h2>GRÁFICO VALOR</h2>
<canvas id="myChart2" ></canvas>
';
if($result_totalmeta[0][0] !== null){

echo '<div class="progress2-pie-chart" data-percent2="'.round($percent_valor).'">';
} else{echo '<div class="progress2-pie-chart" data-percent2="0">'; };
  echo '<div class="ppc-progress2">
    <div class="ppc-progress2-fill"></div>
  </div>
  <div class="ppc-percents2">
    <div class="pcc-percents2-wrapper">
      <span>%</span>
    </div>
  </div>
</div>
</div>

<script>
var ctx = document.getElementById("myChart");

var kgmeta = document.getElementById("kgmeta").innerText;
var kgM = parseFloat(kgmeta.replace("Kg","")).toFixed(3);

var Rkg = document.getElementById("Rkg").innerText;
var Rkg2 = parseFloat(Rkg.replace("Kg","")).toFixed(3);



var myChart = new Chart(ctx, {
    type: \'bar\',
    data: {
        labels: ["Kg"],
              datasets: [{
            label: \'Meta\',
              backgroundColor: "rgba(155, 199, 210,.8)",
            data: [kgM]
        },
        {
            label: \'Realizado\',
            backgroundColor: "rgba(55, 143, 165,1)",
            data: [Rkg2 ]
        }
        
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("myChart2");

var metavalor = document.getElementById("metav").innerText;
var metavalor2 = metavalor.replace("R$","").replace(".","").replace(".","").replace(",","");
var metarealizado = document.getElementById("metar").innerText;
var metar = metarealizado.replace("R$","").replace(".","").replace(".","").replace(",","");



var myChart = new Chart(ctx, {
    type: \'bar\',
    data: {
        labels: ["R$"],
              datasets: [{
            label: \'Meta\',
              backgroundColor: "rgba(95, 171, 95,.8)",
            data: [metavalor2]
        },
        {
            label: \'Realizado\',
            backgroundColor: "rgba(41, 142, 41,1)",
            data: [metar]
        }
        
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>






</div>
<div class="col-md-1"></div> 
<div class="col-md-1"></div> 
</div>

';
               

       
       
       ?>
            <script src="../js/bootstrap.min_1.js" type="text/javascript"></script>
            <script src="../js/FileSaver.min.js" type="text/javascript"></script>
            <script src="../js/tableexport.min.js" type="text/javascript"></script>
            <script> $('#resultados').tableExport(); </script>


    </body>
</html>
