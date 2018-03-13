<?php

$mobile = FALSE;
$user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");

foreach($user_agents as $user_agent){
    if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
        $mobile = TRUE;
        $modelo	= $user_agent;
        break;
    }
}


    if ($mobile){
    header('Location: mobile/index.php');
}





session_start();
session_destroy(); 
if (isset($_GET['login'])){

    if ($_GET['login'] == 'email'){
        echo "<script>alert('Seu email esta incorreto!!!')</script>";
    }else{

        echo "<script>alert('Sua senha esta incorreta!!!')</script>";

    }


    }






?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tela de Login</title>
    <style> .view{ background-color: #737373}</style>
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="css/bootstrap.css.map">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/npm.js"></script>
    <script src="js/calc_total.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     
        
    
</head>
<body  class="view">
    <div id="login" style="width: 600px; margin: 150px auto 0 auto;  background-color: rgb(41, 100, 128); color: aliceblue; text-align:center; padding: 10px 0px; font-family: sans-serif; font-size: 20px;">
    <img src="images/DISNORTE1.png"> </div>

    <form style="width: 600px; margin: 0 auto; background-color: #B3DCE4;"action="controle.php" method="post" target="_self" oninput="login()" >
        
        
        <div id="lab" style="padding:30px 40px 0px 40px; font-family: sans-serif; font-size: 16px;">
        
      <div class="input-group">
      <span class="input-group-addon">Email: @</span>
      <input type="email" class="form-control" id="inputGroupSuccess3" aria-describedby="inputGroupSuccess3Status" id="email" name="email" value="" placeholder="email@disnorteagil.com.br" required autocomplete="off">
    </div>     
        </div>  
     <!--<input class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" style="font-size: 16px;" type="text" id="email" name="email" value=""></div> -->
    
    <div id="lab" style="padding:15px 40px 10px 40px; font-family: sans-serif; font-size: 16px;">
      
      <div class="input-group">
      <span class="input-group-addon">Senha: <i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
      <input type="password" class="form-control" id="inputGroupSuccess3" aria-describedby="inputGroupSuccess3Status" id="senha" name="senha" value="" placeholder="*********"required>
    </div>  
    </div>  
       

      <!--<input style="font-size: 16px;" type="password" id="senha" name="senha" value=""></div>-->
        </br>
       <div class="input-group" style="width: 100%;">
       <button style="width: 300px; margin-left: auto; margin-right: auto; " class="btn btn-primary btn-lg btn-block" type="submit" id="acao" name="acao" value="logar">Entrar</button>
       </br>
    </div>  
        
     
    
        
</form>
    
</body>
</html>
