<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/SubcategoriaDAO.php");

$dao = new SubcategoriaDAO();

$gravou = $dao->desvincular_categoria($_POST["id"],$_POST["sub"]);


if ( $gravou ) {
	echo "true";
}


?>
