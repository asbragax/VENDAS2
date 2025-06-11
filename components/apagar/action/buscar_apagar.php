<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/ApagarDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new ApagarDAO();
    $apagar = $dao->getPorId($_POST['id']);

    echo safe_json_encode($apagar);

?>