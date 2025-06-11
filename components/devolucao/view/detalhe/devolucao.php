<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlDevolucao'];

    $pagdao = new DevolucaoDAO();
    $devolucao = $pagdao->getPorIdDetails($id);
    $pagdao = new Devolucao_produtoDAO();
    $produtos = $pagdao->listar($id);

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
        <span class="float-end hidden-print">
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
        <?php echo $EMPRESA_REDUZIDO; ?> - DEVOLUÇÃO #<?php echo $devolucao['id_auto']; ?>      <?php echo $devolucao['dataf']; ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-header -->
    <div class="invoice-header">
        <div class="row jusfity-content-between">
            <div class="invoice-from">
                <small>Fornecedor</small>
                <address class="mt-2px mb-2px">
                    <strong class="text-inverse"><?php echo $devolucao['nome']; ?></strong><br />
                    <?php echo $devolucao['cnpj']."<br />"; ?>
                </address>
            </div>
            <div class="invoice-from">
                <small>Tipo de operação</small>
                <address class="mt-2px mb-2px">
                    <strong class="text-inverse"><?php echo $devolucao['tipo'] == 1 ? "Devolução" : "Troca"; ?></strong>
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
                        <th class="text-center" width="10%">REFERÊNCIA</th>
                        <th class="text-center" width="60%">PRODUTO</th>
                        <th class="text-center" width="10%">TAMANHO</th>
                        <th class="text-center" width="20%">QUANTIDADE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $dao = new Devolucao_produtoDAO();
                        for ($i=0; $i < count($produtos); $i++) {
                            // echo $produtos[$i]['id_devolucao']." ".$produtos[$i]['id_produto'];
                            $grade = $dao->listar_grade($produtos[$i]['id_devolucao'], $produtos[$i]['id_produto']);
                            $order = $arr_grades_desc[$produtos[$i]['grade']];
                            usort($grade, function($a, $b) use ($order) {
                                $posA = array_search($a['tipo'], $order);
                                $posB = array_search($b['tipo'], $order);
                                return $posA - $posB;
                            });
                            
                            for ($x=0; $x < count($grade); $x++) { 
                                if($grade[$x]['quantidade'] > 0){
                        ?>
                    <tr>
                        <td class="text-center">
                            <span class="text-inverse"><?php echo $produtos[$i]['id_produto']; ?></span>
                        </td>
                        <td class="text-center"><?php echo $produtos[$i]['nome']; ?></td>
                        <td class="text-center"><?php echo $grade[$x]['tipo']; ?></td>
                        <td class="text-center"><?php echo $grade[$x]['quantidade']; ?></td>
                    
                    </tr>
                    <?php } } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Qtde. referências: <?php echo count($produtos); ?></th>
                        <th></th>
                        <th></th>
                        <th>Qtde. peças: <?php echo array_sum(array_column($produtos, 'quantidade')); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- END table-responsive -->
        <!-- BEGIN invoice-price -->
        <!-- <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>SUBTOTAL</small>
                        <span class="text-inverse">R$ <?php //echo number_format($devolucao['valor']/100, 2, ",", '.'); ?></span>
                    </div>
                     <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                    </div>
                    <div class="sub-price">
                        <small>DESCONTO</small>
                        <span class="text-inverse">R$ <?php //echo number_format($devolucao['desconto']/100, 2, ",", '.'); ?></span>
                    </div> 
                </div>
            </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> <span class="fw-bold">R$ <?php //echo number_format(($devolucao['valor']-$devolucao['desconto'])/100, 2, ",", '.'); ?></span>
            </div>
        </div> -->
        <!-- <div class="invoice-footer">
            <span class="text-muted-700">Após o vencimento, será cobrado juros de 5% ao mês e multa de 1%.</span>
        </div> -->

        <span class="text-justify">
            <h3>Descrição/Motivo:</h3>
            <div style="text-align:justify">
                <?php echo $devolucao['obs']; ?>
            </div>
        </span>
    </div>
    <!-- END invoice-content -->
    

</div>
<!-- END invoice -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".btnRecibo", function() {

    let dados = "id=" + $(this).val();
    dados += "&email=" + $("#email").val();
    dados += "&nome=" + $("#email option:selected").text();

    // console.log(dados);
    $.post("components/devolucao/export/recibo_silviafaria.php", dados,
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