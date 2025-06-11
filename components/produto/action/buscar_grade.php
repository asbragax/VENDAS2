<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/ProdutoDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new ProdutoDAO();

    $grade = $dao->listar_grade($_POST['id']);


// print_r($Venda);
    echo safe_json_encode($grade);

?>