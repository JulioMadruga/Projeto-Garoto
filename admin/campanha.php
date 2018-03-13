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
 
  
    $data = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
    
    $mes_meta = array(
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
 
 $meta = $mes_meta["$mes"];
 
 $mes = $mes_extenso["$mes"];
// var_dump($mes);
 
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



 $consulta_baton= $conn->prepare("select baton from trimarca");
 $consulta_baton->execute();
 $result_baton= $consulta_baton->fetchAll();

$consulta_talento= $conn->prepare("select talento from trimarca");
$consulta_talento->execute();
$result_talento= $consulta_talento->fetchAll();

$consulta_serenata= $conn->prepare("select serenata from trimarca");
$consulta_serenata->execute();
$result_serenata= $consulta_serenata->fetchAll();

$consulta_baton2= $conn->prepare("select baton2 from trimarca");
$consulta_baton2->execute();
$result_baton2= $consulta_baton2->fetchAll();

$consulta_jumbos= $conn->prepare("select jumbos from trimarca");
$consulta_jumbos->execute();
$result_jumbos= $consulta_jumbos->fetchAll();

 
  
 


?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel Administrador</title>
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
        <link rel="stylesheet" type="text/css" href="../css/print.css" media="print" />
        <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css.map">
    <link rel="stylesheet" href="../css/bootstrap.css.map">
        <link rel="stylesheet" href="../css/menu.css">
        <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/calc_total.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     
     <script>   // aqui eh a base da pagina



$(document).ready( function(){
$("#painel").hide(); 
$("#painel").slideDown(1500);  

$("tr:even").css("background","#97ACB3");


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
            <li role="presentation"><a href="acessos.php">Relat. de Acessos</a></li>
            <li class="button-dropdown" id="active" ><a href="javascript:void(0)" class="dropdown-toggle"> Cadastros <span>▼</span>  </a>
                <ul class="dropdown-menu">
                    <li role="presentation" ><a href="cadastrar.php">Cadastrar Metas</a></li>
                    <li role="presentation"  id="active"><a href="#">Cad. Campanhas</a></li>
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
     <div class="row" style="padding-top: 50px; background: #737373;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 60px; padding-top: 5px; "><img src="../images/disnorte.png" style="margin-top: 5px;"></div>
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 60px; padding-top: 5px; "><h4 style="margin-top: 18px;">SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 60px;  "><img src="../images/garoto.png" style="margin-top: 5px;"></div>
        <div class="col-md-2"></div>
        
       </div>     
        

    
<div class="row" style="background: #737373; height:30px;">
<div class="col-md-2"></div>

    <div class="col-md-8" style="background: #CED4D6; text-align: center;"><h2 style="background-color: #45595f; height: 30px; size: 18px; color: #FFFFFF; margin-top: 15px">Trimarca</h2>

        <div class="col-md-12" style="background: #CED4D6; text-align: center;">
            <form class="form-horizontal" action="atualizar2.php" method="post" name="form[]">
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="formGroupInputLarge">Baton</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="baton" placeholder="Digite codigos dos produtos" value="<?php echo $result_baton[0][0]; ?>">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="formGroupInputLarge">Talento</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="talento" placeholder="Digite codigos dos produtos" value="<?php echo $result_talento[0][0]; ?>">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for="formGroupInputLarge">Serenata</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="formGroupInputLarge" name="serenata" placeholder="Digite codigos dos produtos" value="<?php echo $result_serenata[0][0]; ?>">
                    </div>
                </div>

            </div>


        <div class="col-md-12" style="background: #CED4D6; text-align: center;"><h2 style="background-color: #d8252f; height: 30px; size: 18px; color: #FFFFFF; margin-top: 15px">Baton</h2>

                <div class="col-md-12" style="background: #CED4D6; text-align: center;">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="formGroupInputLarge">Baton</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="formGroupInputLarge" name="baton2" placeholder="Digite codigos dos produtos" value="<?php echo $result_baton2[0][0]; ?>">
                            </div>
                        </div>


                    </div>


            <div class="col-md-12" style="background: #CED4D6; text-align: center;"><h2 style="background-color: #f0ad4e; height: 30px; size: 18px; color: #FFFFFF; margin-top: 15px">Jumbos</h2>

                <div class="col-md-12" style="background: #CED4D6; text-align: center;">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="formGroupInputLarge">Jumbos</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="formGroupInputLarge" name="jumbos" placeholder="Digite codigos dos produtos" value="<?php echo $result_jumbos[0][0]; ?>" >
                            </div>
                        </div>

                        <div class="row" style="background: #CED4D6; height:30px; text-align: center">

                            <div class="col-md-12" style="margin-top: 30px"> <input type="submit" name="campanha" class='btn btn-default btn-lg' value="Cadastrar" style="text-align: center">  </div>

                            <div class="col-md-12" style="height: 40px"> </div>

                        </div>


                    </form></div>





</div>





       
       
       

        
        
        
    </body>
</html>
