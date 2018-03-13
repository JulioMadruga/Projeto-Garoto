<?php

require_once '../Database/Conexao.php';

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Metas Garoto</title>
        <style type="text/css">table,th, td {
   border-collapse: collapse;  padding: 3px;
}  </style>
           </script>
         <script src="../js/calc_total.js"></script>
    </head>
    <body>
      <?php
 
   date_default_timezone_set('America/Cuiaba'); 

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

      $mes_meta2= array(
          'meta1' => 'Janeiro',
          'meta2' => 'Fevereiro',
          'meta3' => 'Marco',
          'meta4' => 'Abril',
          'meta5' => 'Maio',
          'meta6' => 'Junho',
          'meta7' => 'Julho',
          'meta8' => 'Agosto',
          'meta9' => 'Setembro',
          'meta10' => 'Outubro',
          'meta11' => 'Novembro',
          'meta12' => 'Dezembro',
          ''    => ''
      );


      $mes = $mes_extenso["$mes"];
      $meta = $mes_meta["$mes"];
      $date = date('Ymd' );

      if (isset($_POST['enviar'])){
          $vendedor = $_POST['select_ved'];
          if($vendedor == ''){
              $vendedor = $usuario->getRca();
          }
          $id = $vendedor;
          $data = $_POST['select_mes'];
          $mes = $mes_meta2["$data"];
          $data2 = $_POST['select_mes'];
          $meta = $data ;


          $conn->exec("set names utf8");
          $consulta_ved = $conn->prepare("SELECT nome FROM usuarios where rca = $vendedor ");
          $consulta_ved-> execute();
          $result2= $consulta_ved->fetchAll();
          $id2 = $result2[0][0];

      }else{
          $vendedor=$usuario->getRca();
          $id2 = $usuario->getNome();
          $id = $vendedor;


//$mes = $mes_extenso["$mes"];
//$meta = $mes_meta["$mes"];


      }
if ($vendedor == "" or $mes == "" ){
   
 echo "<script>alert('Selecione um Vendedor e um Mês!!!')</script>";
return die;
  
 }



      $serenata = "'12281004', '11322432'";
      $candybar = "'11320183', '12214154'";
      $talento_mini = "'11320198', '11320209','11320197','11320199','12277350','11324001'";
      $talento = "'12312312','12311892','12285127','12239753','12282740','12312330'";
      $baton = "'11320331', '11320367','12155337','12273955','12313896'";
      $cobkg = "'11320308', '11320309','11320339','11321851'";
      $cob500g = "'11320349', '11320350','11320351'";
      $cob2kg = "'12144488', '12144489','12144515','12144708'";
      $pastilha = "'11322004'";
      $batontab = "'11322130','11322131'";
      $tabletes = "'12260896', '12285329','12285325','12285279','12285326','12285324','12285327','12285328','12282660','12327173','12330984','12330985','12330987','12330988','12330819','12330995','12330986','12331542'";
      $sortido = "'12280901'";


      $consulta_serenata = $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2)))))as Realizado,
if((b.Serenta_amor)is null,(select Serenta_amor from $meta where rca = :id),(b.Serenta_amor)) as meta,
if((if( (b.Serenta_amor - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2))))is null,0,(b.Serenta_amor - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2))))))is null,0,
(if( (b.Serenta_amor - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2))))is null,(select Serenta_amor from $meta where rca = :id),(b.Serenta_amor - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/10 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($serenata)and b.rca = :id");
      $consulta_serenata ->execute(array('id' => $id));
      $result_serenata = $consulta_serenata ->fetchAll();

      $consulta_candybar = $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2)))))as Realizado,
if((b.CandyBar)is null,(select CandyBar from $meta where rca = :id),(b.CandyBar)) as meta,
if((if( (b.CandyBar - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,0,(b.CandyBar - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))))is null,0,
(if( (b.CandyBar - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,(select CandyBar from $meta where rca = :id),(b.CandyBar - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($candybar)and b.rca = :id");
      $consulta_candybar->execute(array('id' => $id));
      $result_candybar = $consulta_candybar->fetchAll();

      $consulta_talentomini = $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2)))))as Realizado,
