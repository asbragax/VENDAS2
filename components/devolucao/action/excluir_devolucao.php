<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/DevolucaoDAO.php");
include_once("../controller/Devolucao_produtoDAO.php");

$dao = new DevolucaoDAO();
$gravou = $dao->excluir($_POST["id"]);

$dao = new Devolucao_produtoDAO();
$gravou = $dao->excluir_todos($_POST["id"]);
$gravou = $dao->excluir_grade_todos($_POST["id"]);

if($gravou){
    echo "true";
}



?>
