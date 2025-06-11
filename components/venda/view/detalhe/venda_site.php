<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlVendaSite']; 
    $pagdao = new PrevendaDAO();
    $venda = $pagdao->getPorIdDetails($id);

    // print_r($venda);
    $pagdao = new PessoaDAO();
    $pessoa = $pagdao->getPorIdAssoc($venda['cliente']);
    $pagdao = new Prevenda_produtoDAO();
    $produtos = $pagdao->listar($id);

    // $pagdao = new UserDAO();
    // if($_SESSION['nivel'] > 3){
    //     $users = $pagdao->listar_all_levelDesc();
    // }else{
    //     $users = $pagdao->listar_funcionariosDesc();   
    // }
// ob_start();
?>
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company">
        <span class="me-2 float-end hidden-print">
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnValidate" value="<?php echo $id; ?>"><i class="fa fa-check t-plus-1 text-info fa-fw fa-lg"></i> Validar compra</button>
        </span>
       
        <?php echo $EMPRESA_REDUZIDO; ?>      <?php echo $venda['dataf']; ?>
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
                        <th class="text-center" width="10%">QUANTIDADE EM ESTOQUE</th>
                        <th class="text-end" width="20%">VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dao = new ProdutoDAO();
                    for ($i=0; $i < count($produtos); $i++) { 
                        $grade = $dao->listar_grade_tamanho($produtos[$i]['id_produto'],$produtos[$i]['tamanho']);
                        ?>
                    <tr>
                        <td>
                            <span class="text-inverse"><?php echo $produtos[$i]['id_produto']." - ".$produtos[$i]['nome']." #".$produtos[$i]['tamanho']; ?></span>
                        </td>
                        <td class="text-center">R$ <?php echo number_format($produtos[$i]['valor_unit']/100, 2, ",", '.'); ?></td>
                        <td class="text-center"><?php echo $produtos[$i]['quantidade']; ?></td>
                        <td class="text-center"><?php echo $grade['quantidade']; ?></td>
                        <td class="text-end">R$ <?php echo number_format($produtos[$i]['valor_total']/100, 2, ",", '.'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Qtde. produtos: <?php echo count($produtos); ?></th>
                        <th></th>
                        <th></th>
                        <th>Qtde. peças: <?php echo array_sum(array_column($produtos, 'quantidade')); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- END table-responsive -->
        <!-- BEGIN invoice-price -->
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>TOTAL</small>
                        <span class="text-inverse">R$ <?php echo number_format(($venda['valor']-$venda['desconto'])/100, 2, ",", '.'); ?></span>
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    <!-- END invoice-content -->
    

</div>
<!-- END invoice -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var vendedor = <?php echo safe_json_encode($vendedor); ?>;
$(document).ready(function() {
    $(document).on("click", ".btnValidate", function() {

        let dados = "id=" + $(this).val();
 
        // console.log(dados);
        $.post("components/venda/action/validar_venda.php", dados,
        function(data) {
            // console.log(data);
            debugger
            if (data != false) {
                location.replace('?edtVenda='+data);
            }

        }, "html");
    });
});
</script>