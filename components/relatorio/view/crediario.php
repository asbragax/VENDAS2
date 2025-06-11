<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice.css">
<?php

if (isset($_POST['dtini'])) {
    $dtini = date('d/m/Y', strtotime($_POST['dtini']));
    $dataini = $_POST['dtini'];

    $dtfim = date('d/m/Y', strtotime($_POST['dtfim']));
    $datafim =  date($_POST['dtfim']);
} else {
    $dtini = date('d/m/Y');
    $dataini = date('Y-m-d');

    $dtfim = date('d/m/Y');
    $datafim = date('Y-m-d');
}

$dao = new VendaDAO();
$vendas = $dao->crediario_semana($dataini, $datafim);

include_once("components/conta/action/listar_pagamento.php");
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Relatório de crediário</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-8">
                    <div id="advance-daterange" name="datepicker" class="btn btn-default border-primary d-flex text-start align-items-center">
                        <span class="flex-1"></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="hidden" name="dtini" id="dtini" value="<?php echo $dataini; ?>">
                    <input type="hidden" name="dtfim" id="dtfim" value="<?php echo $datafim; ?>">
                </div>
                <div class="col-md-12 mt-2 text-end">
                    <!-- SALVAR -->
                    <button type="submit" class="btn btn-info float-end mx-1" name="buscar">
                        <span class="fa fa-search me-1"></span>
                        Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div data-size="A4" class="pagina p-0">
    <div class="px-0 mx-0 container" style="max-width:100vw !important">
        <div class="table-responsive">
            <?php 
             if(count($vendas) > 0){
                $dao = new Venda_produtoDAO();
                $pdao = new Venda_pagamentoDAO();
                $ents = 0;
                for ($i=0; $i < count($vendas); $i++) { 
                    $itens = $dao->listar($vendas[$i]['id']); 
                    $pagamentos = $pdao->listar($vendas[$i]['id']);
            ?>
                <table class="table table-sm table-bordered text-center">
                    <thead class="bg-primary">
                        <th>Cliente: <?php echo $vendas[$i]['nome']; ?></th>
                        <th>Data:  <?php echo $vendas[$i]['dataf']; ?></th>
                        <th></th>
                        <th><?php echo $vendas[$i]['entrega'] == 1 ? "ENTREGA" : "LOJA"; ?></th>
                    </thead>
                    <tbody>
                        <tr class="fw-700">
                            <td>Quantidade</td>
                            <td>Item</td>
                            <td>Valor Unit.</td>
                            <td>Valor Total</td>
                        </tr>
                        <?php for ($x=0; $x < count($itens); $x++) { ?>
                        <tr>
                            <td>
                                <?php echo $itens[$x]['quantidade']; ?>
                                <?php echo $itens[$x]["kg"] == 1 ? " gr" : " un"; ?>
                            </td>
                            <td><?php echo $itens[$x]['nome']; ?></td>
                            <td>
                                R$ <?php echo number_format($itens[$x]['valor_unit']/100, 2, ",", "."); ?>
                                <?php echo $itens[$x]["kg"] == 1 ? " / kg" : ""; ?>
                            </td>
                            <td>
                                R$
                                <?php echo $itens[$x]["kg"] == 1 ? number_format(($itens[$x]['valor_total']/1000)/100, 2, ",", ".") : number_format($itens[$x]['valor_total']/100, 2, ",", "."); ?>
                            </td>
                        </tr>   
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th><?php echo $vendas[$i]['entrega'] == 1 ? $vendas[$i]['endereco'] : ""; ?></th>
                            <th colspan='2'>
                                <?php 
                                    for ($x = 0; $x < count($pagamentos); $x++) {
                                        if($pagamentos[$x]["id_pagamento"] != 98){
                                            echo $pagamentos[$x]["nome"]."; ";
                                        }else{
                                            $ents += $pagamentos[$x]["valor"];
                                            echo "Crediário; ";
                                        }
                                    }
                                    $pagamentos = null;
                                ?>
                            </th>
                            <th>
                                Desconto: <?php echo number_format($vendas[$i]['desconto']/100, 2, ",", "."); ?>
                                <br>
                                Valor total: <?php echo number_format(($vendas[$i]['valor']-$vendas[$i]['desconto'])/100, 2, ",", "."); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center">
                    <thead class="bg-info color-black">
                        <tr>
                            <th class="text-end">TOTAL:</th>
                            <th><?php echo number_format($ents/100, 2, ",", "."); ?></td></th>
                        </tr>
                    </thead>
                </table>
            <?php } }else{ ?>
                <h1 class="text-center">SEM CREDIÁRIOS NO PERÍODO SELECIONADO!</h1>
           <?php } ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){

});
</script>
