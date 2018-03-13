<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <script>
            function fechar(){
                document.getElementById('popup').style.display = 'none';

            }

            function abrir(){
                document.getElementById('popup').style.display = 'block';
               // setTimeout ("fechar()", 90000);
            }



        </script>
        <style type="text/css">
            #popup{
                z-index: 5;
                position: fixed;
                top: 15%;
                left: 50%;

                margin:-80px -400px -150px;
                width: 800px;
                height: 300px;
                padding: 20px;
                border: solid 1px #331;
                background: rgba(16, 13, 13, 0.94);
                color: #a8acad;
                display: none;
                font-size: 16px;
            }
            a.button {
                -webkit-appearance: button;
                -moz-appearance: button;
                appearance: button;

                text-decoration: none;
                color: initial;
            }
        </style>
        
     </head>
    <body>
        <div class="row">
             
           <div class="col-md-12" style="text-align: right; background-color:#000000; color: #ffffff; padding-top:3px; padding-bottom:3px;">
               <ul class="nav nav-pills" style="padding-left: 10px; padding-right: 10px;">
          
  <li role="presentation" class="active"><a href="#">Metas</a></li>
  <li role="presentation"><a href="vendas.php">Vendas no mês</a></li>
  <li role="presentation"><a href="baton.php">Post. Baton</a></li>
  <li role="presentation"><a href="bimarca.php">Post. Bimarca</a></li>
  <li role="presentation"><a href="jumbos.php">Post. Jumbos</a></li>
  <li role="presentation"><a href="solicitacao.php">Solicitação de Cadastro</a></li>
  <li role="presentation" style="float: right;padding-top: 10px;padding-right: 5px;"><input  class="btn btn-danger btn-xs" type="submit" value="Sair" onclick="location.  href='controle.php?tipo=sair'"></li>
  <li style="float: right; padding-top: 1px; margin-top: -5px;"> <h5 style=" height: 30px; padding-top: 5px; padding-right: 5px; text-align:center; color: #0D3744">
          <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Trocar Senha <i class="glyphicon glyphicon-lock" aria-hidden="true"></i></button>
      </h5></li>

  <li role="presentation" style="float: right;"><h5 style="color: #A6CFF3; font-family: sans-serif;padding-top: 4px;">Você esta logado como <strong><?php print $usuario->getNome(); ?></strong> &nbsp&nbsp&nbsp&nbsp</h5></li>
               </ul>
                     
                </div>
          
          </div>


        
        <div class="row" style="padding-top: 20px;">
       
        <div class="col-md-2"></div> 
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><img src="../images/disnorte.png"></div>
        <div class="col-md-4" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;height: 50px; padding-top: 5px;"><h4>SISTEMA DE ACOMPANHAMENTO DE METAS</h4></div>
        <div class="col-md-2" style="text-align:center; background-color:#074456; font-family:Oswald; color:#E4F3F7;"><img src="../images/garoto.png"></div>
        <div class="col-md-2"></div>
        
       </div>
        
        
        <div class="row">
            
        <div class="col-md-2"></div>  
        <div class="col-md-8" style="text-align:center; background-color:#C4CFD2; color:#1b6d85;">
            <div class="styled-select">
                
   <!--<select>
      <option>Adailton</option>
      <option>Ariel</option>
   </select>-->
               
<?php
require_once '../Database/Conexao.php';

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
    $id = $vendedor;
    $data = $_POST['select_mes'];
    $mes = $mes_meta2["$data"];
    $data2 = $_POST['select_mes'];
    $meta = $data ;

}else{
    $vendedor="adilson";
    $id = $vendedor;

//$mes = $mes_extenso["$mes"];
//$meta = $mes_meta["$mes"];


}


$mes_sel = array(
    '1' => 'Janeiro',
    '2' => 'Fevereiro',
    '3' => 'Marco',
    '4' => 'Abril',
    '5' => 'Maio',
    '6' => 'Junho',
    '7' => 'Julho',
    '8' => 'Agosto',
    '11' => 'Novembro',
    '9' => 'Setembro',
    '10' => 'Outubro',
    '12' => 'Dezembro'
);


 $consulta_ved = $conn->prepare("SELECT nome, Rca FROM usuarios where tipo = 'logar' order by nome");
 $consulta_ved-> execute();
 $result2= $consulta_ved->fetchAll();
 ?> <form action="" method="post" > <label>Vendedor:</label> <select name="select_ved"> <?php
 ?>
         <option selected value="">-   -    -   - Selecionar   -   -   -   -</option>
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
    
     <label style=" padding-left: 30px;">Mês:</label>
    <select name="select_mes">
        <?php

        $i=1;

        while ($i <= 12) {
            $consulta_mes = $conn->prepare("SELECT data_doc from " . $mes_sel [$i] . " limit 1");
            $consulta_mes->execute();
            $result_mes = $consulta_mes->fetchAll();


            echo '
    
     <option value="meta' . $i . '"';

            if ($i > 9) {
                if ($i == substr($meta, -2)) {
                    echo 'selected';
                }
            } else{
                if ($i == substr($meta, -1)) {
                    echo 'selected';
                }
            }

            if(empty($result_mes)){

                echo '>'.$mes.' - '.$ano.'</option>';

            }else{

                echo '>'.$mes_sel[$i].' - '.substr($result_mes[0][0], -4).'</option>';

            }

            $i++;
        };

        ?>
   </select>
      <input name="enviar" type="submit" class="btn-info" value="Consultar" />         
    </form>            
               
            </div>
</div>
        <div class="col-md-2"></div>



            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Alterar a Senha</h4>
                        </div>
                        <div class="modal-body">
                            <form action="senha.php?vend=<?php print $usuario->getNome(); ?>" method="post" name="form">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Senha Nova:</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Confirmar senha:</label>
                                    <input type="password" class="form-control" id="confirm-senha" name="senha2" required>
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







        </div>








    </body>
</html>
