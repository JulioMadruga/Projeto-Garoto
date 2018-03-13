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

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Metas Garoto</title>
        <style type="text/css">
            html{
                background-color: #f0f8ff !important;
            }
          .link a { color: #000000;}  
          .link a:hover {text-decoration: none; font-weight: bold;
          background:#0a2b1d;
          }  
          .link2 a { color: white;}
          .link2 a:hover {text-decoration: none; color: #0a2b1d;
                  }  
            table, th, td {
   border: none;  border-bottom:solid; border-collapse: collapse; border-color: #245269; padding: 3px;
}  </style>
         <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="css/bootstrap.css.map">
    <link rel="stylesheet" href="css/menu_mobile.css" >
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>



        
        
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
                <li role="presentation"><a href="bimarca.php">Post. Bimarca</a></li>
                <li role="presentation"><a href="jumbos.php">Post. Jumbos</a></li>
                <li role="presentation" class="active"><a href="#">Solicitação de Cadastro</a></li>
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
        

        
        
        
        
        
        
        <div class="row" style="background: #737373; font-size: 30px" >
        <div class="col-md-12" style="background-color:aliceblue; padding:10px; ">
           
        <h1 STYLE="text-align: center; font-family:Oswald; color:#074456; ">SOLICITAÇÃO DE CADASTRO DE CLIENTES</h1>
            <div class="col-lg-12" style="height: 15px"></div>
           <div class="col-sm-12" style="padding: 10px; background-color: #f0f8ff">
           <form class="form-horizontal" METHOD="post" action="cadastro.php?rca=<?php print $usuario->getRca(); ?>">
               <fieldset>
                   <legend style="font-size: 25px">Dados para cadastro:</legend>
               <div class="form-group">
                   <label  class="col-sm-2 control-label">Razão:</label>
                   <div class="col-sm-10">
                       <input style="height: 70px; font-size: 30px" type="text" class="form-control" name="razao" placeholder="Razão Social do Cliente" required>
                   </div>
               </div>
               <div class="form-group">
                   <label  class="col-sm-2 control-label" n>CNPJ:</label>
                   <div class="col-sm-10">
                       <input style="height: 70px; font-size: 30px"  maxlength="18" type="text" class="form-control" name="cnpj" placeholder="XX.XXX.XXX/XXXX-XX" pattern=".{0}|.{14,}"   required title="O CNPJ TEM NO MINIMO 14 CARACTERES">
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-sm-offset-2 col-sm-10">
                       <button  style="font-size: 35px" type="submit" class="btn btn-default">Enviar</button>
                   </div>
               </div>
               </fieldset>
           </form>

           </div>
           <!-- --------------------------------------------------------------------------------------------------- -->

           <?php

           if(!isset($_GET['rca'])) {

               echo '
           
           <div id="btconsult"  class="col-lg-12" style="text-align: center" >

               <h2 style="text-align:center;"class="btn btn-success btn-lg link2"><a style="padding:6px;"href="solicitacao.php?rca=';
               print $usuario->getRca(); echo '">Consultar Solicitações</a><h2>


           </div>

                ';
           }

           if(isset($_GET['rca'])){

               $rca = $_GET['rca'];

               $consulta_Solicitacoes = $conn ->prepare("Select rca,cnpj,razao,estado, obs, DATE_FORMAT(dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(datafim ,'%d/%m/%Y')AS datafim from solicitacao where rca = $rca ORDER BY estado desc, dataini DESC ");
               $consulta_Solicitacoes-> execute();
              // var_dump($consulta_Solicitacoes);
               $result_solicit= $consulta_Solicitacoes ->fetchAll();

               echo '
               
               <div class="col-lg-12">
               
               <table id="tabela" align="center" cellpadding="5"> 
               
               <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold"> 
               
               <td style="width: 30px; padding: 5px !important; border-left-color: aliceblue; border:solid; font-size: 12px;">EXCLUIR</td>
      
               <td style="width: 350px; padding: 5px !important; border-left-color: aliceblue; border:solid;">CLIENTE</td>
          
               <td style="width: 200px;padding: 5px !important; border-left-color: aliceblue; border:solid;">CNPJ</td>
          
               <td style="width: 100px;padding: 5px !important; border-left-color: aliceblue; border:solid;">STATUS</td>
               
               <td style="width: 400px;padding: 5px !important; border-left-color: aliceblue; border:solid;">OBSEVAÇÕES</td>
          
               <td style="width: 90px;padding: 5px !important; border-left-color: aliceblue; border:solid;">DATA DA SOLICITAÇÃO</td>
      
               <td style="width: 90px;padding: 5px !important; border:solid;">PREVIZÃO DE ENCERRAMENTO</td>        
      
          
                </tr>   
               
               
               

               
               
                     
               
               
               ';

                    foreach ($result_solicit as $row){

                       if($row[3] == "Pendente") {


                           echo "<tr id='status2' style='background-color:#cbd3da; color:#584f4f;'>";
                           echo "<td style='width: 50px; padding: 5px !important; text-align: center'><a href='?cli=".$row[1]."'><img border='0' alt='Excluir'src='images/delete.png' width='20' height='20'></a></td>";
                           echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                           echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                           echo "<td id ='status' style='width: 100px; padding: 5px !important;'><button class ='btn btn-default btn-xs' style='width: 100px'>" . $row[3] . "</button></td>";
                           echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                           echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                           echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                       }

                        if($row[3] == "Em andamento") {


                            echo "<tr id='status2' style='background-color:#fff9c6; color:#584f4f;'>";
                            echo "<td style='width: 50px; padding: 5px !important; text-align: center'><a href='?cli=".$row[1]."'><img border='0' alt='Excluir'src='images/delete.png' width='20' height='20'></a></td>";
                            echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                            echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                            echo "<td id ='status'style='width: 100px; padding: 5px !important;'><button  class ='btn btn-warning btn-xs' style='width: 100px' >" . $row[3] . "</button></td>";
                            echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                        }

                        if($row[3] == "Aprovado") {


                            echo "<tr id='status2' style='background-color:#dff5c5; color:#584f4f;'>";
                            echo "<td style='width: 50px; padding: 5px !important; text-align: center;'><a href='?cli=".$row[1]."'><img border='0' alt='Excluir'src='images/delete.png' width='20' height='20'></a></td>";
                            echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                            echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                            echo "<td id ='status'  style='width: 100px; padding: 5px !important;'><button class ='btn btn-success btn-xs' style='width: 100px'>" . $row[3] . "</button></td>";
                            echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                        }

                        if($row[3] == "Recusado") {


                            echo "<tr id='status2' style='background-color:#f5a7a7; color:#584f4f;'>";
                            echo "<td style='width: 50px; padding: 5px !important; text-align: center'><a href='?cli=".$row[1]."'><img border='0' alt='Excluir'src='images/delete.png' width='20' height='20'></a></td>";
                            echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                            echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                            echo "<td id ='status' style='width: 100px; padding: 5px !important;'><button class ='btn btn-danger btn-xs' style='width: 100px'>" . $row[3] . "</button></td>";
                            echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                            echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                        }



                        echo "</tr>";

                    }




                echo "</table>";



           }


           if(isset($_GET['cli'])){

               $rca = $usuario->getRca();
               $cli = $_GET['cli'];

               $delcliente = $conn->prepare("Delete from solicitacao where cnpj = $cli");
               $delcliente->execute();

               echo ("<script>alert('Solicitação excluida!');window.history.go(-1);</script>"); die;



           }







           ?>




                    
</div>

 </div>


        <script>   // aqui eh a base da pagina



            $(document).ready(function(){
                $("#btconsult").click(function(){
                    $("#btconsult").hide();
                });
            });





        </script>

    </body>
</html>
