<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/CategoriaDAO.php");

$dao = new CategoriaDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
