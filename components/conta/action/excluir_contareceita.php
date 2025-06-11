<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/Conta_receitaDAO.php");

$dao = new Conta_receitaDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
