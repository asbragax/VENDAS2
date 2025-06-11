<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/GrupoDAO.php");

$dao = new GrupoDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
