<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/FornecedorDAO.php");

$dao = new FornecedorDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
