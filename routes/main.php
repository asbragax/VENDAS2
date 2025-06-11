 <!-- the #js-page-content id is needed for some plugins to initialize -->
<div id="content" class="app-content">
    <?php
     if($NAOPAGOU != 1){
    //NIVEL E USUÁRIO
        if (isset($_GET["cadNivel"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/cadastro/nivel.php";
        } elseif (isset($_GET["consNivel"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/consulta/nivel.php";
        } elseif (isset($_GET["edtNivel"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/editar/nivel.php";
        } elseif (isset($_GET["cadUser"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/cadastro/signup.php";
        } elseif (isset($_GET["consUser"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/consulta/user.php";
        } elseif (isset($_GET["edtUser"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/editar/profile.php";
        } elseif (isset($_GET["profile"])) {
            $MENUCLASS = '0';
            $SUBMENUCLASS = '0';
            include "components/login/view/detalhe/profile.php";
        } elseif (isset($_GET["cadPost"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/banner/view/cadastro/post.php";
        } elseif (isset($_GET["consPost"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/banner/view/consulta/post.php";
        } elseif (isset($_GET["edtPost"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/banner/view/editar/post.php";
//PRODUTOS
        } elseif (isset($_GET["cadProduto"])) {
            $MENUCLASS = 'produto';
            $SUBMENUCLASS = '0';
            include "components/produto/view/cadastro/produto.php";
        } elseif (isset($_GET["consProduto"])) {
            $MENUCLASS = 'produto';
            $SUBMENUCLASS = '0';
            include "components/produto/view/consulta/produto.php";
        } elseif (isset($_GET["edtProduto"])) {
            $MENUCLASS = 'produto';
            $SUBMENUCLASS = '0';
            include "components/produto/view/editar/produto.php";
        } elseif (isset($_GET["dtlProduto"])) {
            $MENUCLASS = 'produto';
            $SUBMENUCLASS = '0';
            include "components/produto/view/detalhe/produto.php";
//VENDA
        } elseif (isset($_GET["cadVenda"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/cadastro/venda.php";
        } elseif (isset($_GET["consVenda"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/consulta/venda.php";
        } elseif (isset($_GET["consVendaConsignado"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/consulta/consignado.php";
        } elseif (isset($_GET["consVendaVendedor"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/consulta/vendedor.php";
        } elseif (isset($_GET["consVendaSite"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/consulta/site.php";
        } elseif (isset($_GET["edtVenda"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/editar/venda.php";
        } elseif (isset($_GET["dtlVenda"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/detalhe/venda.php";
        } elseif (isset($_GET["dtlVendaSite"])) {
            $MENUCLASS = 'venda';
            $SUBMENUCLASS = '0';
            include "components/venda/view/detalhe/venda_site.php";
//FORNECEDORES
        } elseif (isset($_GET["cadFornecedor"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '1';
            include "components/fornecedor/view/cadastro/fornecedor.php";
        } elseif (isset($_GET["consFornecedor"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '1';
            include "components/fornecedor/view/consulta/fornecedor.php";
        } elseif (isset($_GET["edtFornecedor"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '1';
            include "components/fornecedor/view/editar/fornecedor.php";
        } elseif (isset($_GET["dtlFornecedor"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '1';
            include "components/fornecedor/view/detalhe/fornecedor.php";
//PESSOAS
        } elseif (isset($_GET["cadPessoa"])) {
            $MENUCLASS = 'pessoa';
            $SUBMENUCLASS = '0';
            include "components/pessoa/view/cadastro/pessoa.php";
        } elseif (isset($_GET["consPessoa"])) {
            $MENUCLASS = 'pessoa';
            $SUBMENUCLASS = '0';
            include "components/pessoa/view/consulta/pessoa.php";
        } elseif (isset($_GET["consPessoaCrediario"])) {
            $MENUCLASS = 'areceber';
            $SUBMENUCLASS = '0';
            include "components/pessoa/view/consulta/pessoa_crediario.php";
        } elseif (isset($_GET["edtPessoa"])) {
            $MENUCLASS = 'pessoa';
            $SUBMENUCLASS = '0';
            include "components/pessoa/view/editar/pessoa.php";
        } elseif (isset($_GET["dtlPessoa"])) {
            $MENUCLASS = 'pessoa';
            $SUBMENUCLASS = '0';
            include "components/pessoa/view/detalhe/pessoa.php";
//CONTAS CAIXA
        } elseif (isset($_GET["cadContaCaixa"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/conta/view/cadastro/conta_caixa.php";
        } elseif (isset($_GET["consContaCaixa"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/conta/view/consulta/conta_caixa.php";
        } elseif (isset($_GET["edtContaCaixa"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/conta/view/editar/conta_caixa.php";
        } elseif (isset($_GET["dtlContaCaixa"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '3';
            include "components/conta/view/detalhe/conta_caixa.php";
//CONTAS RECEITA
        } elseif (isset($_GET["cadContaReceita"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '4';
            include "components/conta/view/cadastro/conta_receita.php";
        } elseif (isset($_GET["consContaReceita"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '4';
            include "components/conta/view/consulta/conta_receita.php";
        } elseif (isset($_GET["edtContaReceita"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '4';
            include "components/conta/view/editar/conta_receita.php";
        } elseif (isset($_GET["dtlContaReceita"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '4';
            include "components/conta/view/detalhe/conta_receita.php";
//PAGAMENTO
        } elseif (isset($_GET["cadPagamento"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '2';
            include "components/conta/view/cadastro/pagamento.php";
        } elseif (isset($_GET["consPagamento"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '2';
            include "components/conta/view/consulta/pagamento.php";
        } elseif (isset($_GET["edtPagamento"])) {
            $MENUCLASS = 'conta';
            $SUBMENUCLASS = '2';
            include "components/conta/view/editar/pagamento.php";
//CATEGORIAS
        } elseif (isset($_GET["cadCategoria"])) {
            $MENUCLASS = 'categoria';
            $SUBMENUCLASS = '0';
            include "components/produto/view/cadastro/categoria.php";
        } elseif (isset($_GET["consCategoria"])) {
            $MENUCLASS = 'categoria';
            $SUBMENUCLASS = '0';
            include "components/produto/view/consulta/categoria.php";
        } elseif (isset($_GET["edtCategoria"])) {
            $MENUCLASS = 'categoria';
            $SUBMENUCLASS = '0';
            include "components/produto/view/editar/categoria.php";
        } elseif (isset($_GET["dtlCategoria"])) {
            $MENUCLASS = 'categoria';
            $SUBMENUCLASS = '0';
            include "components/produto/view/detalhe/categoria.php";
//NOTAS
        } elseif (isset($_GET["cadNota"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/nota/view/cadastro/nota.php";
        } elseif (isset($_GET["cadNota_produto"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/nota/view/cadastro/nota_produto.php";
        } elseif (isset($_GET["consNota"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/nota/view/consulta/nota.php";
        } elseif (isset($_GET["edtNota"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/nota/view/editar/nota.php";
        } elseif (isset($_GET["dtlNota"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/nota/view/detalhe/nota.php";
//NOTAS
        } elseif (isset($_GET["cadDevolucao"])) {
            $MENUCLASS = 'devolucao';
            $SUBMENUCLASS = '0';
            include "components/devolucao/view/cadastro/devolucao.php";
        } elseif (isset($_GET["cadDevolucao_produto"])) {
            $MENUCLASS = 'nota';
            $SUBMENUCLASS = '0';
            include "components/devolucao/view/cadastro/devolucao_produto.php";
        } elseif (isset($_GET["consDevolucao"])) {
            $MENUCLASS = 'devolucao';
            $SUBMENUCLASS = '0';
            include "components/devolucao/view/consulta/devolucao.php";
        } elseif (isset($_GET["edtDevolucao"])) {
            $MENUCLASS = 'devolucao';
            $SUBMENUCLASS = '0';
            include "components/devolucao/view/editar/devolucao.php";
        } elseif (isset($_GET["dtlDevolucao"])) {
            $MENUCLASS = 'devolucao';
            $SUBMENUCLASS = '0';
            include "components/devolucao/view/detalhe/devolucao.php";
//CAIXA
        } elseif (isset($_GET["pagCrediario"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '1';
            include "components/caixa/view/editar/pagCrediario.php";
        } elseif (isset($_GET["caixa"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '0';
            include "components/caixa/view/consulta/caixa.php";
        } elseif (isset($_GET["pagApagar"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '1';
            include "components/apagar/view/editar/apagar_parcela.php";
        }else if (isset($_GET["pagPrestacao"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '0';
            include "components/caixa/view/editar/pagPrestacao.php";
        }else if (isset($_GET["dtlPrestacao"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '0';
            include "components/caixa/view/detalhe/prestacao.php";
        }else if (isset($_GET["dtlPrestacaoVendedor"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '0';
            include "components/caixa/view/detalhe/prestacao_vendedor.php";
        }else if (isset($_GET["dtlPrestacaoDia"])) {
            $MENUCLASS = 'caixa';
            $SUBMENUCLASS = '0';
            include "components/caixa/view/detalhe/prestacao_dia.php";
        

//A PAGAR
        } elseif (isset($_GET["cadApagar"])) {
            $MENUCLASS = 'apagar';
            $SUBMENUCLASS = '0';
            include "components/apagar/view/cadastro/apagar.php";
        } elseif (isset($_GET["consApagar"])) {
            $MENUCLASS = 'apagar';
            $SUBMENUCLASS = '0';
            include "components/apagar/view/consulta/apagar.php";
        } elseif (isset($_GET["consApagarPagas"])) {
            $MENUCLASS = 'apagar';
            $SUBMENUCLASS = '0';
            include "components/apagar/view/consulta/apagarPagas.php";
        } elseif (isset($_GET["edtApagar"])) {
            $MENUCLASS = 'apagar';
            $SUBMENUCLASS = '0';
            include "components/apagar/view/editar/apagar.php";
        } elseif (isset($_GET["dtlApagar"])) {
            $MENUCLASS = 'apagar';
            $SUBMENUCLASS = '0';
            include "components/apagar/view/detalhe/apagar.php";
//RELATÓRIOS
        } elseif (isset($_GET["relCrediario"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '1';
            include "components/relatorio/view/crediario.php";
        } elseif (isset($_GET["relVenda"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '8';
            include "components/relatorio/view/venda.php";
        } elseif (isset($_GET["relEstoque"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '1';
            include "components/relatorio/view/estoque.php";
        } elseif (isset($_GET["relEmaberto_cliente"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '2';
            include "components/relatorio/view/emaberto_cliente.php";
        } elseif (isset($_GET["relSaida"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '3';
            include "components/relatorio/view/saida.php";
        } elseif (isset($_GET["relProduto"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '4';
            include "components/relatorio/view/produto.php";
        } elseif (isset($_GET["relAtrasado"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '5';
            include "components/relatorio/view/atrasado.php";
        } elseif (isset($_GET["relAreceber"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '6';
            include "components/relatorio/view/areceber.php";
        } elseif (isset($_GET["relComissao"])) {
            $MENUCLASS = 'relatorio';
            $SUBMENUCLASS = '7';
            include "components/relatorio/view/comissao.php";
//MAIN CONTENT
        }else {
            $MENUCLASS = 'home';
            include "components/main/view/consulta/main-content.php";
        } 
    }else{

        include "naopagou.php";
    }
// include('migration.php');
?>

        <!-- <div id="footer" class="app-footer m-0">
            <div class="row">
                <span>
                    <a href="#" class="text-decoration-none link-success me-5px mb-5px">André Braga - Sistemas e Aplicativos</a>
                    <a href="https://wa.me/5531988778860" class="btn btn-social-icon btn-adn float-start me-5px mb-5px"><span class="fab fa-whatsapp"></span></a>
                    <a href="https://geeksistemas.com.br#contact" class="btn btn-social-icon btn-bitbucket float-start me-5px mb-5px"><span class="fa fa-envelope"></span></a>
                    <a href="tel:31988778860" class="btn btn-social-icon btn-dropbox float-start me-5px mb-5px"><span class="fa fa-phone-alt"></span></a>
                </span>
            </div>
        </div> -->

 </div>
