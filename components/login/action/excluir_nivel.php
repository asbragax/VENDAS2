<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/NivelDAO.php");

$dao = new NivelDAO();

$gravou = $dao->excluir($_POST["excNivel"]);


if ( $gravou ) {
	echo "true";
}


?>
