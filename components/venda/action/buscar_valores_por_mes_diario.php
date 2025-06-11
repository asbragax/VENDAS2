<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/Venda_pagamentoDAO.php");
    include_once("../../pessoa/controller/Pessoa_crediarioDAO.php");
    include_once("../../../includes/json_encode.php");

    $dao = new Venda_pagamentoDAO();
    for ($i=0; $i < cal_days_in_month(CAL_GREGORIAN,$_POST['mes'] , $_POST['ano']); $i++) { 
        $temp = $dao->listarPorDia($_POST['ano']."-".$_POST['mes']."-".($i+1));
        $valores[$i] = $temp['valor']  > 0 ? number_format($temp['valor']/100, 2, ".", "") : 0;       
    }
    $dao = new Pessoa_crediarioDAO();
    for ($i=0; $i < cal_days_in_month(CAL_GREGORIAN,$_POST['mes'] , $_POST['ano']); $i++) { 
        $temp = $dao->listarPorDia($_POST['ano']."-".$_POST['mes']."-".($i+1));
        $valores[$i] += $temp['valor']  > 0 ? number_format($temp['valor']/100, 2, ".", "") : 0;       
    }

    echo safe_json_encode($valores);

?>