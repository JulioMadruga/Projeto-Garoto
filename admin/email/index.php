<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Importação de Aquivos Flexx</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>

        $(document).ready(function(){

            $( "#import" ).click(function() {

                $("#principal" ).css("display","none");


                $("#painel" ).css("display","block");

            });
        });



    </script>

</head>
<body>


<div class="col align-self-center" id="principal" style="width: 800px; margin: auto; text-align: center; top:250px">

    <h1 style="font-family: 'Roboto Slab', serif; font-size: 60px;padding-bottom: 30px;">Importação Vendas Flexx</h1>

    <a href="baixa_arq.php" id="import" class="btn btn-outline-primary" style="width: 200px; font-size: 30px;" role="button" aria-pressed="true">Importar</a>

</div>


<div class="col align-self-center" id="painel" style=" display:none; width: 800px; margin: auto; text-align: center; top:250px">

    <img src="image/spinner.gif">


</div>




</body>
</html>
