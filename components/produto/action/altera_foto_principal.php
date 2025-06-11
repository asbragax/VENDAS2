<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/ProdutoDAO.php");
    // include_once("../../../includes/json_encode.php");
    $dao = new ProdutoDAO();
    // echo 1;

    $dao->alterar_foto_principal($_POST['id'], $_POST['foto']);

    echo 'true';

?>