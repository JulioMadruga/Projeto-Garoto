<?php

$username = "root";
$password = ""; 

$conn = new PDO('mysql:host=localhost;dbname=xls', $username, $password); 
$consulta_ved = $conn->prepare("SELECT rca FROM usuarios where tipo = 'logar' order by nome");
 $consulta_ved-> execute();
 $result2= $consulta_ved->fetchAll();

     
       $i = 0;
    foreach($result2 as $row) {
        
        extract($row);
        
         $linha[$i] = "'$row[0]'";
		 
             
                       
        $i++;
      
       } 
      
       
           
 
          
          $meta = $_POST['mes'];
          $produtos = $_POST['serenata'];
          $candybar = $_POST['candybar'];
          $talentomini = $_POST['talento_mini'];
          $talento = $_POST['talento'];
          $baton = $_POST['baton'];
          $cobertura_kg = $_POST['cobertura_kg'];
          $cobertura_500g = $_POST['cobertura_500g'];
          $cobertura_2kg = $_POST['cobertura_2kg'];
          $pastilha = $_POST['pastilha'];
          $Baton_tab = $_POST['baton_tab'];
          $tabletes = $_POST['tabletes'];
          $sortido= $_POST['sortido'];
          $kg= $_POST['kg'];
          $valor= $_POST['valor'];
          $trimarca= $_POST['trimarca'];
          $meta_baton= $_POST['meta_baton'];
          $jumbo= $_POST['jumbo'];


$i=0;                  
foreach( $produtos AS $row) {
  // echo $produto.'<br />';
   //echo  $row;
   $up_serenata= $conn->prepare("update $meta set serenta_amor = $row where rca =". $linha["$i"]);
   $up_serenata->execute();
 
        $i++ ;
   
   
}

$i=0;
foreach( $candybar AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_candy= $conn->prepare("update $meta set CandyBar = $row where rca =". $linha["$i"]);
   $up_candy->execute();
   
   $i++ ;
      
}

$i=0;
foreach($talentomini AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_talentomini= $conn->prepare("update $meta set talento_mini = $row where rca =". $linha["$i"]);
   $up_talentomini->execute();
   $i++ ;
   
   
}

$i=0;
foreach($talento AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_talento= $conn->prepare("update $meta set talento = $row where rca =". $linha["$i"]);
   $up_talento->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $baton AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_baton= $conn->prepare("update $meta set baton = $row where rca =". $linha["$i"]);
   $up_baton->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $cobertura_kg AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_cobertura_kg= $conn->prepare("update $meta set cobertura_kg = $row where rca =". $linha["$i"]);
   $up_cobertura_kg->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $cobertura_500g AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_cobertura_500g= $conn->prepare("update $meta set cobertura_500g = $row where rca =". $linha["$i"]);
   $up_cobertura_500g->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $cobertura_2kg AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_cobertura_2kg= $conn->prepare("update $meta set cobertura_2kg = $row where rca =". $linha["$i"]);
   $up_cobertura_2kg->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $pastilha AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_pastilha= $conn->prepare("update $meta set pastilha = $row where rca =". $linha["$i"]);
   $up_pastilha->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $Baton_tab AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_baton_tab= $conn->prepare("update $meta set baton_tab = $row where rca =". $linha["$i"]);
   $up_baton_tab->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $tabletes AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_tabletes= $conn->prepare("update $meta set tabletes = $row where rca =". $linha["$i"]);
   $up_tabletes->execute();
   $i++ ;
   
   
}

$i=0;
foreach( $sortido AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_sortido= $conn->prepare("update $meta set sortido = $row where rca =". $linha["$i"]);
   //var_dump($up_sortido);
   $up_sortido->execute();
   $i++ ;
   
   
}
$i=0;
foreach($kg AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_kg= $conn->prepare("update $meta set kg = '".$row."' where rca =". $linha["$i"]);
   $up_kg->execute();
   
   $i++ ;
   
   
}

$i=0;
foreach($valor AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_valor= $conn->prepare("update $meta set valor ='".$row."' where rca =". $linha["$i"]);
   $up_valor->execute();
   
   $i++ ;
   
   
}

$i=0;
foreach($trimarca AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_trimarca= $conn->prepare("update $meta set trimarca = $row where rca =". $linha["$i"]);
   $up_trimarca->execute();
   
   $i++ ;
   
   
}



$i=0;
foreach($meta_baton AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_meta_baton= $conn->prepare("update $meta set meta_baton = $row where rca =". $linha["$i"]);
   $up_meta_baton->execute();
  
   
   $i++ ;
   
   
}

$i=0;
foreach($jumbo AS $row ) {
  // echo $produto.'<br />';
  // echo $i;
   $up_jumbo= $conn->prepare("update $meta set tab = $row where rca =". $linha["$i"]);
 
  $up_jumbo->execute();

   
   $i++ ;
   
   
}



if(isset($_POST['excluir'])){

$excluir = $_POST['excluir'];
foreach($excluir as $item){

   $Excluir_Vend= $conn->prepare("delete from $meta WHERE vendedor='$item'");
   $Excluir_Vend->execute();
   
   $Excluir_Vend2= $conn->prepare("delete from Usuarios WHERE nome='$item'and tipo = 'logar'");
   $Excluir_Vend2->execute();
    
   echo ("<script>alert('O Vendedor ".$item." foi Exluido');</script>"); 
    
//aqui o resto da query
}
echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cadastrar.php'>";
 die; 
}


echo ("<script>alert('Dados Atualizado com Sucesso!!!');window.history.go(-1);</script>"); die;
     
      
      
      ?>