<?php

include_once "../../../db/Conexao.class.php";
include_once "../controller/PrevendaDAO.php";
include_once "../controller/Prevenda_produtoDAO.php";
include_once "../../produto/controller/ProdutoDAO.php";
// include_once "../../pessoa/controller/Pessoa_crediarioDAO.php";

$dao = new PrevendaDAO();

$gravou = $dao->excluir($_POST["excVenda"]);

$dao = new Prevenda_produtoDAO();
$produtos = $dao->listar($_POST['excVenda']);
$gravou = $dao->excluir($_POST["excVenda"]);

$dao = new ProdutoDAO();
for ($i=0; $i < count($produtos); $i++) { 
    $salvou = $dao->aumentar_quantidade($produtos[$i]['id'], $produtos[$i]['tamanho'], $produtos[$i]['quantidade']);
}



echo "true";


?>
