<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/UserDAO.php");
$dao = new UserDAO();

$gravou = $dao->ativar($_POST["excUser"]);

echo $gravou;

if ( $gravou ) {
	echo "true";
}


?>
