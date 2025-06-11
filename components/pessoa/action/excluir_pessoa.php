<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/PessoaDAO.php");

$dao = new PessoaDAO();

$gravou = $dao->excluir($_POST["id"]);


if ( $gravou ) {
	echo "true";
}


?>
