<?php
include_once("../controller/UserDAO.php");
include_once("../../../db/Conexao.class.php");
//Pull username, generate new ID and hash password
$newid = uniqid(rand(), false);
$newuser = $_POST['newuser'];
$newpw = password_hash($_POST['password1'], PASSWORD_DEFAULT);
$pw1 = $_POST['password1'];
$pw2 = $_POST['password2'];
$nivel = $_POST['nivel'];
$nome = $_POST['nome'];
$img = $_POST['imagem'];
$email = $_POST['email'];

if ($pw1 != $pw2) {
    
    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>As senhas devem ser as mesmas</div><div id="returnVal" style="display:none;">false</div>';
} elseif (strlen($pw1) < 4) {
    
    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>A senha deve ter pelo menos 4 caracteres</div><div id="returnVal" style="display:none;">false</div>';
} else {
    //Validation passed
    if (isset($_POST['newuser']) && !empty(str_replace(' ', '', $_POST['newuser'])) && isset($_POST['password1']) && !empty(str_replace(' ', '', $_POST['password1']))) {
        
        //Tries inserting into database and add response to variable
        
        $userDao = new UserDAO();
        
        
        $response = $userDao->cadastrar($newuser, $newid, $newpw, $nivel, $nome, $img, $email);
        // echo $newuser." ".$newid." ".$nivel." ".$nome." ".$img;
        //Success
        if ($response == 'true') {
            
            header("location:../../../index.php?consUser");
        }
    } else {
        //Validation error from empty form variables
        echo 'Ocorreu um erro... tente novamente';
    }
};