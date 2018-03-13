<?php 
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'autenticador.php';

$aut = Autenticador::instanciar();

$usuario = null;
if ($aut->esta_logado()) {
    $usuario = $aut->pegar_usuario();
}
else {
    $aut->expulsar();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Acompanhamento de Metas</title>
        <style> .view{ background-color: #737373; } .styled-select select {
   width: 200px;
   height: 34px;
   overflow: hidden;
   border: 1px solid #ccc;
   }</style>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="css/bootstrap.css.map">
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>

    </head>
    <body class="view">
        <?php include 'header.php'; ?>
        
            <?php   include'metas.php ';    ?>
         
       <?php include 'footer.php'; ?>
    
    </body>

</html>