if((b.Talento_mini)is null,(select Talento_mini from $meta where rca = :id),(b.Talento_mini)) as meta,
if((if( (b.Talento_mini - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2))))is null,0,(b.Talento_mini - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2))))))is null,0,
(if( (b.Talento_mini - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2))))is null,(select Talento_mini from $meta where rca = :id),(b.Talento_mini - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/18 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($talento_mini)and b.rca = :id");
      $consulta_talentomini ->execute(array('id' => $id));
      $result_talentomini = $consulta_talentomini ->fetchAll();

      $consulta_talento= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2)))))as Realizado,
if((b.Talento)is null,(select Talento from $meta where rca = :id),(b.Talento)) as meta,
if((if( (b.Talento - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,0,(b.Talento - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))))is null,0,
(if( (b.Talento - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))is null,(select Talento from $meta where rca = :id),(b.Talento - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/8 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($talento)and b.rca = :id");
      $consulta_talento->execute(array('id' => $id));
      $result_talento = $consulta_talento ->fetchAll();

      $consulta_baton= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2)))))as Realizado,
if((b.Baton)is null,(select Baton from $meta where rca = :id),(b.Baton)) as meta,
if((if( (b.Baton - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2))))is null,0,(b.Baton - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2))))))is null,0,
(if( (b.Baton - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2))))is null,(select Baton from $meta where rca = :id),(b.Baton - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/32 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($baton)and b.rca = :id");
      $consulta_baton->execute(array('id' => $id));
      $result_baton = $consulta_baton ->fetchAll();

      $consulta_cob1kg= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2)))))as Realizado,
if((b.Cobertura_kg)is null,(select Cobertura_kg from $meta where rca = :id),(b.Cobertura_kg)) as meta,
if((if( (b.Cobertura_kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2))))is null,0,(b.Cobertura_kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2))))))is null,0,
(if( (b.Cobertura_kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2))))is null,(select Cobertura_kg from $meta where rca = :id),(b.Cobertura_kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/12 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($cobkg)and b.rca = :id");
      $consulta_cob1kg->execute(array('id' => $id));
      $result_cob1kg = $consulta_cob1kg ->fetchAll();

      $consulta_cob500g= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2)))))as Realizado,
if((b.Cobertura_500g)is null,(select Cobertura_500g from $meta where rca = :id),(b.Cobertura_500g)) as meta,
if((if( (b.Cobertura_500g - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2))))is null,0,(b.Cobertura_500g - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2))))))is null,0,
(if( (b.Cobertura_500g - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2))))is null,(select Cobertura_500g from $meta where rca = :id),(b.Cobertura_500g - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/20 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($cob500g)and b.rca = :id");
      $consulta_cob500g->execute(array('id' => $id));
      $result_cob500g = $consulta_cob500g ->fetchAll();

      $consulta_cob2kg= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2)))))as Realizado,
if((b.Cobertura_2kg)is null,(select Cobertura_2kg from $meta where rca = :id),(b.Cobertura_2kg)) as meta,
if((if( (b.Cobertura_2kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2))))is null,0,(b.Cobertura_2kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2))))))is null,0,
(if( (b.Cobertura_2kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2))))is null,(select Cobertura_2kg from $meta where rca = :id),(b.Cobertura_2kg - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/5 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($cob2kg)and b.rca = :id");
      $consulta_cob2kg->execute(array('id' => $id));
      $result_cob2kg = $consulta_cob2kg ->fetchAll();

      $consulta_pastilha= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2)))))as Realizado,
if((b.Pastilha)is null,(select Pastilha from $meta where rca = :id),(b.Pastilha)) as meta,
if((if( (b.Pastilha - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2))))is null,0,(b.Pastilha - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2))))))is null,0,
(if( (b.Pastilha - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2))))is null,(select Pastilha from $meta where rca = :id),(b.Pastilha - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/24 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($pastilha)and b.rca = :id");
      $consulta_pastilha->execute(array('id' => $id));
      $result_pastilha= $consulta_pastilha ->fetchAll();

      $consulta_batonTab= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2)))))as Realizado,
if((b.Pastilha)is null,(select Baton_tab from $meta where rca = :id),(b.Pastilha)) as meta,
if((if( (b.Baton_tab - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2))))is null,0,(b.Baton_tab - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2))))))is null,0,
(if( (b.Baton_tab - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2))))is null,(select Baton_tab from $meta where rca = :id),(b.Baton_tab- sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/6 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($batontab)and b.rca = :id");
      $consulta_batonTab->execute(array('id' => $id));
      $result_batonTab= $consulta_batonTab ->fetchAll();

      $consulta_tabletes= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2)))))as Realizado,
