<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php

include_once "components/produto/action/listar_produto.php"; 
if(isset($_POST['todo_periodo'])){
    $periodo = '1';
}else{
    $periodo = '0';
}
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

if(isset($_POST['produto'])){
    $produto = $_POST['produto'];
    $cod = $_POST['produto'];
}else{
    $produto = $listaProdutos[0]['id'];
    $cod = $listaProdutos[0]['id'];
}

if(isset($_POST['todos_produtos']) && $_POST['todos_produtos'] == "*"){
    $produto = '*';
}
// echo 1;
if(isset($_POST['sociedade'])){
    $sociedade = $_POST['sociedade'];
}else{
    $sociedade = 0;
}
if(isset($_POST['status'])){
    $status = $_POST['status'];
}else{
    $status = 0;
}
if($produto != '*'){
    
    $key = array_search($produto, array_column($listaProdutos, 'id'));
}
$dao = new Venda_produtoDAO();
$vendas = $dao->relatorio_produtos($periodo, $dataini, $datafim, $produto, $sociedade, $status);
// echo 1;

$total = 0;
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <!-- <h4 class="panel-title">Relatório de vendas</h4> -->
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-4 row">
                    <div class="col-sm-4">
                        <label class="form-label">Referência</label>
                        <input type="text" name="cod" id="cod" value="<?php echo $cod; ?>"  class="form-control border-primary" autofocus />
                    </div>
                    <div class="col-sm-8 pt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="todos_produtos" name="todos_produtos" value="*" <?php echo $produto == '*' ? "checked" : ""; ?> />
                            <label class="form-check-label" for="todos_produtos">Todos os produtos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sociedade" name="sociedade" value="1" <?php echo $sociedade == 1 ? "checked" : ""; ?> />
                            <label class="form-check-label" for="sociedade">Sociedade</label>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <select class="select2 form-control" name="produto" id="produto" required>
                        <?php for ($i = 0; $i < count($listaProdutos); $i++) { ?>
                            <option value="<?php echo $listaProdutos[$i]['id']; ?>" <?php echo $produto == $listaProdutos[$i]['id'] ? "selected" : ""; ?>>
                            <?php echo $listaProdutos[$i]['referencia']; ?> - <?php echo $listaProdutos[$i]['nome']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Status da venda</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="status0" name="status" value="0" checked />
                        <label class="form-check-label" for="status0">Efetivado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="status1" name="status" value="1" <?php echo $status == 1 ? "checked" : ""; ?> />
                        <label class="form-check-label" for="status1">Consignado</label>
                    </div>
                </div>
                <div class="form-group mb-2 col-sm-6">
                    <div class="form-group mb-3 col-sm-12">
                        <label class="form-label">Período</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="todo_periodo" name="todo_periodo" value="1" <?php echo $periodo == 1 ? "checked" : ""; ?> />
                            <label class="form-check-label" for="todo_periodo">Desde o início</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="por_periodo" name="todo_periodo" value="0" <?php echo $periodo == 0 ? "checked" : ""; ?> />
                            <label class="form-check-label" for="por_periodo">Por período</label>
                        </div>
                    </div>
                    
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
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company">
        <span class="float-end hidden-print">
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <?php if($produto == "*"){ echo "Todos os produtos"; }else{ ?>
        Referência:     <?php echo $listaProdutos[$key]['referencia']." - ".$listaProdutos[$key]['nome']; ?><?php } ?>            Período: <?php echo $_POST['todo_periodo'] == '1' ? "Todo o período" : $dtini." à ".$dtfim; ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive overflow-hidden">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Situação da venda</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                <?php for ($i=0; $i < count($vendas); $i++) { ?>
                    <tr>
                        <td><?php echo $vendas[$i]['dataf']; ?></td>
                        <td><?php echo $vendas[$i]['prevenda'] == 1 ? "Consignado" : "Efetivado"; ?></td>
                        <td><?php echo $vendas[$i]['nome_cliente']; ?></td>
                        <td><?php echo $vendas[$i]['nome_vendedor']; ?></td>
                        <td><?php echo $vendas[$i]['nome']." #".$vendas[$i]['tamanho']; ?></td>
                        <td><?php echo $vendas[$i]['quantidade']; ?></td>
                        <td><?php echo number_format(($vendas[$i]['valor_total']/100), 2, ",", "."); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="fw-800">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-end">Qtde Total:</td>
                        <td><?php echo array_sum(array_column($vendas, 'quantidade')); ?></td>
                        <td class="text-end">Valor Total:</td>
                        <td><?php echo number_format((array_sum(array_column($vendas, 'valor_total')))/100, 2, ",", "."); ?></td>
                    </tr>
                </tfoot>
            </table>            
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
var TAM_COD = <?php echo safe_json_encode($TAM_COD); ?>;
var produtos = <?php echo safe_json_encode($listaProdutos); ?>;
$(document).ready(function(){
    $(".select2").select2({ 
        placeholder: "Selecione",
        containerCssClass: "border-primary"
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $(document).on("keyup", "#cod", function() {
        var valor = $("#cod").val();
        if(valor.length >= TAM_COD){
            $("#produto").val(valor).change();
        }
    });
});
</script>
