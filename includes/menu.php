<?php session_start(); ?>
<div class="menu-header">MENU</div>
<div class="menu-item menu-item menu_home">
    <a href="index.php" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-home"></i> 
        </div>
        <div class="menu-text">Início</div>
    </a>
</div>
<?php if($_SESSION['nivel'] >= 3){ ?>
<div class="menu-item menu-item menu_apagar">
    <a href="?consApagar" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-search-dollar"></i>
        </div>
        <div class="menu-text">A pagar</div>
    </a>
</div>
<div class="menu-item menu-item menu_areceber">
    <a href="?consPessoaCrediario" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-dollar-sign"></i>
        </div>
        <div class="menu-text">A receber</div>
    </a>
</div>
<div class="menu-item menu-item has-sub menu_caixa">
    <a href="?caixa" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-cash-register"></i>
        </div>
        <div class="menu-text">Caixa</div>
    </a>
</div>
<?php } ?>
<div class="menu-item menu-item menu_venda">
    <a href="?consVendaConsignado" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div class="menu-text">Vendas</div>
    </a>
</div>
<?php if($_SESSION['nivel'] >= 3){ ?>  
<div class="menu-item menu-item has-sub menu_relatorio">
    <a href="javascript:;" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-file-alt"></i>
        </div>
        <div class="menu-text">Relatórios</div>
        <div class="menu-caret"></div>
    </a>
    <div class="menu-submenu">
        <div class="menu-item menu-subitem submenu_relatorio_1">
            <a href="?relEstoque" class="menu-link"><div class="menu-text">Estoque</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_relatorio_2">
            <a href="?relEmaberto_cliente" class="menu-link"><div class="menu-text">Em aberto/cliente</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_relatorio_3">
            <a href="?relSaida" class="menu-link"><div class="menu-text">A pagar</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_relatorio_4">
            <a href="?relProduto" class="menu-link"><div class="menu-text">Saída de produtos</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_relatorio_8">
            <a href="?relVenda" class="menu-link"><div class="menu-text">Vendas</div></a>
        </div> 
        <div class="menu-item menu-subitem submenu_relatorio_5">
            <a href="?relAtrasado" class="menu-link"><div class="menu-text">Atrasados</div></a>
        </div> 
        <div class="menu-item menu-subitem submenu_relatorio_6">
            <a href="?relAreceber" class="menu-link"><div class="menu-text">A receber</div></a>
        </div> 
        <div class="menu-item menu-subitem submenu_relatorio_7">
            <a href="?relComissao" class="menu-link"><div class="menu-text">Comissões</div></a>
        </div>
    


    </div>
</div>
<?php } ?>
<div class="menu-item menu-item menu_pessoa">
    <a href="?consPessoa" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="menu-text">Clientes</div>
    </a>
</div>
<?php if($_SESSION['nivel'] >= 3){ ?> 
<div class="menu-item menu-item menu_produto">
    <a href="?consProduto" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-boxes"></i>
        </div>
        <div class="menu-text">Produtos</div>
    </a>
</div>
<div class="menu-item menu-item menu_nota">
    <a href="?consNota" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-file-contract"></i>
        </div>
        <div class="menu-text">Notas</div>
    </a>
</div>
<div class="menu-item menu-item menu_devolucao">
    <a href="?consDevolucao" class="menu-link">
        <div class="menu-icon">
            <i class="fas fa-reply-all"></i>
        </div>
        <div class="menu-text">Devoluções/trocas</div>
    </a>
</div>
<div class="menu-item menu-item menu_categoria">
    <a href="?consCategoria" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-tags"></i>
        </div>
        <div class="menu-text">Categorias</div>
    </a>
</div>
<div class="menu-item menu-item has-sub menu_conta">
    <a href="javascript:;" class="menu-link">
        <div class="menu-icon">
            <i class="fa fa-cash-register"></i>
        </div>
        <div class="menu-text">Contas</div>
        <div class="menu-caret"></div>
    </a>
    <div class="menu-submenu">
        <div class="menu-item menu-subitem submenu_conta_1">
            <a href="?consFornecedor" class="menu-link"><div class="menu-text">Fornecedores</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_conta_2">
            <a href="?consPagamento" class="menu-link"><div class="menu-text">Formas de pag.</div></a>
        </div>
        <div class="menu-item menu-subitem submenu_conta_3">
            <a href="?consPost" class="menu-link"><div class="menu-text">Banners.</div></a>
        </div>
    </div>
</div>
<?php } ?>

