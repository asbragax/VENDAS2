<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/ProdutoDAO.php");

$dao = new ProdutoDAO();

$gravou = $dao->excluir_grade($_POST["id"]);
$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
echo "true"; 
}


?>
