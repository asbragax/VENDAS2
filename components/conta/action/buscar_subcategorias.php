<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/SubcategoriaDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new SubcategoriaDAO();
    $lista = $dao->listarPorCategoriaSelect($_POST['id']);

    echo safe_json_encode($lista);

?>