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
 




?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel Administrador</title>
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
               
        <link rel="stylesheet" href="../css/component.css">
    <link rel="stylesheet" href="../css/default.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/modernizr.custom.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     
     <script>   // aqui eh a base da pagina
window.onload = function(){
    document.getElementById('mes').onchange = function(){
        window.location = '?mes=' + this.value;
    }
}


$(document).ready( function(){
    
$("#painel").hide(); 
$("#painel").slideDown(1500);  


$("tr:even").css("background","#889FA7");
$("tr:last").css("background","#074456");
$("tr:first").css("background","#074456");

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
    <body class="cbp-spmenu-push">
         <div id="nav" class="col-lg-12"  style="background: #121415;">
             <ul class="nav">
                 <li role="presentation"><a href="index.php">Parcial</a></li>
                 <li role="presentation"><a href="resumo.php">Resumo de vendas</a></li>
                 <li role="presentation"  ><a href="metas.php">Metas</a></li>
                 <li role="presentation" id="active" ><a href="#">Rel.de Vendas</a></li>
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
                         <li><a href="cadastrar.php">Cadastrar Metas</a></li>
                         <li><a href="campanha.php">Cad. Campanhas</a></li>

                     </ul>

                 </li>
                 <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">Importacao<span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li><a href="Importacao.php">Resultados</a></li>
                         <li><a href="clientes.php">Clientes</a></li>

                     </ul>

                 </li>
                 <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;"><input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.  href='../controle.php?tipo=sair'"></li>
                 <li role="presentation" style="float: right;"><h5 style="color: #A6CFF3; font-family: sans-serif;padding-top: 4px;">Usuário: <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>

             </ul>
        </div>     
        
       <?php
       echo '
         <div id="selecao" class="row" style="background: #737373;">   
         <div class="col-md-2"></div> 
         
        <div class="col-md-8" style="text-align:right; background-color:#074456; font-size: 14px; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 13px;">';
               
$consulta_ved = $conn->prepare("SELECT CONVERT(nome USING utf8) nome FROM usuarios where tipo = 'logar' order by nome");
 $consulta_ved-> execute();
 $result2= $consulta_ved->fetchAll();
 
 ?> <form action="" method="post" style="font-size: 13px;" > <label>Vendedor:</label> <select name="select_ved" style="height: 30px; margin-right: 80px; padding-right: 50px;"> <?php
 ?>
         <option selected value="">-   -    -   - Selecionar   -   -   -   -</option>
      <?php
if ( count($result2) ) {
      
    foreach($result2 as $row) {
        
        extract($row);
        
                 do {  
       
                     
      ?>
         <option><?php echo $row[0]; ?></option>
      <?php
     
      
       } while ($row= null);
      
   
    }  
  } else {
    echo "Nennhum resultado retornado.";
      }
?>

                
 </select> 
                
        Data Inicial: &nbsp&nbsp   <input name="dt_ini" type="date" style=" height: 30px;"/>
        Data Final: &nbsp&nbsp   <input  name="dt_fin" type="date"  style=" height: 30px;"/>&nbsp&nbsp
        
        <input name="enviar" type="submit" class="btn-primary" style=" width: 80px; height: 30px;" value="Consultar" /> </form>

</div>
       
       <div class="col-md-2" style="margin: auto; background-color:#737373;font-family:Oswald; color:#E4F3F7;height: 32px;"> 

</div>
       
        <div class="col-md-2"></div> 
       
    </div>    
    


 <?php
       
       
 if (isset($_POST['enviar'])){
$vendedor = $_POST['select_ved'];
$id = $vendedor;
$dataini = $_POST['dt_ini'];
$datafin = $_POST['dt_fin'];


if($vendedor == ""){
 $consulta_ved = $conn->prepare("SELECT vendedor, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM geral where Data_doc between'". $dataini."' and '". $datafin."' group by vendedor");
 
 $consulta_ved-> execute();
 $result2 = $consulta_ved->fetchAll();
 
 
 $consulta_tot = $conn->prepare("SELECT vendedor, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM geral where Data_doc between'". $dataini."' and '". $datafin."'");
 $consulta_tot-> execute();
 $result_TOTAL= $consulta_tot->fetchAll();



 echo '
    <div class="row" style="background: #737373; height:40px;">
<div class="col-md-2"></div>
<div class="col-md-8" style="background: #8FA7AF; height: 40px; font-family:Oswald; text-align:center">Relatório de Vendas  - Período: '.date("d/m/Y", strtotime($dataini)).' a '.date("d/m/Y", strtotime($datafin)).'</div>
<div class="col-md-2"></div>

</div>

<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 20px; background-color:#CED4D6; font-family:Oswald; color:#270301;">
<table align="center" cellpadding="5">

<tr style="font-size: 15px;background: #820505;color: aliceblue;height: 33px;"> 
<td style="width: 250px; text-align: center; border: solid; border-color: #CED4D6;">Vendedor</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #CED4D6;">Total</td>




</tr>

';

if (count($result2) ) {
      
    foreach($result2 as $row) {
        
        extract($row);
       
                 do {  
                           echo '<tr class="success" style="background: #ABB7BB; font-size:14px;">';
                           echo'<td style="width: 250px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[0].'</td>';
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #CED4D6;">R$ '.number_format($row[1], 2, ',', '.').'</td>';
                          
       
       } while ($row= null);
      echo "</tr>"; 
    
      
   
   
    }  
     
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;
   
  }

 echo '</table>';
      
      echo '<table align="center" cellpadding="5" style="margin-top: 8px;">';
  
   if (count($result_TOTAL) ) {
      
    foreach($result_TOTAL as $row) {
        
        extract($row);
       
                 do {  
                           echo '<tr class="success" style="background: #BED1D6">';
                          
                          echo '<tr class="success" style="background: #820505; font-size:16px;color: aliceblue;height: 37px;">';
                           echo '<td style="width: 250px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">Total</td>';
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">R$ '.number_format($row[1], 2, ',', '.').'</td>';
                       
      
       
       
       } while ($row= null);
      echo "</tr>"; 
    
      
   
   
    }  
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;
   
  }
 
  
    echo '
</table>
</br>

</div>
<div class="col-md-2"></div> 
<div class="col-md-2"></div> 
</div>

';
    
          
}  
 

else{
$consulta_ved = $conn->prepare("SELECT Nome_parceiro, cidade, N_NF, Data_doc ,sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM geral where Data_doc between'". $dataini."' and '".$datafin."' and vendedor=:id group by n_nf order by Data_doc");
$consulta_ved-> execute(array('id' => $id));
$result2= $consulta_ved->fetchAll(); 
//var_dump($result2);

$consulta_tot = $conn->prepare("SELECT vendedor, sum(cast(replace(replace(Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Total FROM geral where Data_doc between'". $dataini."' and '". $datafin."' and vendedor=:id");
$consulta_tot-> execute(array('id' => $id));
$result_TOTAL= $consulta_tot->fetchAll();

echo '
    <div class="row" style="background: #737373; height:15px;">
<div class="col-md-2"></div>
<div class="col-md-8" style="background: #CED4D6; height: 15px;"></div>
<div class="col-md-2"></div>

</div>

<div id="painel" class="row" style="background: #737373;">
<div class="col-md-2"></div> 

<div class="col-md-8" style="text-align:center; padding-top: 20px; background-color:#CED4D6; font-family:Oswald; color:#270301;">
<table align="center" cellpadding="5">

<tr style="font-size: 15px;background: #820505;color: aliceblue;height: 33px;"> 
<td style="width: 250px; text-align: center; border: solid; border-color: #CED4D6;">Cliente</td>
<td style="width: 160px; text-align: center; border: solid; border-color: #CED4D6;">Cidade</td>
<td style="width: 80px; text-align: center; border: solid; border-color: #CED4D6;">Nota</td>
<td style="width: 90px; text-align: center; border: solid; border-color: #CED4D6;">Data</td>
<td style="width: 130px; text-align: center; border: solid; border-color: #CED4D6;">Total</td>




</tr>

';


if (count($result2) ) {
      
    foreach($result2 as $row) {
        
        extract($row);
       
                 do {  
                           echo '<tr class="success" style="background: #ABB7BB; font-size:14px;">';
                           echo'<td style="width: 250px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[0].'</td>';
                           echo '<td style="width: 160px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[1].'</td>';
                           echo '<td style="width: 80px; text-align: center; border: solid; border-color: #CED4D6;">'.$row[2].'</td>';
                           echo '<td style="width: 90px; text-align: center; border: solid; border-color: #CED4D6;">'.date("d/m/Y", strtotime($row[3])).'</td>';
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #CED4D6;">R$ '.number_format($row[4], 2, ',', '.').'</td>';
                          
       
       } while ($row= null);
      echo "</tr>"; 
    
      
   
   
    }  
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;
   
  }

    echo '</table>';
      
      echo '<table align="center" cellpadding="5" style="margin-top: 8px;">';
  
   if (count($result_TOTAL) ) {
      
    foreach($result_TOTAL as $row) {
        
        extract($row);
       
                 do {  
                           echo '<tr class="success" style="background: #BED1D6">';
                          
                          echo '<tr class="success" style="background: #820505; font-size:16px;color: aliceblue;height: 37px;">';
                           echo'<td style="width: 250px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: #CED4D6;background-color: #CED4D6;"></td>';
                           echo '<td style="width: 160px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: #CED4D6;background-color: #CED4D6;"></td>';
                            echo '<td style="width: 80px; text-align: center; border: solid; border-color: #CED4D6;border-right-color: #CED4D6;background-color: #CED4D6;"></td>';
                           echo '<td style="width: 90px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">Total</td>';
                           echo '<td style="width: 130px; text-align: center; border: solid; border-color: #074456;border-right-color: #CED4D6;">R$ '.number_format($row[1], 2, ',', '.').'</td>';
                       
      
       
       
       } while ($row= null);
      echo "</tr>"; 
    
      
   
   
    }  
  } else {
    echo "Nennhum resultado retornado.";
    echo $id;
   
  }
     
   echo '
</table>
</br>

</div>
<div class="col-md-2"></div> 
<div class="col-md-2"></div> 
</div>

';


}

 }   
  

       
       
       ?>
    
   
        
    </body>
</html>
