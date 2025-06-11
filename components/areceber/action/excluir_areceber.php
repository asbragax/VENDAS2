<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/AreceberDAO.php");

$dao = new AreceberDAO();

$gravou = $dao->excluir($_POST["id"]);

echo "true";



?>
