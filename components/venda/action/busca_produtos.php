<?php

include_once "../../../db/Conexao.class.php";
include_once "../controller/Venda_produtoDAO.php";
include_once "../../../includes/json_encode.php";

$dao = new Venda_produtoDAO();

$lista = $dao->listar($_POST["id"]);

echo safe_json_encode($lista);

?>