if((b.Pastilha)is null,(select Tabletes from $meta where rca = :id),(b.Pastilha)) as meta,
if((if( (b.Tabletes - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2))))is null,0,(b.Tabletes - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2))))))is null,0,
(if( (b.Tabletes - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2))))is null,(select Tabletes from $meta where rca = :id),(b.Tabletes - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/56 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($tabletes)and b.rca = :id");
      $consulta_tabletes->execute(array('id' => $id));
      $result_tabletes= $consulta_tabletes ->fetchAll();

      $consulta_sortido= $conn->prepare("SELECT If((sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2))))is null,0,(sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2)))))as Realizado,
if((b.Pastilha)is null,(select Sortido from $meta where rca = :id),(b.Pastilha)) as meta,
if((if( (b.Sortido - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2))))is null,0,(b.Sortido - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2))))))is null,0,
(if( (b.Sortido - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2))))is null,(select Sortido from $meta where rca = :id),(b.Sortido - sum(cast(replace(replace(a.Quantidade, '.', ''), ',', '.')/30 as decimal(10,2))))))) as dif 
FROM $mes a, $meta b WHERE a.VENDEDOR = :id and a.Material in ($sortido)and b.rca = :id");
      $consulta_sortido->execute(array('id' => $id));
      $result_sortido= $consulta_sortido ->fetchAll();

      $consulta_kg= $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))) as kg, cast((b.kg) as decimal(10,2)) as meta, 
