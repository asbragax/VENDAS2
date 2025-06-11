<?php

include_once("../controller/UserDAO.php");
// include_once("../controller/Nivel_acessoDAO.php");
include_once("../../../db/Conexao.class.php");
include_once("../respobj.php");

$username = trim($_POST['myusername']);
$password = $_POST['mypassword'];

function checkLogin($myusername, $mypassword)
{

    $userDao = new UserDAO();
    $result = $userDao->getPorNome($myusername);
    
    if (strtolower($result['username']) == strtolower($myusername)) {
        
        if (password_verify($mypassword, $result['password'])) {
            
            //Success! Register $myusername, $mypassword and return "true"
            $success = 'true';
            session_start();
            
            $_SESSION['username'] = $myusername;
            $_SESSION['nivel'] = $result['nivel'];
            $_SESSION['nome'] = $result['nome'];
            $_SESSION['img'] = $result['img'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['senha'] = $result['password'];
            $_SESSION['email'] = $result['email'];
            
            $userDao->cadastrar_login($result['id']);
        } else {
            
            //Wrong username or password
            $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Senha incorreta</div>";
        }
    } else {
        $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Nome de usuário desconhecido</div>";
    }
    return $success;
}

$response = checkLogin($username, $password);
$resp = new RespObj($username, $response);
$jsonResp = json_encode($resp);
echo $jsonResp;

unset($resp, $jsonResp);
ob_end_flush();