<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/PagamentoDAO.php");

$dao = new PagamentoDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
