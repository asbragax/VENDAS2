<?php

include_once "../../../db/Conexao.class.php";

include_once "../model/Venda.class.php";
include_once "../model/Venda_produto.class.php";

include_once "../controller/VendaDAO.php";
include_once "../controller/Venda_produtoDAO.php";

include_once "../controller/PrevendaDAO.php";
include_once "../controller/Prevenda_produtoDAO.php";

include_once "../../../includes/json_encode.php";

$dao = new PrevendaDAO();

$prevenda = $dao->getPorId($_POST['id']);

$dao = new VendaDAO();
$ultimo = $dao->getUltimo();

$dao = new Prevenda_produtoDAO();

$CARRINHO = $dao->listar($_POST['id']);

$venda_produto = new Venda_produto();
$venda_produto->id_venda = $ultimo['Auto_increment'];


for ($x = 0; $x < count($CARRINHO); $x++) {
    if($CARRINHO[$x]["id_produto"] != '' && $CARRINHO[$x]["tamanho"] != '' && $CARRINHO[$x]["valor_total"] != ''){        
        $venda_produto->id_produto = ($CARRINHO[$x]["id_produto"]);
        $venda_produto->quantidade = ($CARRINHO[$x]["quantidade"]);
        $venda_produto->nome = ($CARRINHO[$x]["nome"]);
        $venda_produto->tamanho = ($CARRINHO[$x]["tamanho"]);
        $venda_produto->valor_unit = ($CARRINHO[$x]["valor_unit"]);
        $venda_produto->valor_total = ($CARRINHO[$x]["valor_total"]);
        $venda_produto->valor_compra = 0;
        
        $gravou1 = $venda_produto->grava();
    }
}


$venda = new Venda();

$venda->valor = $prevenda['valor'];
$venda->desconto = $prevenda['desconto'];
$venda->data = $prevenda['data'];
$venda->forma_pag = 97;
$venda->pag = 0;
$venda->entrega = 0;
$venda->endereco = $prevenda['endereco'];
$venda->prevenda = 1;
$venda->comissao = 0;
$venda->sociedade = 0;
$venda->valor_comissao = 0;
$venda->status = 0;
$venda->valor_compra = $prevenda['valor_compra'];
$venda->cliente = $prevenda['cliente'];
$venda->vendedor = $prevenda['vendedor'];
$venda->user = $prevenda['user'];
$venda->time = $prevenda['time'];

$gravou = $venda->grava();

// $gravou = 1;


if($gravou){
    $dao = new PrevendaDAO();

    $prevenda = $dao->alterar_status($_POST['id']);

    $dao = new ProdutoDAO();
    for ($x = 0; $x < count($CARRINHO); $x++) {
        $deduz = $dao->deduzir_quantidade($CARRINHO[$x]["id_produto"], $CARRINHO[$x]["tamanho"], $CARRINHO[$x]["quantidade"]);
    }

    echo $ultimo['Auto_increment'];
}else{
    echo 'false';
}

?>
