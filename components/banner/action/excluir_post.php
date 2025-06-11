<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/PostDAO.php");


$dao = new PostDAO();

$gravou = $dao->excluir($_POST["id"]);


unlink('../../../arquivos/banners/'.$_POST["foto"]);
echo $gravou;

if ( $gravou ) {
	echo "true";
}


?>
