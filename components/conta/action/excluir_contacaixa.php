<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/Conta_caixaDAO.php");

$dao = new Conta_caixaDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
