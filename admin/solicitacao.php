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

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Metas Garoto</title>
        <style type="text/css">
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
         <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
        <link rel="stylesheet" href="../css/menu.css">
        <link rel="stylesheet" href="../css/tableexport.min.css">
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
        <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>

        window.onload = function(){
            document.getElementById('regiao').onchange = function(){
                rca = document.getElementById('rca').value;
                window.location = '?status=' + this.value + '&rca='+ rca;


            }


        }


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
    <body class="view">


    <div id="nav" class="col-lg-12"  style="background: #121415;">
        <ul class="nav">
            <li role="presentation"><a href="index.php">Parcial</a></li>
            <li role="presentation"><a href="resumo.php">Resumo de vendas</a></li>
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
            <li role="presentation"><a href="acessos.php">Relat. de Acessos</a></li>
            <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle"> Cadastros <span>▼</span>  </a>
                <ul class="dropdown-menu">
                    <li role="presentation" ><a href="cadastrar.php">Cadastrar Metas</a></li>
                    <li role="presentation" ><a href="campanha.php">Cad. Campanhas</a></li>
                    <li role="presentation" ><a href="cadvend.php">Cad. Vendedores</a></li>
                    <li role="presentation"  id="active"><a href="#">Solic. Cadastros</a></li>

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
        
        
        <div id="logo" class="row" style="padding-top: 80px; background: #737373;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div>
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div>
        <div class="col-md-2"></div>
        
       </div>


    <div class="row" style=" background: #737373;">

        <div class="col-md-2"></div>
        <div class="col-md-8" style="padding-top: 5px;background: aliceblue;text-align: center;">

            <select id="regiao"  name="regiao " style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 280px; font-size: 18px;text-align: center; font-weight: bold;">

                <option>Filtrar</option>
                <option>Pendente</option>
                <option>Em andamento</option>
                <option>Aprovado</option>
                <option>Recusado</option>
                <option>Todos</option>

            </select>

            <?php

            $conn->exec("set names utf8");
            $consulta_ved = $conn->prepare("SELECT a.nome, a.Rca FROM usuarios a, solicitacao b where a.rca = b.rca and tipo = 'logar' GROUP BY a.nome order by nome");
            $consulta_ved-> execute();
            $result2= $consulta_ved->fetchAll();
            ?><select id="rca" name="rca" style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 280px; font-size: 18px;text-align: center; font-weight: bold;"> <?php
                    ?>
                    <option selected value="">Vendedor</option>
                    <?php
                    if ( count($result2) ) {

                        foreach($result2 as $row) {

                            extract($row);

                            do {


                                ?>
                                <option value="<?php echo $row[1];?> "><?php echo $row[0]; ?></option>
                                <?php


                            } while ($row= null);


                        }
                    } else {
                        echo "Nennhum resultado retornado.";
                    }
                    ?>


                </select>


        </div>
        <div class="col-md-2"></div>

    </div>
        
        
        
        
        
        <div class="row" style="background: #737373;" >
       <div class="col-md-2"></div> 
       <div class="col-md-8" style="background-color:aliceblue; padding:10px; ">

           <?php

            if(isset($_GET['status'])){


                $estado = $_GET['status'];



                if($estado == "Todos"  ){

                    $consulta_Solicitacoes = $conn->prepare("Select a.rca, a.cnpj, a.razao, a.estado, a.obs, DATE_FORMAT(a.dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(a.datafim ,'%d/%m/%Y')AS datafim, b.nome, a.obs from solicitacao a, usuarios b where a.rca = b.rca ORDER BY a.estado DESC, a.dataini DESC  ");
                    $consulta_Solicitacoes->execute();
                    $result_solicit = $consulta_Solicitacoes->fetchAll();

                    $rca = $result_solicit[0][0];




            }else{

                if(isset($_GET['rca'])){


                    $rca = $_GET['rca'];

                    if(strlen($rca)<= 0){

                        $consulta_Solicitacoes = $conn->prepare("Select a.rca, a.cnpj, a.razao, a.estado, a.obs, DATE_FORMAT(a.dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(a.datafim ,'%d/%m/%Y')AS datafim, b.nome, a.obs from solicitacao a, usuarios b where a.rca = b.rca and a.estado = '$estado' ORDER BY a.estado desc, a.dataini DESC  ");
                        $consulta_Solicitacoes->execute();
                        $result_solicit = $consulta_Solicitacoes->fetchAll();



                    }else{

                    $consulta_Solicitacoes = $conn->prepare("Select a.rca, a.cnpj, a.razao, a.estado, a.obs, DATE_FORMAT(a.dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(a.datafim ,'%d/%m/%Y')AS datafim, b.nome, a.obs from solicitacao a, usuarios b where a.rca = b.rca and a.rca = $rca and a.estado = '$estado' ORDER BY a.estado desc, a.dataini DESC  ");
                    $consulta_Solicitacoes->execute();
                    $result_solicit = $consulta_Solicitacoes->fetchAll();

                         }

                }else {

                    $consulta_Solicitacoes = $conn->prepare("Select a.rca, a.cnpj, a.razao, a.estado, a.obs, DATE_FORMAT(a.dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(a.datafim ,'%d/%m/%Y')AS datafim, b.nome, a.obs from solicitacao a, usuarios b where a.rca = b.rca ORDER BY a.estado desc, a.dataini DESC  ");
                    $consulta_Solicitacoes->execute();
                    $result_solicit = $consulta_Solicitacoes->fetchAll();


                }

            }}else{

                $consulta_Solicitacoes = $conn->prepare("Select a.rca, a.cnpj, a.razao, a.estado, a.obs, DATE_FORMAT(a.dataini ,'%d/%m/%Y') as dataini,
                                                         DATE_FORMAT(a.datafim ,'%d/%m/%Y')AS datafim, b.nome, a.obs from solicitacao a, usuarios b where a.rca = b.rca ORDER BY a.estado DESC, a.dataini DESC  ");
                $consulta_Solicitacoes->execute();
                $result_solicit = $consulta_Solicitacoes->fetchAll();

                $rca = $result_solicit[0][0];

            }


               echo '                
               
               <div class="col-md-12" style="right: 20px; top: -5px"> <button style="float: right;" class="btn-default" id="btnExport"><img src="../images/excel.png" width="40px" height="40px" /> Exportar para Excel</button>  </div>
               
               <div  class="col-md-12">
               
               <table id="tblExport"  class="table-responsive" align="center" cellpadding="5"> 
               
               <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold"> 
               
               <th style="width: 50px; padding: 5px !important; border-left-color: aliceblue; border:solid; font-size: 12px;">Rca</th>
               
               <th style="width: 100px; padding: 5px !important; border-left-color: aliceblue; border:solid; font-size: 12px;">Vendedor</th>
      
               <th style="width: 350px; padding: 5px !important; border-left-color: aliceblue; border:solid;">CLIENTE</th>
          
               <th style="width: 200px;padding: 5px !important; border-left-color: aliceblue; border:solid;">CNPJ</th>
          
               <th style="width: 100px;padding: 5px !important; border-left-color: aliceblue; border:solid;">STATUS</th>
               
               <th style="width: 400px;padding: 5px !important; border-left-color: aliceblue; border:solid;">OBSEVAÇÕES</th>
          
               <th style="width: 90px;padding: 5px !important; border-left-color: aliceblue; border:solid;">DATA DA SOLICITAÇÃO</th>
      
               <th style="width: 90px;padding: 5px !important; border:solid;">PREVISÃO DE ENCERRAMENTO</th>        
      
          
                </tr>   
               
                                    
            
                     
               
               
               ';

               foreach ($result_solicit as $row){

                   if($row[3] == "Pendente") {


                       echo "<tr id='status2' style='background-color:#cbd3da; color:#584f4f;'>";
                       echo "<td style='width: 50px; padding: 5px !important; font-weight: bold; text-align: center'>" . $row[0] . "</td>";
                       echo "<td style='width: 100px; padding: 5px !important; font-weight: bold;'>" . $row[7] . "</td>";
                       echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                       echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                       echo "<td id ='status' style='width: 100px; padding: 5px !important;'>
                      <button type='button' class ='btn btn-default btn-xs' data-toggle='modal' data-target='#exampleModal' 
                      data-cliente='$row[2]' data-cnpj='$row[1]'  data-fim='$row[6]' data-obs ='$row[4]' data-select ='Pendente' data-rca = '$row[0]'
                      style='width: 100px'>" . $row[3] . "</button></td>";

                       echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                   }

                   if($row[3] == "Em andamento") {


                       echo "<tr id='status2' style='background-color:#fff9c6; color:#584f4f;'>";
                       echo "<td style='width: 50px; padding: 5px !important; font-weight: bold; text-align: center'>" . $row[0] . "</td>";
                       echo "<td style='width: 100px; padding: 5px !important; font-weight: bold;'>" . $row[7] . "</td>";
                       echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                       echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                       echo "<td id ='status' style='width: 100px; padding: 5px !important;'>
                      <button type='button' class ='btn btn-warning btn-xs' data-toggle='modal' data-target='#exampleModal' 
                      data-cliente='$row[2]' data-cnpj='$row[1]'  data-fim='$row[6]' data-obs ='$row[4]' data-select ='Em andamento' data-rca = '$row[0]'
                      style='width: 100px'>" . $row[3] . "</button></td>";echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                   }

                   if($row[3] == "Aprovado") {


                       echo "<tr id='status2' style='background-color:#dff5c5; color:#584f4f;'>";
                       echo "<td style='width: 50px; padding: 5px !important; font-weight: bold; text-align: center'>" . $row[0] . "</td>";
                       echo "<td style='width: 100px; padding: 5px !important; font-weight: bold;'>" . $row[7] . "</td>";
                       echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                       echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                       echo "<td id ='status' style='width: 100px; padding: 5px !important;'>
                      <button type='button' class ='btn btn-success btn-xs' data-toggle='modal' data-target='#exampleModal' 
                      data-cliente='$row[2]' data-cnpj='$row[1]'  data-fim='$row[6]' data-obs ='$row[4]' data-select ='Aprovado' data-rca = '$row[0]'
                       style='width: 100px'>" . $row[3] . "</button></td>";echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                   }

                   if($row[3] == "Recusado") {


                       echo "<tr id='status2' style='background-color:#f5a7a7; color:#584f4f;'>";
                       echo "<td style='width: 50px; padding: 5px !important; font-weight: bold; text-align: center'>" . $row[0] . "</td>";
                       echo "<td style='width: 100px; padding: 5px !important; font-weight: bold;'>" . $row[7] . "</td>";
                       echo "<td style='width: 350px; padding: 5px !important; font-weight: bold'>" . $row[2] . "</td>";
                       echo "<td style='width: 200px; padding: 5px !important;'>" . $row[1] . "</td>";
                       echo "<td id ='status' style='width: 100px; padding: 5px !important;'>
                      <button type='button' class ='btn btn-danger btn-xs' data-toggle='modal' data-target='#exampleModal' 
                      data-cliente='$row[2]' data-cnpj='$row[1]'  data-fim='$row[6]' data-obs ='$row[4]' data-select ='Recusado' data-rca = '$row[0]'
                       style='width: 100px'>" . $row[3] . "</button></td>";echo "<td style='width: 400px; padding: 5px !important;'>" . $row[4] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[5] . "</td>";
                       echo "<td style='width: 90px; padding: 5px !important;'>" . $row[6] . "</td>";

                   }



                   echo "</tr>";

               }




               echo "</table>";





         ?>




           </div>

           <!-- --------------------------------------------------------------------------------------------------- -->

          <?php

           if(isset($_GET['cli'])){

               $rca = $usuario->getRca();
               $cli = $_GET['cli'];

               $delcliente = $conn->prepare("Delete from solicitacao where cnpj = $cli");
               $delcliente->execute();

               echo ("<script>alert('Solicitação excluida!');window.history.go(-1);</script>"); die;



           }







           ?>


                    
</div>
 <div class="col-md-2"></div>
 </div>

    <div class="modal fade bs-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Alterar a Senha</h4>
                </div>
                <div class="modal-body">
                    <form action="upsolicit.php?cnpj=<?php print $rca; ?>" method="post" name="form">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">RCA:</label>
                            <input type="text" class="form-control" id="rca" name="rca" readonly>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Razão do Cliente</label>
                            <input type="text" class="form-control" id="razao" name="razao" readonly>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">CNPJ:</label>
                            <input type="text" class="form-control" id="cnpj" name="cnpj" readonly>
                        </div>

                        <div class="form-select">
                            <label for="recipient-name" class="control-label">Status</label>
                            <select class="form-control" id="selEstado" name="selEstado">
                                <option value="Pendente">Pendente</option>
                                <option value="Em andamento" >Em andamento</option>
                                <option value="Aprovado">Aprovado</option>
                                <option value="Recusado">Recusado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Data de encerramento:</label>
                            <input type="text" class="form-control" id="datafim" name="datafim">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Obs:</label>
                            <input type="text" class="form-control" id="obs" name="obs">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" value='Alterar' >Alterar</button>
                </div>
                </form>
            </div>
        </div>
    </div>




    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>


    <script>

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('cliente') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var cnpj = button.data('cnpj')

            var fim =  button.data('fim').toString()

            var obs =  button.data('obs')

            var select =  button.data('select')

            var rca = button.data('rca')

            var modal = $(this)
            modal.find('.modal-title').text('Alterar Solicitação Cliente: ' + recipient)
            modal.find('.modal-body #razao').val(recipient)
            modal.find('.modal-body #cnpj').val(cnpj)
            modal.find('.modal-body #datafim').val(fim)
            modal.find('.modal-body #obs').val(obs)
            modal.find('.modal-body div.form-select select').val(select)
            modal.find('.modal-body #rca').val(rca)
        })


    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="../js/jquery.btechco.excelexport.js"></script>
    <script src="../js/jquery.base64.js"></script>

    <script>
        $(document).ready(function () {
            $("#btnExport").click(function () {
                $("#tblExport").btechco_excelexport({
                    containerid: "tblExport"
                    , datatype: $datatype.Table
                    , filename: 'Solicitações de Cadastro'
                });
            });
        });
    </script>

</html>
