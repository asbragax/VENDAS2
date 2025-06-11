<?php

include_once "../../../db/Conexao.class.php";
include_once "../controller/VendaDAO.php";

$dao = new VendaDAO();

$gravou = $dao->efetivar_venda($_POST["id"]);




if($gravou){
    
    echo "true";
}


?>
