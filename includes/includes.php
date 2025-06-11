<?php
include_once "db/Conexao.class.php";

include_once "components/login/controller/UserDAO.php";
include_once "components/login/controller/NivelDAO.php";
include_once "components/fornecedor/controller/FornecedorDAO.php";
include_once "components/pessoa/controller/PessoaDAO.php";
// include_once "components/areceber/controller/AreceberDAO.php";
include_once "components/apagar/controller/ApagarDAO.php";
include_once "components/produto/controller/ProdutoDAO.php";
include_once "components/produto/controller/CategoriaDAO.php";
include_once "components/produto/controller/BoloDAO.php";
include_once "components/pedido/controller/PedidoDAO.php";
include_once "components/venda/controller/VendaDAO.php";
include_once "components/venda/controller/Venda_produtoDAO.php";
include_once "components/venda/controller/PrevendaDAO.php";
include_once "components/venda/controller/Prevenda_produtoDAO.php";
include_once "components/venda/controller/Venda_pagamentoDAO.php";
include_once "components/conta/controller/Conta_receitaDAO.php";
include_once "components/conta/controller/Conta_caixaDAO.php";
include_once "components/conta/controller/PagamentoDAO.php";
include_once "components/pessoa/controller/Pessoa_crediarioDAO.php";
include_once "components/nota/controller/NotaDAO.php";
include_once "components/nota/controller/Nota_produtoDAO.php";
include_once "components/venda/controller/PrevendaDAO.php";
include_once "components/venda/controller/Prevenda_produtoDAO.php";
include_once "components/banner/controller/PostDAO.php";
include_once "components/devolucao/controller/DevolucaoDAO.php";
include_once "components/devolucao/controller/Devolucao_produtoDAO.php";
include_once "components/status/controller/StatusDAO.php";


include_once "components/login/model/User.class.php";
include_once "components/login/model/Nivel.class.php";
include_once "components/fornecedor/model/Fornecedor.class.php";
include_once "components/pessoa/model/Pessoa.class.php";
// include_once "components/areceber/model/Areceber.class.php";
include_once "components/apagar/model/Apagar.class.php";
include_once "components/produto/model/Produto.class.php";
include_once "components/produto/model/Categoria.class.php";
include_once "components/pedido/model/Pedido.class.php";
include_once "components/venda/model/Venda.class.php";
include_once "components/venda/model/Venda_produto.class.php";
include_once "components/venda/model/Prevenda.class.php";
include_once "components/venda/model/Prevenda_produto.class.php";
include_once "components/conta/model/Conta_receita.class.php";
include_once "components/conta/model/Conta_caixa.class.php";
include_once "components/conta/model/Pagamento.class.php";
include_once "components/nota/model/Nota.class.php";
include_once "components/nota/model/Nota_produto.class.php";
include_once "components/venda/model/Prevenda.class.php";
include_once "components/venda/model/Prevenda_produto.class.php";
include_once "components/banner/model/Post.class.php";
include_once "components/devolucao/model/Devolucao.class.php";
include_once "components/devolucao/model/Devolucao_produto.class.php";


// $dao = new Pessoa_crediarioDAO();
// $crediarios = $dao->listar_30dias();
$dao = new ApagarDAO();
$contas = $dao->listar_parcelas_abertas_recentes(date('Y-m-d'));

// $dao = new PessoaDAO();
// if(date('w') == 1){
//     $pessoas = $dao->aniversariantes_domingo(date(('Y-m-d'), strtotime('-1 day', strtotime(date('Y-m-d')))), date('Y-m-d'));
// }else{
//     $pessoas = $dao->aniversariantes();
// }
