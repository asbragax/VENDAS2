<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/VendaDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new VendaDAO();
    for ($i=0; $i < cal_days_in_month(CAL_GREGORIAN,$_POST['mes'] , $_POST['ano']); $i++) { 
        // echo 1;
        $temp = $dao->caixa_semana($_POST['ano']."-".$_POST['mes']."-".($i+1), $_POST['ano']."-".$_POST['mes']."-".($i+1));
        $venda[$i] = count($temp)  > 0 ? count($temp) : 0;       
    }
// print_r($Venda);
    echo safe_json_encode($venda);

?>