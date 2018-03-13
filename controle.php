<?php
require_once 'usuario.php';
require_once 'autenticador.php';
require_once 'sessao.php';

require_once 'Database/Conexao.php';

$email = $_REQUEST['email'];
$consulat_usur = $conn->prepare("SELECT tipo FROM usuarios where email = '$email'  ");
$consulat_usur ->execute();
$result_usur= $consulat_usur->fetchAll();
var_dump($result_usur);

echo $usur = $result_usur[0]['tipo'];
echo $_REQUEST['email'];
echo $_REQUEST['senha'];

if (isset($_GET['tipo'])){

    $usur = 'sair';
}

if (empty($result_usur)){

    $usur = 'email';
}




switch($usur) {

    case 'logar': {
        
        # Uso do singleton para instanciar
        # apenas um objeto de autenticação
        # e esconder a classe real de autenticação
        $aut = Autenticador::instanciar();
        
        # efetua o processo de autenticação
        if ($aut->logar($_REQUEST['email'], $_REQUEST['senha'])) {
            # redireciona o usuário para dentro do sistema
            
             $usuario = $aut->pegar_usuario();
            
            date_default_timezone_set('America/Cuiaba'); 
            $id = $usuario->getNome();
            $date = date('Ymd' );
		   

            $consulta_acess= $conn->prepare("SELECT nacesso from usuarios where nome = :id ");
            $consulta_acess->execute(array('id' => $id));
            $result_acess= $consulta_acess->fetchAll(); 
               //var_dump($result_acess);
            $nacesso = $result_acess[0];
 
             $acesso_date= $conn->prepare("UPDATE usuarios set acesso ='" .$date. "' where nome =:id");
             $acesso_date->execute(array('id' => $id));
 
         
             $acesso_num= $conn->prepare("UPDATE usuarios set nacesso = $nacesso[0] + 1 where nome = :id");
             $acesso_num->execute(array('id' => $id));
            
            
            
            
            header('location: interno.php');
        }
        else {
            # envia o usuário de volta para 
            # o form de login
            
           header('location: index.php?login=error');
        }
        
        
    } break;
    
    
    case 'admin': {
        
        # Uso do singleton para instanciar
        # apenas um objeto de autenticação
        # e esconder a classe real de autenticação
        $aut = Autenticador::instanciar();
        
        # efetua o processo de autenticação
        if ($aut->logar($_REQUEST['email'], $_REQUEST['senha'])) {
            # redireciona o usuário para dentro do sistema
           $usuario = $aut->pegar_usuario();
            
            date_default_timezone_set('America/Cuiaba');
            $id = $usuario->getNome();
            $date = date('Ymd' );



			
            $consulta_acess= $conn->prepare("SELECT nacesso from usuarios where nome = :id ");
            $consulta_acess->execute(array('id' => $id));
            $result_acess= $consulta_acess->fetchAll(); 
               //var_dump($result_acess);
            $nacesso = $result_acess[0];
 
             $acesso_date= $conn->prepare("UPDATE usuarios set acesso ='" .$date. "' where nome =:id");
             $acesso_date->execute(array('id' => $id));
 
         
             $acesso_num= $conn->prepare("UPDATE usuarios set nacesso = $nacesso[0] + 1 where nome = :id");
             $acesso_num->execute(array('id' => $id));
 

            
            
            header('location: admin/index.php');
        }
        else {
            # envia o usuário de volta para 
            # o form de login
            
           header('location: index.php?login=error');
        }
        
        
    } break;
    
    
    
    
    
    
    case 'sair': {
        
        # envia o usuário para fora do sistema
        # o form de login
        header('location: index.php');
        
    } break;


    case 'email': {

        # envia o usuário para fora do sistema
        # o form de login
        header('location: index.php?login=email');

    } break;

    
}

?>