if(cast((b.kg - sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))))as decimal(10,2))<0,0,cast((b.kg - sum(cast(replace(replace(a.Liquido, '.', ''), ',', '.') as decimal(10,2))))as decimal(10,2))) as dif 
 FROM $mes a, $meta b where a.VENDEDOR = :id and b.rca = :id");
      $consulta_kg->execute(array('id' => $id));
      $result_kg= $consulta_kg ->fetchAll();

      $consulta_valor= $conn->prepare("SELECT a.VENDEDOR, sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))) as Tot, cast((b.valor) as decimal(10,2)) as meta,
  if(cast((b.valor - sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))))as decimal(10,2))<0,0,cast((b.valor - sum(cast(replace(replace(a.Valor_total, '.', ''), ',', '.') as decimal(10,2))))as decimal(10,2))) as dif 
  FROM $mes a, $meta b where a.VENDEDOR = :id and b.rca = :id");
      $consulta_valor->execute(array('id' => $id));
      $result_valor= $consulta_valor ->fetchAll();

      $consulta_tri= $conn->prepare("select vendedor,trimarca, Count(nome_parceiro)as reali, if(trimarca - Count(nome_parceiro)<0,0,trimarca - Count(nome_parceiro)) as dif from
(Select vendedor,nome_parceiro, sum(baton)as baton, sum(talento) as talento, trimarca from (SELECT a.vendedor,a.nome_parceiro, a.quantidade, a.material in('11320331', '11320367','12155337','12273955') as Baton, a.material in('11320198', '11320209','11320197','11320199','12277350','11324001') as Talento, b.Rca as vend, b.trimarca FROM $mes a, $meta b where a.material in ('11320331', '11320367','12155337','12273955','11320198', '11320209','11320197','11320199','12277350','11324001') 
 and a.quantidade>0 and a.vendedor= b.Rca) sub group by nome_parceiro)sub where baton>0 and talento>0 and vendedor = :id");
      $consulta_tri->execute(array('id' => $id));
      $result_tri= $consulta_tri ->fetchAll();


      $consulta_tri2= $conn->prepare("select vendedor, trimarca, meta_baton, tab from $meta where rca = :id");
      $consulta_tri2->execute(array('id' => $id));
      $result_tri2= $consulta_tri2->fetchAll();
     // var_dump($result_tri2);

      $consulta_positbaton= $conn->prepare("SELECT VENDEDOR, meta_baton, COUNT(NOME_parceiro) as realizado, if(meta_baton - COUNT(NOME_parceiro)<0,0,meta_baton - COUNT(NOME_parceiro)) as dif FROM 
(SELECT a.VENDEDOR, a.NOME_PARCEIRO, b.Rca as vend, b.meta_baton FROM $mes a, $meta b where a.MATERIAL IN ('11320331', '11320367','12155337','12273955','12248827','12248828','12281347') 
AND a.QUANTIDADE>0 and a.vendedor = b.Rca group by a.nome_parceiro)SUB where vendedor = :id");
      $consulta_positbaton->execute(array('id' => $id));
      $result_bat= $consulta_positbaton ->fetchAll();

      $consulta_jumbo= $conn->prepare("SELECT VENDEDOR, tab, COUNT(NOME_parceiro) as realizado, if(tab - COUNT(NOME_parceiro)<0,0,tab - COUNT(NOME_parceiro)) as dif FROM
 (SELECT a.VENDEDOR, a.NOME_PARCEIRO, b.Rca as vend, b.tab FROM $mes a, $meta b where a.MATERIAL IN ('12260896', '12285329','12285325','12285279','12285326','12285324','12285327','12285328','12282660','12327173','12330984','12330985','12330987','12330988','12330819','12330995','12330986','12331542')
 AND a.QUANTIDADE>0 and a.vendedor = b.Rca group by a.nome_parceiro)SUB where vendedor = :id");
      $consulta_jumbo->execute(array('id' => $id));
      $result_jumbo= $consulta_jumbo ->fetchAll();


      ?>


        <div class="row">
       <div class="col-md-2"></div> 
       <div class="col-md-6" style="background-color: aliceblue; padding-top:70px; height: 680px;">


           <table align="center" cellpadding="5"> 
           <tr style="background-color: #074456; color: #90ADB5; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 600px; text-align: center; font-size: 25px;">Resultados do Vendedor:<span style="color: #E4F3F7;"> <?php echo $id2; ?>&nbsp</span> |<span style="color: #E4F3F7;"> Mês:&nbsp <?php  echo $mes; ?></span> </td>
           </tr>
           </table>
           <div class="col-md-12" style="height: 7px; "></div>
           <table align="center" cellpadding="5" style="border: solid;" > 
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold" > 
      
          <td style="width: 300px; text-align: center;border: solid; border-color: #245269;">Produtos</td>
          
          <td style="width: 100px; text-align: center;border: solid; border-color: #245269;"> Meta Quant.CX</td>
      
          <td style="width: 100px;text-align: center;border: solid; border-color: #245269;" >Realizado Quant. CX </td>    
          
          <td style="width: 100px; text-align: center;border: solid; border-color: #245269;">A Realizar Quant. CX </td>  
      
          
      </tr>   
   
      
  <?php  
 
  //============================== Serenata ==========================
  
    //var_dump($result);
  
  if (count($result_serenata) ) {
      
    foreach($result_serenata as $row) {
        
        extract($row);
       // var_dump($row);
                 do {  
       echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Serenata de Amor</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Serenata de Amor</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }


 //============================== CandyBar ==========================
  
  
  if (count($result_candybar) ) {
      
    foreach($result_candybar as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Candy Bar</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Candy Bar</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  //============================== Talento mini ==========================
  
  
  if (count($result_talentomini) ) {
      
    foreach($result_talentomini as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
        echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Talento 25g</td>";
      if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Talento 25g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  
  //============================== Talento ==========================
  
  
  if (count($result_talento) ) {
      
    foreach($result_talento as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Talento 100g</td>";
      if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Talento 100g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
   echo "</tr>";
  }
  
  
  
  //============================== Baton ==========================
  
  
  if (count($result_baton) ) {
      
    foreach($result_baton as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Baton 16g</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
      
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Baton 16g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }  
  //============================== Cobertura 1kg ==========================
  
  
  if (count($result_cob1kg) ) {
      
    foreach($result_cob1kg as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 1kg</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 1kg</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  //============================== Cobertura 500g ==========================
  
  
  if (count($result_cob500g) ) {
      
    foreach($result_cob500g as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
        echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 500g</td>";
        if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 500g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  //============================== Cobertura 2,1g ==========================
  
  
  if (count($result_cob2kg) ) {
      
    foreach($result_cob2kg as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 2,1kg</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Cobertura 2,1kg</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "</tr>";
   
  }
  
   //============================== Pastilha ==========================
  
  
  if (count($result_pastilha) ) {
      
    foreach($result_pastilha as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
        echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Pastilha</td>";
       if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Pastilha</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  
    //============================== Baton 76g ==========================
  
  
  if (count($result_batonTab) ) {
      
    foreach($result_batonTab as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Baton 76g</td>";
        if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Baton 76g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
     //============================== Tabletes 125g ==========================
  
  
  if (count($result_tabletes) ) {
      
    foreach($result_tabletes as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
        echo "<tr class='success' style='background: #BED1D6'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Tabletes 125g</td>";
        if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
    echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Tabletes 150g</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "</tr>";
   
  }
  
  
     //============================== Sortido ==========================
  
  
  if (count($result_sortido) ) {
      
    foreach($result_sortido as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success'>";
       echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Bombom Sortido</td>";
        if ($row[2]<0){
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269; color:white; font-weight: bold; background:#4A8C13';>Realizado</td>"; 
              
       }else{
       
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[0]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>"; 
              
       
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
     echo "<td style='width: 300px; text-align: center; font-weight: bold; border: solid; border-color: #245269;'>Bombom Sortido</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  
  //============================== kg ==========================
  
  
  if (count($result_kg) ) {
      
    foreach($result_kg as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); font-size: 16px; color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 300px; text-align: center; font-weight: bold;'>Total em KG</td>";
       if ($row[1]==null){
           echo "<td id='kg_total' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td id='kg_realizado' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
              
       }else{
       
       echo "<td id='kg_total' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[2], 2, ',', '.')."</td>";
       echo "<td id='kg_realizado'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[1], 2, ',', '.')."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[3], 2, ',', '.')."</td>";
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
   echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); font-size: 16px; color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 300px; text-align: center; font-weight: bold;'>Total em KG</td>";
       echo "<td id='kg_total' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td id='kg_realizado'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
 
  //============================== R$ ==========================
  
  
  if (count($result_valor) ) {
      
    foreach($result_valor as $row) {
        
        extract($row);
    //var_dump($row);
                 do {  
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); font-size: 17px; color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 300px; text-align: center; font-weight: bold;'>Total em Valor</td>";
       if ($row[1]==null){
           echo "<td id='valor'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td id='valor_realizado'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
              
       }else{
       
       echo "<td id='valor'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[2], 2, ',', '.')."</td>";
       echo "<td id='valor_realizado'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[1], 2, ',', '.')."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>". number_format($row[3], 2, ',', '.')."</td>";
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
      echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); font-size: 17px; color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 300px; text-align: center; font-weight: bold;'>Total em Valor</td>";
       echo "<td id='valor'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td id='valor_realizado'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  echo '</table>';
  
  echo '</div>';
 
 
 ?>
  
   <div class="col-md-2" Style="background: aliceblue; height: 680px;">
       <div class="col-md-12" style="height: 10px; "></div> 
       <table align="center" cellpadding="5">
           
           <tr style="background-color: #A3DA75; color: #245269; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 600px; text-align: center; font-size: 25px;">Bi-Marca </td>
           </tr>
       </table>
       
    <div class="col-md-12" style="height: 10px; "></div> 
    <table align="center" cellpadding="5" style="border: solid;">
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold">
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Meta</td>
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Realizado </td>
               <td style="text-align: center;border: solid; font-size: 12px; border-color: #245269;">A Realizar</td>
           </tr>
           
      <?php
      if (count($result_tri) ) {
      
    foreach($result_tri as $row) {
        
        extract($row);
    
                 do {  
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
      
       if ($row[0]==null){
           echo "<td id='tri' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][1]."</td>";
           echo "<td id='tri_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][1]."</td>";
              
       }else{
       
       echo "<td id='tri'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td id='tri_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[3]."</td>";
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
      
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }?>
  
           <table  align="center" cellpadding="5">
               <tr><td colspan="3"></td></tr>
           
           <tr style="background-color: #EF3630; color: #ffffff; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 600px; text-align: center; font-size: 25px;"> Posit. Baton </td>
           </tr>
       </table>
       
    <div class="col-md-12" style="height: 10px; "></div> 
    <table align="center" cellpadding="5" style="border: solid;">
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold">
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Meta</td>
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Realizado </td>
               <td style="text-align: center;border: solid; font-size: 12px; border-color: #245269;">A Realizar</td>
           </tr>
           
      <?php
      if (count($result_bat) ) {
      
    foreach($result_bat as $row) {
        
        extract($row);
    
                 do {  
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
      
       if ($row[0]==null){
           echo "<td id='baton' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][2]."</td>";
           echo "<td id='baton_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][2]."</td>";
              
       }else{
       
       echo "<td id='baton'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td id='baton_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[3]."</td>";
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
      
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  
  ?>
  
           <table  align="center" cellpadding="5">
               <tr><td colspan="3"></td></tr>
           
           <tr style="background-color: #F0AD4E; color: #ffffff; font-weight: bold; font-family:Dosis; " >
               <td colspan="4" style="width: 600px; text-align: center; font-size: 25px;"> Posit. Jumbos </td>
           </tr>
       </table>
       
    <div class="col-md-12" style="height: 10px; "></div> 
    <table align="center" cellpadding="5" style="border: solid;">
           <tr style="background-color: #1b6d85; color: #ffffff; font-weight: bold">
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Meta</td>
               <td style="text-align: center;border: solid; font-size: 12px;  border-color: #245269;">Realizado </td>
               <td style="text-align: center;border: solid; font-size: 12px; border-color: #245269;">A Realizar</td>
           </tr>
           
      <?php
      if (count($result_jumbo) ) {
      
    foreach($result_jumbo as $row) {
        
        extract($row);
    
                 do {  
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
      
       if ($row[0]==null){
           echo "<td id='jumbo' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][3]."</td>";
           echo "<td id='jumbo_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
           echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$result_tri2[0][3]."</td>";
              
       }else{
       
       echo "<td id='jumbo'style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[1]."</td>";
       echo "<td id='jumbo_result' style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[2]."</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>".$row[3]."</td>";
       }
       
       } while ($row= null);
      echo "</tr>"; 
   
    }  
  } else {
      
       echo "<tr class='success' style='background-color: rgba(141, 202, 220, 0.77); color: #0D1B05; font-weight: bold; border: solid; border-color: #245269;'> ";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>";
       echo "<td style='width: 100px; text-align: center; border: solid; border-color: #245269;'>0</td>"; 
       echo "</tr>";
   
  }
  
  
  
      
      
      ?>
           
        
            
           
       </table>
    <div style="background: #0C4F63;margin-top: 10px;padding: 10px;">
    <table style="margin-top: 7px;">
        <tr>
            <td style="color:#66afe9;  font-weight: bold;">Bi-Marca</td>
        </tr>
        
    </table>
    
    <div class="progress" style="margin-top: 1px;">
  <div id="graftri" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%; font-size: 12px;">
    </div>
    </div> 
        
    <table style="margin-top: 20px;">
        <tr>
            <td style="color:#EF3630;  font-weight: bold;">Baton</td>
        </tr>
        
    </table>
    
    <div class="progress" style="margin-top: 1px;">
  <div id="grafbaton" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%; font-size: 12px;">
    </div>
    </div> 
      
    
    <table style="margin-top: 20px;">
        <tr>
            <td style="color:#c0a16b; font-weight: bold;">Jumbos</td>
        </tr>
        
    </table>
    <div class="progress" style="margin-top: 1px; ">
  <div id="grafjumbo" class="progress-bar progress-bar-warning  progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%; font-size: 12px;">
    </div>
    </div> 
    
    
    <table style="margin-top: 20px;">
        <tr>
            <td style="color:#67b168; font-weight: bold;">Total R$</td>
        </tr>
        
    </table>
    <div class="progress" style="margin-top: 1px;">
  <div id="grafvalor" class="progress-bar progress-bar-success  progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%; font-size: 12px;">
    </div>
    </div> 
    </div>
    
               
   </div>
      
      <script>tri(); bat(); kg(); valor();</script>
 <div class="col-md-2"></div>
  </div>


    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <?php


    if (isset($_GET['cad']) == 'false'){


        echo ("<script> $('#exampleModal').modal('show'); alert('Senha não coincide, Digite Novamente')</script>"); die;

    }

    ?>

    <script>



        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
           // modal.find('.modal-title').text('New message to ' + recipient)
           // modal.find('.modal-body input').val(recipient)
        })

    </script>




</html>
