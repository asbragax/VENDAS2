<?php

include_once "../../../db/Conexao.class.php";
include_once "../controller/VendaDAO.php";
include_once "../controller/Venda_produtoDAO.php";
include_once "../../produto/controller/ProdutoDAO.php";
include_once "../../pessoa/controller/Pessoa_crediarioDAO.php";

$dao = new VendaDAO();

$gravou = $dao->excluir($_POST["excVenda"]);

$dao = new Venda_produtoDAO();
$produtos = $dao->listar($_POST['excVenda']);
$gravou = $dao->excluir($_POST["excVenda"]);

$dao = new ProdutoDAO();
for ($i=0; $i < count($produtos); $i++) { 
    $salvou = $dao->aumentar_quantidade($produtos[$i]['id'], $produtos[$i]['tamanho'], $produtos[$i]['quantidade']);
}

$dao = new Pessoa_crediarioDAO();
$produtos = $dao->excluir($_POST['excVenda']);


echo "true";


?>
