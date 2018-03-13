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


$quantvend= $conn->prepare("SELECT count(nome) FROM usuarios where tipo = 'logar' ");
 $quantvend->execute();
 $result_vend= $quantvend ->fetchAll();
 
 $vend = $result_vend[0][0];
  
 

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Metas</title>
              
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
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
     
     <script>
        function fechar(){
     document.getElementById('popup').style.display = 'none';
   }

   function abrir(){
     document.getElementById('popup').style.display = 'block';
     setTimeout ("fechar()", 50000);
   }

  </script>
  <style type="text/css">
  #popup{
  position: fixed;
  top: 15%;
  left: 30%;
  margin: -75px 0 0 -150px;
  width: 620px;
  height: 450px;
  padding: 20px;
  border: solid 1px #331;
  background: rgb(206, 212, 214);
  color: #2D6171;
  display: none;
  font-size: 16px;
  }
  </style>
     
     <script>   // aqui eh a base da pagina
window.onload = function(){
    document.getElementById('mes').onchange = function(){
        window.location = '?mes=' + this.value;
    }
}

$(document).ready( function(){

$("tr:even").css("background","#CED4D6");
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
    <body>
         <div id="nav" class="col-lg-12"  style="background: #121415;">
             <ul class="nav">
                 <li role="presentation"><a href="index.php">Parcial</a></li>
                 <li role="presentation"><a href="resumo.php">Resumo de vendas</a></li>
                 <li role="presentation"><a href="vendasflex.php">Venda Transmitida</a></li>
                 <li role="presentation"  ><a href="metas.php">Metas</a></li>
                 <li class="button-dropdown"><a href="javascript:void(0)" class="dropdown-toggle">  Positivações  <span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li><a href="trimarca.php">Bi-Marca</a></li>
                         <li><a href="baton.php">Baton</a></li>
                         <li><a href="jumbos.php">Jumbos</a></li>
                         <li><a href="ativoxpositivado.php">Cliente Ativos X Positivados</a></li>

                     </ul>

                 </li>
                 <li role="presentation" ><a href="acessos.php">Relat. de Acessos</a></li>
                 <li class="button-dropdown" ><a href="javascript:void(0)" class="dropdown-toggle"> Cadastros <span>▼</span>  </a>
                     <ul class="dropdown-menu">
                         <li role="presentation" id="active"><a href="#">Cadastrar Metas</a></li>
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
        <div class="row" style="margin-top: 0px;">
        <div class="col-md-0"></div>  
        <div class="col-md-12" style="height: 70px; text-align:center; background-color:#0C4F63; font-family:Oswald; color:#F2FAFD;"> <h2>Cadastrar Metas</h2></div>
               <div class="col-md-0"></div>  
        </div>
        <div class="row"
                      
        
               <div class="col-md-0"></div>  
            
            <div class="col-md-12"  id="form" style="background-color:#737373; font-size:11px;  color:#0D3744;">


                
                <form action="atualizar.php" method="post" name="form[]" oninput="calc_kg(<?php echo $vend; ?>);" >
                    <div class="form-group">
                      <table align="center" cellpadding="5" style="border: solid;" >
           <tr style="background-color: #2D6171; color: #ffffff; font-weight: bold" > 
               
          <td style="width: 50px; text-align: center;border: solid; border-color: #737373;">Exluir</td>
      
          <td style="width: 180px; text-align: center;border: solid; border-color: #737373;">Vendedor</td>
          
          <td style="width: 100px; text-align: center;border: solid; border-color: #737373;"> Serenata de Amor</td>
      
          <td style="width: 100px;text-align: center;border: solid; border-color: #737373;" >CandyBar</td>    
          
          <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Talento 25g </td>  
          
          <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Talento 100g </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Baton 16g </td>
          
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Cobertura de 1kg </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Cobertura de 500g </td>  
          
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Cobertura de 2,1kg </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Pastilha</td>  
          
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Baton 76g </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373">Tabletes 150g </td>  
          
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Sortido 300g </td>
                      
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">kg </td>  
          
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Valor </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Bi-Marca</td>  
          
          <!-- <td style="width: 100px; text-align: center;border: solid; border-color: #245269;">Trimarca Result </td> -->
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Meta Baton </td>
           
           <td style="width: 100px; text-align: center;border: solid; border-color: #737373;">Jumbos </td>
           
          
      
          
      </tr>    

            <?php 
     date_default_timezone_set('America/Cuiaba');         
  $data = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
    
    $mes_extenso = array(
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
           

$meta = $mes_extenso["$mes"];

if (isset($_GET['mes'])){
    $meta = $_GET['mes'];
}

 

 //---------------------------------------------------------------------------------------------------------------------         
   
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
          
          
          
          

$consulta_meta= $conn->prepare("SELECT FORMAT(a.kg, 0,'de_DE') as kg, FORMAT(a.valor, 2,'de_DE') as valor , a.*, b.regiao FROM $meta a, usuarios b WHERE  a.vendedor = b.nome and b.tipo= 'logar' order by vendedor");
 $consulta_meta->execute();
 $result_meta= $consulta_meta ->fetchAll();
     
 //var_dump($result_meta);

if (count($result_meta) ) {
        $i=0;
    foreach($result_meta as $row) {
        
        extract($row);
      echo "<tr class='success' style='background: #BDBBBB'>";
    
         do {  
       echo "<td style='width: 50px; text-align: center; font-weight: bold; border: solid; border-color: #737373'><input type='checkbox' name='excluir[]' value='".$row[2]."'></td>";

        if ($row[22] == "Sul")  {

            echo "<td style='width: 180px; text-align: center; font-weight: bold; border: solid; border-color: #737373; background: #64bda5;'>".$row[2]."</td>";

        }  else {

            echo "<td style='width: 180px; text-align: center; font-weight: bold; border: solid; border-color: #737373;'>" . $row[2] . "</td>";
        }

       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0) ' id='serenata".$i."'name='serenata[]' type='text' size='9' value='".$row[4]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='candybar".$i."'name='candybar[]' type='text' size='10' value='".$row[5]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='talento_mini".$i."'name='talento_mini[]' type='text' size='8' value='".$row[6]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='talento".$i."'name='talento[]' type='text' size='8' value='".$row[7]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='baton".$i."'name='baton[]' type='text' size='8' value='".$row[8]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='cobertura_kg".$i."'name='cobertura_kg[]' type='text' size='7' value='".$row[9]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='cobertura_500g".$i."'name='cobertura_500g[]' type='text' size='7' value='".$row[10]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='cobertura_2kg".$i."'name='cobertura_2kg[]' type='text' size='7' value='".$row[11]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='pastilha".$i."'name='pastilha[]' type='text' size='4' value='".$row[12]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='baton_tab".$i."'name='baton_tab[]' type='text' size='6' value='".$row[13]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='tabletes".$i."'name='tabletes[]' type='text' size='5' value='".$row[14]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='sortido".$i."'name='sortido[]' type='text' size='4' value='".$row[15]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='kg".$i."'name='kg[]' type='text' size='7' value='".$row[0]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; border-color: #737373;'><input style='text-align: center; border: none; background-color: rgba(0,0,0,0)' id='valor".$i."'name='valor[]' type='text' size='7' value='".$row[1]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; background-color: #5cb85c; border-color: #737373;'><input style='background-color: #5cb85c; color:#ffffff; text-align: center; border: none; ' id='trimarca".$i."' name='trimarca[]' type='text' size='6' value='".$row[18]."'/></td>";
      // echo "<td style='width: 50px; text-align: center; border: solid; border-color: #245269;'><input name='result_tri[]' type='text' size='6' value='".$row[18]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; background-color: #960F0B;border-color: #737373;'><input style='background-color: #960F0B; color:#ffffff; text-align: center; border: none; ' id='meta_baton".$i."' name='meta_baton[]".$i."' type='text' size='6' value='".$row[20]."'/></td>";
       echo "<td style='width: 50px; text-align: center; border: solid; background-color: #0F9FCA;border-color: #737373;'><input style='background-color: #0F9FCA; color:#ffffff; text-align: center; border: none; ' id='jumbo".$i."' name='jumbo[]".$i."' type='text' size='6' value='".$row[21]."'/></td>";
      
      
       
       $i++;
      
       } while ($row=null);
      echo "</tr>"; 
      
              
        
       // echo "<input type='text' value='$row[0]'/> </br>"; 
        
         
        
                
    }  
  } else {
      
       echo "erro!!";
       
   
  }


      
     
    echo '<div style =" background:#8C8B8B; padding:10px">';

      echo '<fieldset>'; 
      echo "<label  style='font-size: 15px;  font-weight: bold; '>&nbsp&nbsp&nbsp&nbspSelecionar Mês:&nbsp&nbsp&nbsp&nbsp&nbsp</label>";
      echo "<select id='mes' name='mes'style='height: 40px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 140px; font-size: 16px;text-align: center; font-weight: bold;' >"; 
       echo 'option value="">-   -    -   - Selecionar   -   -   -   -</option>';
      echo'<option value="meta1"'.$check0.'>Janeiro</option>   
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
      <option value="meta12"'.$check11.'>Dezembro</option>'; 
      echo '</select>'; 
      echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; 
      echo "<label style='font-size: 15px;'>Total em Kg:&nbsp</label><input style='border:none; height: 40px;width: 100px; font-size: 16px;text-align: center; background-color: #0C4F63;color: #ffffff;font-family: sans-serif;' id='total_kg' name='total_kg' type='text' size='7' value=''/>"  ;
      echo '&nbsp&nbsp&nbsp&nbsp&nbsp'; 
      echo "<label style='font-size: 15px;'>Total:&nbsp</label><input style='border:none; height: 40px;width: 130px; font-size: 16px;text-align: center; background-color: #0C4F63;color: #ffffff;font-family: sans-serif;' id='total_valor' name='total_valor' type='text' size='15' value=''/>"  ;
      echo "<input style='height: 40px;width: 80px; margin-right: 30px; float: right; font-size: 16px;'name='enviar' type='submit' class='btn-primary' value='Atualizar' />";
      
      
      echo '</fieldset>';  
          
      
      echo '</div>';
        ?>
            
      <div style =" background:#737373; padding-top:7px">   </div>


         <a style="margin-top: 5px" href="atualizarmes.php?mes=<?php $m = substr($meta,-1,3); $m2 = $m -1; echo 'meta'.$m2.'&now='.$meta; ?>" class="btn btn-success">Copiar Meta Mês Anterior</a>

        <a style="margin-top: 5px; margin-left: 8px;" href="javascript: abrir();"class="btn btn-info">Cadastrar Vendedor</a>

      <div style =" width: 570px; float: right; background:#D8DEE0; padding:5px; text-align: center">

      
     <label style="font-size: 12px;">Total Bi-Marca:&nbsp</label><input style="border:none; height: 30px;width: 45px; font-size: 13px;text-align: center; background-color: #5cb85c;color: #ffffff;font-family: sans-serif;" id="total_tri" name="total_tri" type="text" size="7" value=""/> 
     &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
     <label style="font-size: 12px;">Total Baton:&nbsp</label><input style="border:none; height: 30px;width: 45px; font-size: 13px;text-align: center; background-color: #960F0B;color: #ffffff;font-family: sans-serif;" id="total_baton" name="total_baton" type="text" size="7" value=""/>
      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
     <label style="font-size: 12px;">Total Jumbos:&nbsp</label><input style="border:none; height: 30px;width: 45px; font-size: 13px;text-align: center; background-color: #0F9FCA;color: #ffffff;font-family: sans-serif;" id="total_jumbo" name="total_Jumbo" type="text" size="7" value=""/>
      
          
     <script> calc_kg(<?php echo $vend ?>);</script>
          
          
      </div>
          
      <div style =" background:#737373; padding-top:15px">   </div>
          
      </table>
                 
                    </div>
      
            </form>
            </table> 
                    
     
     
      <div id="popup"> 
     
          <form action="vendedor.php" method="post" name="form" >
              
              
              <table>
                  <tr>
                      <td colspan="2" style="text-align: center">
                                                    <h2> Catrastrar Vendedor</h2>  
                      </td>
                  </tr>
                  
                  <tr>
                      <td colspan="2" style="text-align: center">
                                <?php
                                echo '<fieldset>'; 
      echo "<label  style='font-size: 14px;  font-weight: bold; '>&nbsp&nbsp&nbsp&nbspSelecionar Mês:&nbsp&nbsp&nbsp&nbsp&nbsp</label>";
      echo "<select id='mes' name='mes'style='height: 40px;  font-family: sans-serif; width: 200px; font-size: 14px;text-align: left; font-weight: bold;' >"; 
       echo 'option value="">-   -    -   - Selecionar   -   -   -   -</option>';
      echo'<option value="meta1"'.$check0.'>Janeiro</option>   
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
      <option value="meta12"'.$check11.'>Dezembro</option>'; 
      echo '</select>'; 
      
      echo '</fieldset>';  
                                
                                ?>
                      </td>
                  </tr>
                  
                   <tr>
                       <td style="width: 180px; height: 20px;"> </td>
                       <td>  </td>
                      
                  </tr>

                  <tr>
                      <td style="width: 180px">Rca do Vendedor:   </td>
                      <td> <input type="text" size="40" name="rca" value="" required/>   </td>

                  </tr>
                  <tr>
                      <td style="width: 180px; height: 20px;"> </td>
                      <td>  </td>

                  </tr>

                  <tr>
                       <td style="width: 180px">Nome do Vendedor:   </td>
                       <td> <input type="text" size="40" name="vendedor" value="" required/>   </td>
                      
                  </tr>  
                  <tr>
                       <td style="width: 180px; height: 20px;"> </td>
                       <td>  </td>
                      
                  </tr> 
                  
                  <tr>
                       <td style="width: 180px">Email:   </td>
                       <td> <input type="email" size="40" name="email" value="" required/>   </td>
                      
                  </tr>

                  <tr>
                      <td style="width: 180px; height: 20px;"> </td>
                      <td>  </td>

                  </tr>

                  <tr>


                      <td style=" height: 20px;">
                      <label style="font-size: 14px;  font-weight: bold; ">Selecionar Região:&nbsp&nbsp&nbsp</label>

                      </td>
                      <td style=" height: 20px;">

                          <select id="regiao"  name="regiao" style="height: 30px; background-color: #0C4F63;color: #ffffff; font-family: sans-serif; width: 200px; font-size: 18px;text-align: center; font-weight: bold;">

                              <option id="norte">Norte</option>
                              <option id="sul">Sul</option>

                          </select>

                      </td>

                  </tr>
                  
                  <tr style="height: 100px; width: 100px; text-align: center">
                      <td colspan="2">
                     <input style='height: 40px;width: 100px; font-size: 16px;'name='vend' type='submit' class='btn-primary' value='Cadastrar' /> 
                      </td>
                  </tr>
                     
                  
              </table>  
              
              
              
          </form>
          
           </DIV>
      
                </div> 
 <div class="col-md-0"></div>
        
       </div>

</body>
</html>
