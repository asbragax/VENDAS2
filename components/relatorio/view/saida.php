<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
include_once("components/conta/action/listar_pagamento.php");
include_once("components/fornecedor/action/listar_fornecedor.php");

if (isset($_POST['dtini'])) {
    $dtini = date('d/m/Y', strtotime($_POST['dtini']));
    $dataini = $_POST['dtini'];

    $dtfim = date('d/m/Y', strtotime($_POST['dtfim']));
    $datafim =  date($_POST['dtfim']);
} else {
    $dtini = date('d/m/Y', strtotime(date('Y-m-d')));
    $dataini = date('Y-m-d', strtotime(date('Y-m-d')));

    $dtfim = date('d/m/Y');
    $datafim = date('Y-m-d');
}

if (isset($_POST['status'])) {
    $status = $_POST['status'];
} else {
    $status = 1;
}

if (isset($_POST['pagamento'])) {
    $pagamento = $_POST['pagamento'];
} else {
    $pagamento = "*";
}

if (isset($_POST['fornecedor'])) {
    $fornecedor = $_POST['fornecedor'];
} else {
    $fornecedor = "*";
}

$dao = new ApagarDAO();
if($status == 0){
    $apagar = $dao->listar_parcelas_abertas_periodo($dataini, $datafim, $fornecedor);
}else{
    $apagar = $dao->listar_pagas_periodo($dataini, $datafim, $pagamento, $fornecedor);
    $apagar2 = $dao->listar_parcelas_pagas_periodo($dataini, $datafim, $pagamento, $fornecedor);
    
    $apagar = array_merge($apagar, $apagar2);
}

?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <!-- <h4 class="panel-title">Relatório de vendas</h4> -->
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-2 col-sm-8">
                    <label class="form-label">Período</label>
                    <div id="advance-daterange" name="datepicker" class="btn btn-default border-primary d-flex text-start align-items-center">
                        <span class="flex-1"></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="hidden" name="dtini" id="dtini" value="<?php echo $dataini; ?>">
                    <input type="hidden" name="dtfim" id="dtfim" value="<?php echo $datafim; ?>">
                </div>
                <div class="form-group mb-2 col-md-2">
                    <label class="form-label">Tipo</label>
                    <select class="form-control select2" name="status" id="status">
                        <option value="1" <?php echo $status == 1 ? "selected" : ""; ?>>Pago</option>
                        <option value="0" <?php echo $status == 0 ? "selected" : ""; ?>>Em aberto</option>
                    </select>
                </div>
                <div class="form-group mb-2 col-md-3 divhide">
                    <label class="form-label">Forma pagamento</label>
                    <select class="form-control select2" name="pagamento" id="pagamento">
                        <option value="*" <?php echo $status == "*" ? "selected" : ""; ?>>Todos</option>
                        <?php for ($i = 0; $i < count($listaPagamento); $i++) { ?>
                        <option value="<?php echo $listaPagamento[$i]['id']; ?>"
                            <?php echo $pagamento == $listaPagamento[$i]['id'] ? "selected" : ""; ?>>
                            <?php echo $listaPagamento[$i]['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-2 col-md-3">
                    <label class="form-label">Fornecedor</label>
                    <select class="form-control select2" name="fornecedor" id="fornecedor">
                        <option value="*" <?php echo $status == "*" ? "selected" : ""; ?>>Todos</option>
                        <?php for ($i = 0; $i < count($listaFornecedores); $i++) { ?>
                        <option value="<?php echo $listaFornecedores[$i]['id']; ?>"
                            <?php echo $fornecedor == $listaFornecedores[$i]['id'] ? "selected" : ""; ?>>
                            <?php echo $listaFornecedores[$i]['nome']; ?></option>
                        <?php } ?>
                    </select>
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
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company">
        <span class="float-end hidden-print">
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <h3>Relatório de contas a pagar <span
                        class="text-primary"><?php echo $status == 1 ? "quitadas" : "em aberto"; ?></span> de<span
                        class="fw-300"><i> <?php echo $dtini." a ".$dtfim; ?></i></span>
                </h3>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive overflow-hidden">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th class="align-items-center"><?php echo $status == 1 ? "Data pag." : "Vencimento"; ?></th>
                        <th class="align-items-center">Parcela</th>
                        <th class="align-items-center">Valor</th>
                        <?php echo $status == 1 ? '<th class="align-items-center">F. Pagamento</th>' : ""; ?>
                        <th class="align-items-center">Fornecedor</th>
                        <th class="align-items-center">Referência</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($x=0; $x < count($apagar); $x++) { ?>
                    <tr>
                        <td><?php echo $apagar[$x]['vencimentof']; ?></td>
                        <td>
                            <?php echo $apagar[$x]['tipo'] == 1 ? "A vista" : ($apagar[$x]['num']+1)."/".$apagar[$x]['prestacao']; ?>
                        </td>
                        <td><?php echo number_format(($apagar[$x]['valor']+$apagar[$x]['juros'])/100, 2, ",", "."); ?></td>
                        <?php echo $status == 1 ? "<td>".$apagar[$x]['nome_pagamento']."</td>" : ""; ?>
                        <td><?php echo $apagar[$x]['nome_fornecedor']; ?></td>
                        <td><?php echo $apagar[$x]['nome']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="fw-700 fs-lg">
                        <th></th>
                        <th>Total:</th>
                        <th>
                            <?php echo number_format(array_sum(array_column($apagar,'valor'))/100, 2, ",", "."); ?></th>
                        <?php echo $status == 1 ? '<th></th>' : ""; ?>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>            
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
    $(".select2").select2({ 
        placeholder: "Selecione",
        containerCssClass: "border-primary"
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
});
</script>
