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

$itens_pagina = 6;

if(isset($_GET['pagina'])){
    $pagina = intval($_GET['pagina']);
}else{

    $pagina =0;

}

$pag = $pagina * $itens_pagina;


if(isset($_GET['dataini'])){

   $data1 = str_replace("/","-",$_GET['dataini']);
   $data2 = str_replace("/","-",$_GET['datafim']);

   $dataini = $_GET['dataini'];
   $datafim = $_GET['datafim'];


    $dataini2 = str_replace("/","-",$_GET['dataini']);
    $dataini2 = substr($dataini2, -4, 4)."-".substr($dataini2, -7, 2)."-".substr($dataini2, -10, 2);


    $datafim2 = str_replace("/","-",$_GET['datafim']);
    $datafim2 = substr($datafim2, -4, 4)."-".substr($datafim2, -7, 2)."-".substr($datafim2, -10, 2);

}



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
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/graf_percentual.css">
    <link rel="stylesheet" href="../css/tableexport.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100" rel="stylesheet">


    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/npm.js"></script>
    <script src="../js/Chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/datepicker-pt-BR.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

    <script>   // aqui eh a base da pagina

        $(function() {
            $( "#datepicker" ).datepicker();
        });

        $(function() {
            $( "#datepicker2" ).datepicker();
        });

        $(function() {
            $( "#datepicker3" ).datepicker();
        });

        $(function() {
            $( "#datepicker4" ).datepicker();
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
    <body style="background-color: #737373">

      <?php

if (isset($_GET['dataini'])) {

      if(isset($_GET['rca']) && $_GET['rca'] !== "") {

          $rca = $_GET['rca'];

          $consulta_vend = $conn->prepare("SELECT DISTINCT b.Vendedor,b.rca FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and b.rca = $rca and data BETWEEN '$dataini2' and '$datafim2'");


          $consulta_vend->execute();
          $result_vend = $consulta_vend->fetchAll();
          //var_dump($result_vend);


      }else {


              $consulta_vend = $conn->prepare("SELECT DISTINCT b.Vendedor,b.rca FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and data BETWEEN '$dataini2' and '$datafim2'  ORDER by b.Vendedor LIMIT $pag, $itens_pagina");

              $consulta_vend->execute();
              $result_vend = $consulta_vend->fetchAll();
             // var_dump($result_vend);



          }

              $i = 0;

              foreach ($result_vend as $row) {


                  $consulta[$i] = $conn->prepare("SELECT b.rca, b.Vendedor, DATE_FORMAT(a.data, '%d/%m/%Y'), a.cod_ped, a.cod_cli, b.Nome, round(sum(a.valor),2) as total FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and b.Rca ='$row[1]' and data BETWEEN '$dataini2' and '$datafim2' GROUP by a.cod_ped ORDER BY `b`.`Vendedor`, a.cod_ped  ASC");
                  $consulta[$i]->execute();
                  $result[$i] = $consulta[$i]->fetchAll();
                  //  var_dump($result[$i]);

                  $consulta2[$i] = $conn->prepare("SELECT round(sum(a.valor),2) as total FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and b.Rca ='$row[1]' and data BETWEEN '$dataini2' and '$datafim2'");

                  $consulta2[$i]->execute();
                  $result2[$i] = $consulta2[$i]->fetchAll();

                  $i++;

              }

              $consultaPG = $conn->prepare("SELECT COUNT(vendedor) from (SELECT DISTINCT b.Vendedor FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and data BETWEEN '$dataini2' and '$datafim2' ORDER by b.Vendedor)sub");

              $consultaPG->execute();
              $resultPG = $consultaPG->fetchAll();

              $num_total = $resultPG[0][0];

              $num_paginas = ceil($num_total / $itens_pagina);


              $consulta3 = $conn->prepare("SELECT round(sum(a.valor),2) as total FROM ped_flexx a, clientes b, produtos c where a.cod_cli = b.Cod_Cliente and a.cod_prod = c.cod_prod and data BETWEEN '$dataini2' and '$datafim2'");

              $consulta3->execute();
              $result3 = $consulta3->fetchAll();

          }

   
  ?>

      <div id="nav" class="col-lg-12"  style="background: #121415;">
          <ul class="nav">
              <li role="presentation" ><a href="index.php">Parcial</a></li>
              <li role="presentation" ><a href="resumo.php">Resumo de vendas</a></li>
              <li role="presentation"  id="active"><a href="#">Venda Transmitida</a></li>
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

      <div class="row"  id="buscar" style="padding-top: 200px; background: #737373;">

          <div class="col-md-12" style="font-family: 'Roboto Slab', serif; font-size: 40px; color: #f9fbff; text-align: center"><h1>Consultar Vendas Flexx Transmitidas</h1></div>
          <div class="col-md-2"></div>


          <div class="col-md-8" style="text-align:center; font-size: 18px; background-color:#676363; font-family:Oswald; color:#E4F3F7;height:90px; border-radius: 30px;  padding-top: 25px;">
              <form method="get" action="">
                  Data Inicial: <input style="height: 40px;color: #1d2121;text-align: center; font-size: 16px;" type="text" id="datepicker" name="dataini">
                  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Data Final: <input style="height: 40px;color: #1d2121;text-align: center; font-size: 16px; padding-left: 20px" type="text" id="datepicker2" name="datafim">
          </div>





          <div class="col-md-2" ></div>

         <div class="col-md-12" style="text-align: center; margin-top: 20px;"><input  id="consulta" class="btn-lg btn-default" style="width: 220px; font-size: 25px" type="submit" value="Consultar"> </div>

      </form>


      </div>

      <?php if(isset($_GET['dataini'])){ ?>


        <div class="row" style="padding-top: 50px; background: #737373;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div> 
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div> 
        <div class="col-md-2"></div>
        
       </div>



        


    <div class="row" style=" background: #737373;">

        <div class="col-md-2"></div>


        <div class="col-md-8" style="text-align:center; font-size: 16px; background-color:#074456; font-family:Oswald; color:#E4F3F7;height:60px; padding-top: 8px;">
            <form method="get" action="">
                Data Inicial: <input style="height: 35px; width:110px; color: #1d2121;text-align: center; font-size: 16px;" type="text" id="datepicker3" name="dataini" required>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspData Final: <input style="height: 35px; width:110px; color: #1d2121;text-align: center; font-size: 16px;" type="text" id="datepicker4" name="datafim" required>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp


                   Vendedor:&nbsp
            <?php echo' <select id="mes" name="rca" style="height: 35px; width:130px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; font-size: 16px;text-align: center; font-weight: bold;" > 
      
';

      $i=1;


            $consulta_rca = $conn->prepare("SELECT nome, Rca FROM usuarios where tipo = 'logar' order by nome");

            $consulta_rca->execute();
            $result_rca = $consulta_rca->fetchAll();
            //var_dump($result_vend);

         echo '<option value=""> </option>';

            foreach ($result_rca as $row) {
    echo '
    
     <option value="' . $row[1] . '"';


        /*if ($i == substr($meta, -2)) {
            echo 'selected';
        }*/


        echo '>'.$row[0].'</option>';


    $i++;
};

      ?>
        </select>
                &nbsp&nbsp&nbsp&nbsp&nbsp<input class="btn-primary" style=" height: 40px; width: 80px;" type="submit" value="Consultar">

            </form>
        </div>


        <div class="col-md-2" ></div>

    </div>



        
        <div class="row" id="painel" style="background: #737373;" >
       <div class="col-md-2"></div>
       <div class="col-md-8" style="background-color:aliceblue; padding:20px">

           <table id="tabela" align="center" cellpadding="5">
<?php
               $z = 0;
               foreach ($result_vend as $row) {

echo '<tr class="success" style="height: 25px;">';
echo '<td colspan="7"></td>';
echo '</tr>';


$color = array (
    0 => "#a8d0da",
    1 => "#55b2ca",

);

$color2 = array (
    0 => "#7ca5b1",
    1 => "#1b829c",

);
                   ?>



           <tr style="background-color: #115265; color: #ffffff; font-size: 16px; font-weight: bold" >

          <td style="width: 50px;">RCA</td>

          <td style="width: 120px;">Vendedor</td>

          <td style="width: 80px;"> Data</td>
          
          <td style="width: 80px;"> Pedido</td>
          
          <td style="width: 100px;"> Cod. Cliente</td>
          
          <td style="width: 350px;  padding-left: 10px"> Cliente</td>
      
          <td style="width: 100px;"> Valor Total </td>
      
          
      </tr>   
      

  <?php



      if (count($result)) {

          foreach ($result[$z] as $row) {

              if($z % 2 == 0){
                  $c = 0;
              } else {
                  $c = 1;
              }


              echo "<tr id='vendas" . $z . "' class='success' style='background-color:$color[$c]!important;'>";

              echo "<td style='width: 50px; '>$row[0]</td>";
              echo "<td id='vendedor' style='width: 120px; font-weight: bold '>$row[1]</td>";
              echo "<td id='data" . $z . "'style='width: 100px;'>$row[2]</td>";
              echo "<td class='link' id='parceiro" . $z . "'style='width: 80px;'><a href='?&nota=$row[3]'>$row[3]</a></td>";
              echo "<td id='nf" . $z . "'style='width: 100px; text-align: center;'>$row[4]</td>";
              echo "<td id='data" . $z . "'style='width: 350px; text-align:left; padding-left: 10px '>$row[5]</td>";

              echo "<td id='valor" . $z . "'style='width: 100px; font-weight: 600 '>" . "R$ " . number_format($row[6], 2, ',', '.') . "<td>";


              echo "</tr>";

          }


            ?>

               <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold; background-color:<?php echo $color2[$c];?>!important">

                   <td colspan="6" style="width: 680px; text-align: right; font-size: 16px; padding-right: 10px">Total
                   </td>

                   <?php

                   foreach ($result2[$z] as $row) {

                       echo '<td style="width: 100px; margin-bottom: 10px; ">R$ ' . number_format($row[0], 2, ',', '.') . '</td>';


                   }


                   echo '</tr>';






      } else {
          //echo "Nennhum resultado retornado.";
          //echo $id;

      }
                   $z++;
  }





?>





           </table>


           <?php if ($pagina + 1 == $num_paginas) {   ?>

          <table align="center" cellpadding="7">
           <tr style="background-color: #28444c; color: #ffffff; font-weight: bold; height: 40px; font-size: 18px">

               <td colspan="4" style="width: 750px; text-align: right; padding-right: 10px">Total
               </td>

               <?php

               foreach ($result3 as $row) {

                   echo '<td colspan="2" style="width: 150px; margin-bottom: 10px;">R$ ' . number_format($row[0], 2, ',', '.') . '</td>';


               }


               echo '</tr>';

          ?>

          </table>

           <?php } ?>

       </div>

 </div>

      <?php if(!isset($_GET['rca']) || $_GET['rca'] == "") { ?>

      <div class="row" style="text-align: center">
          <div class="col-md-2"></div>
          <div class="col-md-8" style="background: aliceblue;">
      <nav aria-label="Page navigation" style="margin: auto">
          <ul class="pagination">
              <li>
                  <a href="vendasflex.php?pagina=0&dataini=<?php echo $dataini."&datafim=".$datafim?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>


              <?php for($i=0;$i<$num_paginas;$i++) {
                  $estilo ="";
                  if($pagina == $i){
                      $estilo = "class='active'";
                  }

                  ?>
              <li <?php echo $estilo ?>><a href="vendasflex.php?pagina=<?php echo $i."&dataini=".$dataini."&datafim=".$datafim ;?>"><?php echo $i; ?></a></li>
              <?php } ?>
              <li>
                  <a href="vendasflex.php?pagina=<?php echo ($num_paginas -1)."&dataini=".$dataini."&datafim=".$datafim ;?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
      </nav>
          </div>
          <div class="col-md-2"></div>

      </div>


      <?php }}?>

    <script>

        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        var first = getUrlVars()["dataini"];

        //alert(first);



        if(typeof first != 'undefined' ){

            $("#buscar" ).css("display","none");
        }








    </script>

    </body>
</html>
