<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/ApagarDAO.php");
    include_once("../../../components/conta/controller/CategoriaDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new CategoriaDAO();
    $categorias = $dao->listar();
    $dao = new ApagarDAO();
    $result = $dao->lista_por_mes_categoria($_POST['mes'],$_POST['ano'], $categorias);

    function cmp($a, $b)
    {
        return $a['total'] < $b['total'];
    }
    if (count($result) > 0) {
        // Ordena
        usort($result, 'cmp');
    }
    $total = 0;
    $result2 = [];
    for ($i=0; $i < count($result); $i++) { 
        if($i < 3){
            $result2[] = $result[$i];
        }else{
            $total += $result[$i]['total'];
        }
    }
    $result2[3]["total"] = $total;
    $result2[3]["nome"] = "Outros";
    unset($result);
    echo safe_json_encode($result2);

?>