<?php

include_once("../../../db/Conexao.class.php");
include_once("../controller/ProdutoDAO.php");

$dao = new ProdutoDAO();
$gravou = $dao->excluir_cor($_POST['id'], $_POST['cor']);


if ( $gravou ) {
    echo "true"; 
}
    
    
?>
    