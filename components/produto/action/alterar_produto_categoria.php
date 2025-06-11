<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/ProdutoDAO.php");


$dao = new ProdutoDAO();

$gravou = $dao->editar_categoria($_POST["id"], $_POST['categoria']);


if ( $gravou ) {
	echo "true";
}


?>
