<?php

include_once("../../../db/Conexao.class.php");
include_once("../../produto/controller/ProdutoDAO.php");
include_once("../controller/NotaDAO.php");
include_once("../controller/Nota_produtoDAO.php");


$dao = new Nota_produtoDAO();
$itens = $dao->listar($_POST["id"]);
$proddao = new ProdutoDAO();

for ($i=0; $i < count($itens); $i++) { 
    $grade = $dao->listar_grade($itens[$i]['id_nota'], $itens[$i]['id_produto']);
    for ($x=0; $x < count($grade); $x++) { 
        $gravou = $proddao->deduzir_quantidade($grade[$x]['id'], $grade[$x]['tipo'], $grade[$x]['quantidade']);
    }
}
if($gravou){
    $dao = new NotaDAO();
    $gravou = $dao->alterar_flag($_POST["id"], 0);
}


if($gravou){
    echo "true";
}
?>
