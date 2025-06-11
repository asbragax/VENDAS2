<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/ApagarDAO.php");

$dao = new ApagarDAO();
$apagar = $dao->getPorId($_POST["id"]);

unlink("../../../boletos/".$apagar['arquivo_boleto']);
unlink("../../../recibos/".$apagar['arquivo_recibo']);
unlink("../../../notas/".$apagar['arquivo_nota']);
$gravou = $dao->excluir($_POST["id"]);



echo "true";



?>
