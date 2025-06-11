<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlPrestacaoDia'];
    $dtini = $_GET['dtini'];
    $dtfim = $_GET['dtfim'];

    $pagdao = new Pessoa_crediarioDAO();
    $parcelas = $pagdao->relParcelas_dia($id, $dtini, $dtfim);

    $pagdao = new Venda_pagamentoDAO();
    $vendas = $pagdao->relParcelas_dia($id, $dtini, $dtfim);

    $dao = new UserDAO();
    $vendedor = $dao->getPorId($id);

    $pagdao = new UserDAO();
    if($_SESSION['nivel'] > 3){
        $users = $pagdao->listar_all_levelDesc();
    }else{
        $users = $pagdao->listar_funcionariosDesc();   
    }
?>
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company mb-50px">
        <span class="me-2 float-end hidden-print">
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <span class="me-2 float-end hidden-print">
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnRecibo" value="id=<?php echo $id; ?>&dtini=<?php echo $dtini ?>&dtfim=<?php echo $dtfim ?>"><i class="fa fa-paper-plane t-plus-1 text-info fa-fw fa-lg"></i> E-mail</button>
        </span>
        <span class="me-2 float-end hidden-print">
        <select name="email" id="email" class="form-control col-sm-3">
            <?php for ($i=0; $i < count($users); $i++) { if($users[$i]['email'] != '') { ?>
                <option value="<?php echo $users[$i]['email']; ?>"><?php echo $users[$i]['nome']; ?></option>
                <?php } } ?>
            </select>
        </span>
        <?php echo $EMPRESA_REDUZIDO; ?> - RELATÓRIO DE COMISSÕES 
        <hr>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive mt-50px pt-50px">
            <table class="table table-invoice">
                <thead>
                    <tr class="border-bottom border-2 border-dark">
                        <th><strong>Nome: </strong> <br><?php echo $vendedor['nome']; ?></th>
                        <th><strong>Data início: </strong> <br><?php echo date("d/m/Y", strtotime($dtini)); ?></th>
                        <th><strong>Data fim:</strong> <br><?php echo date("d/m/Y", strtotime($dtfim)); ?></th>
                    </tr>
                </thead>
            </table>
            <table class="table table-invoice">
                <?php if((isset($parcelas) && count($parcelas) > 0) || (isset($vendas) && count($vendas) > 0)){ ?>

                <thead class="pt-35px">
                    <tr>
                        <th class="text-center fs-18px" colspan="6">Pagamentos</th>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Juros</th>
                        <th>Total</th>
                        <th>Data Pag.</th>
                        <th>Comissão</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $comissao = 0;
                        for ($i=0; $i < count($vendas); $i++) {  
                            $comissao += $vendas[$i]['valor']*$COMISSAO_PERCENT;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $vendas[$i]['nome_cliente']; ?></td>
                        <td class="text-center">R$ <?php echo number_format($vendas[$i]['valor']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">R$ 0,00</td>
                        <td class="text-center">R$ <?php echo number_format($vendas[$i]['valor']/100, 2, ",", '.'); ?></td>
                        <td><span class="text-inverse"><?php echo $vendas[$i]['dataf']; ?></span></td>
                        <td class="text-center"><?php echo number_format(($vendas[$i]['valor']*$COMISSAO_PERCENT)/100, 2, ",", '.'); ?></td>
                    </tr>
                    <?php } 
                        for ($i=0; $i < count($parcelas); $i++) {  
                            $comissao += ($parcelas[$i]['valor_pag']+$parcelas[$i]['juros'])*$COMISSAO_PERCENT;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $parcelas[$i]['nome_cliente']; ?></td>
                        <td class="text-center">R$ <?php echo number_format($parcelas[$i]['valor_pag']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">R$ <?php echo number_format($parcelas[$i]['juros']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">R$ <?php echo number_format(($parcelas[$i]['valor_pag']+$parcelas[$i]['juros'])/100, 2, ",", '.'); ?></td>
                        <td><span class="text-inverse"><?php echo $parcelas[$i]['data_pagf']; ?></span></td>
                        <td class="text-center"><?php echo number_format((($parcelas[$i]['valor_pag']+$parcelas[$i]['juros'])*$COMISSAO_PERCENT)/100, 2, ",", '.'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th class="text-end">Quantidade de pagamentos:</th>
                        <th><?php echo count($parcelas); ?></th>
                        <th class="text-end">TOTAL DE COMISSÕES:</th>
                        <th>R$ <?php echo number_format($comissao/100, 2, ",", '.'); ?></th>
                    </tr>
                </tfoot>
                <?php } ?>
            </table>
        </div>
        <!-- END table-responsive -->
        
    </div>
    <!-- END invoice-content -->

</div>
<!-- END invoice -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".btnRecibo", function() {
        let dados = $(this).val();
        dados += "&email=" + $("#email").val();
        dados += "&nome=" + $("#email option:selected").val();
        $.post("components/caixa/view/export/recibo_pagamento_dia.php", dados,
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