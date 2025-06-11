<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/Nota_produtoDAO.php");

$dao = new Nota_produtoDAO();
$gravou = $dao->excluir($_POST["id"]);

$gravou = $dao->excluir_grade($_POST["nota"], $_POST["prod"]);
if($gravou){
    echo "true";
}


?>
