<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/NotaDAO.php");
include_once("../controller/Nota_produtoDAO.php");

$dao = new NotaDAO();
$gravou = $dao->excluir($_POST["id"]);

$dao = new Nota_produtoDAO();
$gravou = $dao->excluir_todos($_POST["id"]);
$gravou = $dao->excluir_grade_todos($_POST["id"]);

if($gravou){
    echo "true";
}



?>
