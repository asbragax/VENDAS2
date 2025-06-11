<?php

    include_once("../../../db/Conexao.class.php");
    include_once("../controller/StatusDAO.php");

    $dao = new StatusDAO();
    $gravou = $dao->alterar($_POST['status'], 1);

    // echo safe_json_encode($lista);
    if($gravou){
        echo true;
    }
?>