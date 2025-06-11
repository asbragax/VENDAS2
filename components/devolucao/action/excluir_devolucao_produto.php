<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/Devolucao_produtoDAO.php");

$dao = new Devolucao_produtoDAO();
$gravou = $dao->excluir($_POST["id"]);

$gravou = $dao->excluir_grade($_POST["devolucao"], $_POST["prod"]);
if($gravou){
    echo "true";
}


?>
