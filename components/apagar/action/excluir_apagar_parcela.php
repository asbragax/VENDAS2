<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/ApagarDAO.php");

$dao = new ApagarDAO();

$gravou = $dao->excluir_parcela($_POST["id"]);
$gravou = $dao->diminuir_prestacao($_POST["id_apagar"]);
$gravou = $dao->reorganizar_parcela($_POST["id_apagar"], $_POST["num"]);

if($gravou){
    echo "true";
}



?>
