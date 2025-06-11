<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlVenda'];
    if(isset($_GET['vendedor']) && $_GET['vendedor'] == 1){
        $vendedor = 1;
    }else{
        $vendedor = 0;
    }
    $id = $_GET['dtlVenda'];
    $pagdao = new VendaDAO();
    $venda = $pagdao->getPorIdDetails($id);
    $pagdao = new Venda_produtoDAO();
    $produtos = $pagdao->listar($id);
    $pagdao = new Venda_pagamentoDAO();
    $pagamentos = $pagdao->listarSemCrediario($id);
    $pagdao = new PessoaDAO();
    $pessoa = $pagdao->getPorIdAssoc($venda['cliente']);
    $pagdao = new Pessoa_crediarioDAO();
    $crediario = $pagdao->getPorId($venda['cliente'], $id);
    $parcelas = $pagdao->listar_parcelas($crediario['id']);

    $pagdao = new UserDAO();
    if($_SESSION['nivel'] > 3){
        $users = $pagdao->listar_all_levelDesc();
    }else{
        $users = $pagdao->listar_funcionariosDesc();   
    }
// ob_start();
?>
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company">
        <span class="me-2 float-end hidden-print">
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <span class="me-2 float-end hidden-print">
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnRecibo" value="<?php echo $id; ?>"><i class="fa fa-paper-plane t-plus-1 text-info fa-fw fa-lg"></i> E-mail</button>
        </span>
        <span class="me-2 float-end hidden-print">
        <select name="email" id="email" class="form-control col-sm-3 hidden-print">
            <?php for ($i=0; $i < count($users); $i++) { if($users[$i]['email'] != '') { ?>
                <option value="<?php echo $users[$i]['email']; ?>"><?php echo $users[$i]['nome']; ?></option>
                <?php } } ?>
            </select>
        </span>
        <?php echo $EMPRESA_REDUZIDO; ?> #<?php echo $venda['id']; ?>      <?php echo $venda['dataf']; ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-header -->
    <div class="invoice-header">
        <div class="row jusfity-content-between">
            <div class="invoice-from">
                <small>cliente</small>
                <address class="mt-2px mb-2px">
                    <strong class="text-inverse"><?php echo $pessoa['nome']; ?></strong><br />
                    <?php echo $pessoa['cpf']."<br />"; ?>
                    <?php echo $pessoa['rua'].", ".$pessoa['numero']."<br />"; ?>
                    <?php echo $pessoa['complemento'] != '' ? $pessoa['complemento']."<br />" : ""; ?>
                    <?php echo $pessoa['bairro'].", ".$pessoa['cidade']."<br />"; ?>
                    Fone: <?php echo $pessoa['celular']; ?>
                </address>
            </div>
            <div class="invoice-from">
                <small>Vendedor</small>
                <address>
                    <strong class="text-inverse"><?php echo $venda['nome_vendedor']; ?></strong><br />
                </address>
            </div>
            <div class="invoice-from">
                <small>Observação</small>
                <address>
                    <strong class="text-inverse"><?php echo $venda['endereco']; ?></strong><br />
                </address>
            </div>
        </div>
    </div>
    <!-- END invoice-header -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th class="text-center" width="10%">VALOR UNIT.</th>
                        <th class="text-center" width="10%">QUANTIDADE</th>
                        <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                            <th class="text-end" width="20%">VALOR COMISSÃO</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i=0; $i < count($produtos); $i++) { ?>
                    <tr>
                        <td>
                            <span class="text-inverse"><?php echo $produtos[$i]['nome']." #".$produtos[$i]['tamanho']; ?></span>
                        </td>
                        <td class="text-center">R$ <?php echo number_format($produtos[$i]['valor_unit']/100, 2, ",", '.'); ?></td>
                        <td class="text-center"><?php echo $produtos[$i]['quantidade']; ?></td>
                        <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                            <td class="text-end">R$ <?php echo number_format(($produtos[$i]['valor_total']* $COMISSAO_PERCENT)/100, 2, ",", '.'); ?></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Qtde. produtos: <?php echo count($produtos); ?></th>
                        <th></th>
                        <th>Qtde. peças: <?php echo array_sum(array_column($produtos, 'quantidade')); ?></th>
                        <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- END table-responsive -->
        <!-- BEGIN invoice-price -->
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <?php if($venda['desconto'] > 0){ ?>
                        <div class="sub-price">
                            <small>DESCONTO</small>
                            <span class="text-inverse">R$ <?php echo number_format($venda['desconto']/100, 2, ",", '.'); ?></span>
                        </div>
                    <?php } ?>
                    <div class="sub-price">
                        <small>TOTAL</small>
                        <span class="text-inverse">R$ <?php echo number_format(($venda['valor']-$venda['desconto'])/100, 2, ",", '.'); ?></span>
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                    </div>
                    <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                    <div class="invoice-price-right">
                        <small>COMISSÃO</small> <span class="fw-bold">R$ <?php echo number_format(($venda['valor_comissao'])/100, 2, ",", '.'); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if($JUROS == 1 && $venda['prevenda'] == 0){ ?>
        <div class="">
            <span style="font-size:x-large">Após o vencimento, será cobrado juros de 5% ao mês e multa de 1%.</span>
            <span style="font-size:x-large">Pix para pagamento das parcelas: Cpf 135.708.326-27</span>
        </div>
        <?php } ?>
        <?php if(isset($pagamentos) && count($pagamentos) > 0){ ?>
            <!-- END invoice-price -->
            <div class="table-responsive col-sm-6">
                <table class="table table-invoice">
                    <thead>
                        <tr>
                            <th class="text-end">#</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Forma de pagamento</th>
                            <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                                <th class="text-center">Comissão</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i < count($pagamentos); $i++) { ?>
                        <tr>
                            <td class="text-center"><?php echo $i+1; ?></td>
                            <td class="text-center">R$ <?php echo number_format($pagamentos[$i]['valor']/100, 2, ",", '.'); ?></td>
                            <td class="text-center">
                                <span class="text-inverse"><?php echo $pagamentos[$i]['nome']; ?></span>
                            </td>
                            <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                                <td class="text-center">R$ <?php echo number_format(($pagamentos[$i]['valor']*$COMISSAO_PERCENT)/100, 2, ",", '.'); ?></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <?php if(isset($parcelas) && count($parcelas) > 0){ ?>
        <!-- END invoice-price -->
        <div class="table-responsive col-sm-6">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th class="text-end">#</th>
                        <th class="text-center">Valor parcela</th>
                        <th class="text-center">Vencimento</th>
                        <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                                <th class="text-center">Comissão</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i=0; $i < count($parcelas); $i++) { ?>
                    <tr>
                        <td class="text-center"><?php echo $i+1; ?></td>
                        <td class="text-center">R$ <?php echo number_format($parcelas[$i]['valor_pag']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">
                            <span class="text-inverse"><?php echo $parcelas[$i]['vencimentof']; ?></span>
                        </td>
                        <?php if($venda['comissao'] == 1 && $vendedor == 1){ ?>
                            <td class="text-center">R$ <?php echo number_format(($parcelas[$i]['valor_pag']*$COMISSAO_PERCENT)/100, 2, ",", '.'); ?></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
    <!-- END invoice-content -->
    

</div>
<!-- END invoice -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var vendedor = <?php echo safe_json_encode($vendedor); ?>;
$(document).ready(function() {
    $(document).on("click", ".btnRecibo", function() {

        let dados = "id=" + $(this).val()+"&vendedor="+vendedor;
        dados += "&email=" + $("#email").val();
        dados += "&nome=" + $("#email option:selected").val();
 
        // console.log(dados);
        $.post("components/venda/export/recibo_silviafaria.php", dados,
            function(data) {
                // console.log(data);
                debugger
                if (data != false) {
                    location.reload();
                }

            }, "html");
    });
});
</script>