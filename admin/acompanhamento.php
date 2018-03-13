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




        $consulta_vendas = $conn->prepare("SELECT b.VENDEDOR, sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) 
                                          as Total, b.Vendedor, b.kg, b.valor FROM $mes a, $meta b, usuarios c where a.VENDEDOR = b.rca and a.vendedor = c.rca group by c.nome");
        $consulta_vendas->execute();
        $result_vendas = $consulta_vendas->fetchAll();
		
		//var_dump($result_vendas);
		
			

        $consulta_meta = $conn->prepare("select a.vendedor, a.kg, a.valor, b.Rca from $meta a, usuarios b where a.Vendedor=b.nome order by a.vendedor");
        $consulta_meta->execute(array('id' => $id));
        $result_meta = $consulta_meta->fetchAll();


        $consulta_diaria = $conn->prepare("select a.vendedor, b.Rca, sum(cast(replace(replace(c.valor, '.', ''), ',', '.') as decimal(10,2))) as total from $meta a, usuarios b, venda_diaria c where a.Vendedor=b.nome and b.rca = c.rca GROUP by rca order by a.vendedor");
        $consulta_diaria->execute(array('id' => $id));
        $result_diaria = $consulta_diaria->fetchAll();





        $consulta_totalreal= $conn->prepare("SELECT sum(cast(replace(replace(Liquido, '.', ''), ',', '.') as decimal(10,2))) as peso, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM $mes");
        $consulta_totalreal->execute(array('id' => $id));
        $result_totalreal= $consulta_totalreal->fetchAll();

        $consulta_totalmeta= $conn->prepare("SELECT ROUND(SUM(kg), 2) as peso, ROUND(SUM(valor), 2) as Total FROM $meta");
        $consulta_totalmeta->execute(array('id' => $id));
        $result_totalmeta= $consulta_totalmeta->fetchAll();

        $consulta_diariaTot = $conn->prepare("select  sum(cast(replace(replace(valor, '.', ''), ',', '.') as decimal(10,2))) as total from  venda_diaria");
        $consulta_diariaTot->execute(array('id' => $id));
        $result_diariaTot = $consulta_diariaTot->fetchAll();










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
     <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/npm.js"></script>
        <script src="../js/Chart.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

     <script>   // aqui eh a base da pagina




$(document).ready( function(){
$("#painel").hide();
$("#painel").slideDown(1300);

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

           <li role="presentation"  id="active"><a href="#">Resumo de vendas</a></li>
           <li role="presentation"><a href="vendasflex.php">Venda Transmitida</a></li>
          <li role="presentation"><a href="metas.php">Metas</a></li>
          
          <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">  Positivações  <span>▼</span>  </a>
              <ul class="dropdown-menu">
                  <li><a href="trimarca.php">Bi-Marca</a></li>
                  <li><a href="baton.php">Baton</a></li>
                  <li><a href="jumbos.php">Jumbos</a></li>

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
    
<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 20px; background-color:#CED4D6; font-family:Oswald; color:#074456;">
<div class="col-md-12">       
<div class="table-responsive">
<table align="center" cellpadding="5">

<tr style="font-size: 16px;background: #074456;color: aliceblue;">
<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">Vendedor</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">Meta em Valor</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">Faturado</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">A Faturar</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">Total</td>
<td style="width: 80px; text-align: center; border: solid; border-color: #245269;">Efetivo</td>



</tr>



';



if (count($result_meta) ) {

    foreach($result_meta as $row) {

        //var_dump($row);
        $verfic = true;
        $verfic2 = true;
        $verfic3= true;

                           echo '<tr class="success" style="background: #92B8C1">';
                           echo'<td class="link" style="width: 130px; text-align: left; padding-left: 8px; border: solid; border-color: #245269;"><a id href="vendas.php?mes='.$meta.'&vd='.$row[3].'">'.$row[0].'</a></td>';


                           //
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">R$ &nbsp&nbsp'.number_format($row[2], 2, ',', '.').'</td>';

                           foreach ($result_vendas as $row2){
                               If($row[0] == $row2[0]){
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">R$ &nbsp&nbsp'.number_format($row2[2], 2, ',', '.').'</td>';
                           $verfic = false;

                           //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }

                           }

                            If($verfic == true){

                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';

                               }

                            foreach ($result_diaria as $row2){
                              If($row[0] == $row2[0]){
                              echo '<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">R$ &nbsp&nbsp'.number_format($row2[2], 2, ',', '.').'</td>';
                             $verfic2 = false;

                                   //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                               }

                             }

                             If($verfic2 == true){

                               echo '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';

                              }


                           foreach ($result_diaria as $row2){
                           If($row[0] == $row2[0]){

                               foreach ($result_vendas as $row3) {

                                   If($row2[0] == $row3[0]) {


                                       echo '<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">R$ &nbsp&nbsp' . number_format(($row2[2] + $row3[2]), 2, ',', '.') . '</td>';


                                       $verfic3 = false;

                                       //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                                   }
                               } }

                            }

                         If($verfic3 == true){

                             foreach ($result_vendas as $row2){
                                 If($row[0] == $row2[0]){
                                     echo '<td style="width: 130px; text-align: center; border: solid; border-color: #245269;">R$ &nbsp&nbsp'.number_format($row2[2], 2, ',', '.').'</td>';
                                     $verfic = false;

                                     //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                                 }

                             }

                             If($verfic == true){

                                 echo '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';

                             }

                             }



                           foreach ($result_diaria as $row2){
                             If($row[0] == $row2[0]){

                                 foreach ($result_vendas as $row3) {

                                  If($row[0] == $row3[0]) {


                                    echo '<td style="width: 80px; text-align: center; border: solid; border-color: #245269;">' . number_format((($row2[2] + $row3[2]) / $row[2])*100, 2, ',', '.') . '&nbsp%</td>';
                                         $verfic3 = false;

                        //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                                     }
                                     } }

                                  }

                                 If($verfic3 == true){

                                     foreach ($result_vendas as $row2){
                                         If($row[0] == $row2[0]){
                                             echo '<td style="width: 80px; text-align: center; border: solid; border-color: #245269;">'.number_format((($row2[2])/$row[2])*100, 2, ',', '.').' %</td>';
                                             $verfic = false;

                                             //echo  '<td style="width: 130px; text-align: center; border: solid; border-color: #4B5F65;">'.$row[3].'</td>';
                                         }

                                     }

                                     If($verfic == true){

                                         echo '<td style="width: 80px; text-align: center; border: solid; border-color: #4B5F65;">0</td>';

                                     }

                                   }



                          //



       }
      echo "</tr>";





  } else {
    echo "Nennhum resultado retornado.";
    echo $id;

  }

    echo '</table>';
      echo '</br>';
      echo '<table align="center" cellpadding="5">';




                          echo '<tr class="success" style="background: #074456; font-size:16px;color: aliceblue;height: 40px;">';
                           echo'<td style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">Total</td>';
                           echo '<td id="metav" style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">R$ ' . number_format($result_totalmeta[0][1], 2, ',', '.').'</td>';
                           echo '<td id="metar" style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;"> R$ ' . number_format($result_totalreal[0][1], 2, ',', '.').'</td>';
                           echo '<td id="metad" style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;"> R$ ' . number_format($result_diariaTot[0][0], 2, ',', '.').'</td>';
                           echo '<td id="metartot" style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;"> R$ ' . number_format($result_diariaTot[0][0] + $result_totalreal[0][1] , 2, ',', '.').'</td>';
                           echo '<td id="metarper" style="width: 80px; text-align: center; border: solid; border-color: #074456;border-left-color: #CED4D6;">' . number_format((($result_diariaTot[0][0] + $result_totalreal[0][1])/$result_totalmeta[0][1])*100 , 2, ',', '.').' %</td>';





echo '
</table>
</div>
</br>
</div>

</div>

';
               

       
       ?>

        
        
    </body>
</html>
