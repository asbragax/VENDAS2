<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlPrestacaoVendedor'];

    $pagdao = new Pessoa_crediarioDAO();
    $conta = $pagdao->getUmaParcela($id);
    $parcelas = $pagdao->listar_parcelas($conta['id_crediario']);

    $pagdao = new VendaDAO();
    $venda = $pagdao->getPorIdDetails($conta['id_venda']);

    $pagdao = new PessoaDAO();
    $pessoa = $pagdao->getPorIdAssoc($venda['cliente']);

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
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnRecibo" value="id=<?php echo $id; ?>"><i class="fa fa-paper-plane t-plus-1 text-info fa-fw fa-lg"></i> E-mail</button>
        </span>
        <span class="me-2 float-end hidden-print">
        <select name="email" id="email" class="form-control col-sm-3">
            <?php for ($i=0; $i < count($users); $i++) { if($users[$i]['email'] != '') { ?>
                <option value="<?php echo $users[$i]['email']; ?>"><?php echo $users[$i]['nome']; ?></option>
                <?php } } ?>
            </select>
        </span>
        <?php echo $EMPRESA_REDUZIDO; ?> #<?php echo $venda['id']; ?>      <?php echo $venda['dataf']; ?>
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
                        <th><strong>Nome: </strong> <br><?php echo $venda['nome']; ?></th>
                        <th><strong>Celular: </strong> <br><?php echo $pessoa['celular']; ?></th>
                        <th><strong>Data venda:</strong> <br><?php echo $venda['dataf']; ?></th>
                        <th colspan="2"><strong>Vendedor:</strong> <br><?php echo $venda['nome_vendedor']; ?></th>
                    </tr>
                    <tr class="border-bottom border-2 border-dark">
                        <th><strong>Data pag:</strong> <br><?php echo $conta['data_pagf']; ?></th>
                        <th><strong>Valor: </strong><br><?php echo "R$ " . number_format($conta['valor_pag'] / 100, 2, ',', '.'); ?></th>
                        <th><strong>Juros: </strong><br><?php echo "R$ " . number_format($conta['juros'] / 100, 2, ',', '.'); ?></th>
                        <th><strong>Total: </strong><br><?php echo "R$ " . number_format(($conta['juros']+$conta['valor_pag']) / 100, 2, ',', '.'); ?></th>
                        <th class="text-danger"><strong>Comissão: </strong><br><?php echo "R$ " . number_format((($conta['juros']+$conta['valor_pag'])*$COMISSAO_PERCENT) / 100, 2, ',', '.'); ?></th>
                    </tr>
                    <tr class="border-bottom border-2 border-dark">
                        <th colspan="5"><strong>Observação: </strong> <br><?php echo $conta['observacao']; ?></th>
                    </tr>
                </thead>
            </table>
            <table class="table table-invoice">
                <?php if(isset($parcelas) && count($parcelas) > 0){ ?>

                <thead class="pt-35px">
                    <tr>
                        <th class="text-center fs-18px" colspan="6">Parcelas</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Valor parcela</th>
                        <th>Juros</th>
                        <th>Total</th>
                        <th class="text-center" width="10%">Vencimento</th>
                        <th class="text-end" width="20%">Forma pag.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $emaberto = 0; $pago = 0;
                    for ($i=0; $i < count($parcelas); $i++) {  
                        $valor_juros = 0;
                        if($parcelas[$i]['vencimento'] < date('Y-m-d') && $parcelas[$i]['flag'] == 0){
                            $earlier = new DateTime($parcelas[$i]['vencimento']);
                            $later = new DateTime(date('Y-m-d'));
                            
                            $diff = $later->diff($earlier);
                            // echo $dias;
                            // echo (($JUROS_MORA * $conta['valor_pag'])/30) * $dias;
                            $valor_juros = ($parcelas[$i]['valor_pag'] * $JUROS_AO_MES) + ((($JUROS_MORA * $parcelas[$i]['valor_pag'])/30) * $diff->d);
                            $juros = 1;
                        }else{
                            $juros = 0;
                        }
                            
                            if($parcelas[$i]['pagamento'] != ''){
                                $pago += $parcelas[$i]['valor_pag'] + $parcelas[$i]['juros'];
                            }else{

                            $emaberto += $parcelas[$i]['valor_pag'];
                        }
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $i+1; ?></td>
                        <td class="text-center">R$ <?php echo number_format($parcelas[$i]['valor_pag']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">R$ <?php echo $juros == 1 ? number_format($valor_juros/100, 2, ",", '.') : number_format($parcelas[$i]['juros']/100, 2, ",", '.'); ?></td>
                        <td class="text-center">R$ <?php echo $juros == 1 ? number_format(($parcelas[$i]['valor_pag']+$valor_juros)/100, 2, ",", '.') : number_format(($parcelas[$i]['valor_pag']+$parcelas[$i]['juros'])/100, 2, ",", '.'); ?></td>
                        <td>
                            <span class="text-inverse"><?php echo $parcelas[$i]['vencimentof']; ?></span>
                        </td>
                        <td class="text-center"><?php echo $parcelas[$i]['flag'] == 1 ? $parcelas[$i]['pagamento'] : ""; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th class="text-end">TOTAL PAGO:</th>
                        <th>R$ <?php echo number_format($pago/100, 2, ",", '.'); ?></th>
                        <th class="text-end">TOTAL RESTANTE:</th>
                        <th>R$ <?php echo number_format($emaberto/100, 2, ",", '.'); ?></th>
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
        $.post("components/caixa/view/export/recibo_pagamento_vendedor.php", dados,
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