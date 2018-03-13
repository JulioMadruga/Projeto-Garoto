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
          background: #9ef15c;
          }
          .link2 a { color: #000000;}
          .link2 a:hover {text-decoration: none; font-weight: bold;
                  }
            table, th, td {
   border: none;  border-bottom:solid; border-collapse: collapse; border-color: #245269; padding: 3px;
}  </style>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
     <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
     <link rel="stylesheet" href="../css/bootstrap.css.map">
        <link rel="stylesheet" href="../css/menu.css">
     <script src="../js/bootstrap.min.js"></script>
     <script src="../js/calc_total.js"
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
       
     <script>   // aqui eh a base da pagina
window.onload = function(){
    
    document.getElementById('mes').onchange = function(){
        vd = document.getElementById('vendedor').innerText;
        window.location = '?mes=' + this.value +'&vd='+vd;
    }

}

         $(document).ready( function(){
             $("#painel").hide();
             $("#painel").slideDown(1500);

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
      <?php
  
    $data = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
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
    
 $mes_meta= array(
        'Janeiro' => 'meta1',
        'Fevereiro' => 'meta2',
        'Marco' => 'meta3',
        'Abril' => 'meta4',
        'Maio' => 'meta5',
        'Junho' => 'meta6',
        'Julho' => 'meta7',
        'Agosto' => 'meta8',
        'Setembro' => 'meta9',
        'Outubro' => 'meta10',
        'Novembro' => 'meta11',
        'Dezembro' => 'meta12',
        ''    => ''
    );   
    

 
  $mes = $mes_extenso["$mes"];
  $meta = $mes_meta["$mes"]; 

if (isset($_POST['enviar'])){
$vendedor = $_POST['select_ved'];
$id = $vendedor;
$data = $_POST['select_mes'];
$mes = $data;
}else{
$vendedor=$_GET['vd'];
$id = $vendedor;}

if ($vendedor == ""){
 echo "<script>alert('Selecione um Vendedor!!!')</script>" ;
echo $vendedor;
 }

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
 

 

 $consulta = $conn->prepare("SELECT Nome_parceiro, VENDEDOR,  sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))), n_nf, data_doc FROM $mes WHERE VENDEDOR = :id GROUP BY n_nf order by data_doc");
 $consulta->execute(array('id' => $id));
 $consulta1 = $conn->prepare("SELECT sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) FROM $mes WHERE VENDEDOR = :id");
 $consulta1->execute(array('id'=> $id));
 
if(isset($_GET['nota'])){
 $nota = $_GET['nota'];
 $id = $_GET['vd'];
 
 $consulta3 = $conn->prepare("SELECT Nome_parceiro, texto_breve_do_produto, quantidade, Replace(Round(valor_total/quantidade,2),'.',',') as vunid, valor_total, n_nf, data_doc FROM $mes where n_nf = $nota and vendedor = :id");
 $consulta3->execute(array('id' => $id));
 $result3 = $consulta3->fetchAll();
 
 $consulta4 = $conn->prepare("SELECT Nome_parceiro, texto_breve_do_produto, quantidade, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total, n_nf, data_doc FROM $mes where n_nf = $nota and vendedor = :id");
 $consulta4->execute(array('id' => $id));
 $result4 = $consulta4->fetchAll();
 //var_dump($result3);
}
  
    $result1 = $consulta1->fetchAll();

    $result = $consulta->fetchAll();
  
   
  
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
   
   
   
  ?>

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
                            <li><a href="ativoxpositivado.php">Cliente Ativos X Positivados</a></li>

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

        
        
        <div class="row" style="padding-top: 20px; background: #737373;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div> 
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div> 
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
    <!--<option value="meta1"'.$check0.'>Janeiro</option>   
      <option value="meta2"'.$check1.'>Fevereiro</option>
      <option value="meta3"'.$check2.'>Março</option>
      <option value="meta4"'.$check3.'>Abril</option>
      <option value="meta5"'.$check4.'>Maio</option>
      <option value="meta6"'.$check5.'>Junho</option>-->
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
       
    </div>    ';
        
       
     if (!isset($_GET['nota']))  {  
         
         
         
         
        ?>
        
        
        
        
        
        
        <div class="row" style="background: #737373;" >
       <div class="col-md-2"></div> 
       <div class="col-md-8" style="background-color: aliceblue; padding:20px "> 
           
           <table id="tabela" align="center" cellpadding="5"> 
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold" > 
      
          <td style="width: 100px;">Vendedor</td>
          
          <td style="width: 300px;"> Clientes</td>
          
          <td style="width: 80px;"> Numero da NF</td>
          
          <td style="width: 80px;"> Data</td>
      
          <td style="width: 150px;"> Valor Total </td>        
      
          
      </tr>   
      
      
  <?php  
  
  
      
  if (count($result) ) {
      $i = 0;
    foreach($result as $row) {
        
        extract($row);
       // var_dump($row);
        
                 do {  
       echo "<tr id='vendas".$i."' class='success'>";
       echo "<td id='vendedor' style='width: 100px; '>{$VENDEDOR}";
       echo "<td class='link' id='parceiro".$i."'style='width: 300px;'><a href='?vd=$id&nota={$n_nf}&mes=$meta'>$row[0]</a></td>"; 
       echo "<td class='link' id='nf".$i."'style='width: 100px; text-align: center;'><a href='?vd=$id&nota={$n_nf}&mes=$meta'>{$n_nf}</a></td>";
       echo "<td id='data".$i."'style='width: 100px; text-align: center;'>{$data_doc}</td>";
       
       echo "<td id='valor".$i."'style='width: 150px;'>"."R$ ". number_format($row[2], 2, ',', '.');
      
       $i++;
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
    //echo "Nennhum resultado retornado.";
    //echo $id;
   
  }


  
  
 foreach($result1 as $row2) {
     extract($row2);
    echo "<tr style='background-color: #1b6d85; color: #ffffff;'>";
    echo "<td style='width: 100px;'>";
    echo "<td style='width: 300px;'>";
    echo "<td style='width: 100px;'>";
    echo "<td style='width: 100px; text-align: right;'><strong>Valor Total:&nbsp&nbsp</strong>";
    echo "<td style='width: 100px;'>"."R$ ". number_format($row2[0], 2, ',', '.');
 }
 
 echo "</table>";
 echo '<script>  verifica(); </script>';
 echo "<div style='text-align: center;'>";
 echo "<h2 style='text-align:center;'class='btn btn-default btn-lg link2'><a style='padding:6px;'href='index.php'>Voltar</a><h2>";    
 echo "</div>";
     }else{ ?>
         
        <div class="row" style="background: #737373;" >
       <div class="col-md-2"></div> 
       <div class="col-md-8" style="background-color: aliceblue; padding:20px "> 
           
           <table id="tabela" align="center" cellpadding="5" >
               <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold; height: 40px; font-size: 17px;">
                   <td style="text-align: right;width: 60px; background: #0F5367;">Cliente:&nbsp&nbsp</td>
                   <td style="text-align: left;width: 240px; background: #0F5367;"><?php echo $result3[0][0] ?> </td>
                   <td style="text-align: right;width: 70px;background: #1B3035;">Data:&nbsp&nbsp</td>
                   <td style="text-align: left;width: 80px;background: #1B3035;"><?php echo $result3[0][6] ?> </td>
                   <td style="text-align: right;width: 70px;background: #1B3035;">Nota:&nbsp&nbsp</td>
                   <td style="text-align: left;width: 80px;background: #1B3035;"><?php echo $result3[0][5] ?> </td>
                                     
               </tr>
              <!-- <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold"> 
                   <td style="text-align: center;"><?php //echo $result3[0][0] ?> </td>
                   <td style="text-align: center;"><?php// echo $result3[0][5] ?> </td>
                   <td style="text-align: center;"><?php //echo $result3[0][4] ?> </td>
                   
               </tr>  -->
              
               <tr style="height: 20px; border-left:#F0F8FF; border-right: #F0F8FF;">
                   <td colspan="6" ></td>
                   
               </tr>
               
               
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold; height: 30px;" > 
      
               <td colspan="2" style="width: 500px;">Descrição do Produto</td>
          
          <td  style="width: 70px;">Quantidade</td>
          
          <td  style="width: 80px;">Valor Unid.</td>
          
          <td colspan="2" style="width: 150px; text-align: center;"> Valor Total</td>
             
            
      
          
      </tr>   
      
      
  <?php  
  
  
      
  if (count($result3) ) {
      $i = 0;
    foreach($result3 as $row) {
        
        extract($row);
       // var_dump($row);
        
                 do {  
       echo "<tr id='vendas".$i."' class='success' style=' height: 25px;'>";
       echo "<td colspan='2' id='prod' style='width: 500px;'>$row[1]</td>";
       echo "<td  id='quant' style='width: 70px;text-align:center;'>$row[2]</td>";
       echo "<td id='quant' style='width: 80px;text-align:center;'>$row[3]</td>";
       echo "<td id='valor".$i."'colspan='2' id='total' style='width: 150px; text-align:center;'>$row[4]</td>";
             
       $i++;
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
    //echo "Nennhum resultado retornado.";
    //echo $id;
   
  }


  
  
 foreach($result4 as $row) { 
     extract($row);
    echo "<tr style='background-color: #1b6d85; color: #ffffff; height: 30px; font-size: 17px;'>";
    echo "<td colspan='4' style='width: 650px; text-align: right;'><strong>Valor Total:</strong>";
    echo "<td colspan='2' style='width: 150px; text-align:center;'>"."R$ ". number_format($row[3], 2, ',', '.');
 }
 
 
 echo "</table>";  
 echo '<script>  verifica(); </script>';
 echo "<div style='text-align: center;'>";        
 echo "<h2 style='text-align:center;'class='btn btn-default btn-lg link2'><a style='padding:6px;'href=javascript:window.history.back();'?vd=".$id."&mes=".$meta."'>Voltar</a><h2>";          
 echo "</div>";         
         
         
         
     }
 ?>
                    
</div>;
 <div class="col-md-2"></div>
 </div>


    </body>
</html>
