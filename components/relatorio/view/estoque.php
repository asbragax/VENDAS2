<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php

if(isset($_POST['sociedade'])){
    $sociedade = $_POST['sociedade'];
}else{
    $sociedade = 0;
}

$dao = new ProdutoDAO();
$listaProdutos = $dao->listarSociedade($sociedade);
$total = 0;
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <!-- <h4 class="panel-title">Relatório de vendas</h4> -->
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-6 row">
                    <div class="col-sm-3 pt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sociedade" name="sociedade" value="1" <?php echo $sociedade == 1 ? "checked" : ""; ?> />
                            <label class="form-check-label" for="sociedade">Sociedade</label>
                        </div>
                    </div>
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
        ESTOQUE ATUAL DE PRODUTOS      <?php echo date("d/m/Y"); ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive overflow-hidden">
            <table class="table table-invoice">
            <?php for ($z=0; $z < count($listaProdutos); $z++) { 
                $valorcompra += $listaProdutos[$z]['valor_compra'];
                $valorvenda += $listaProdutos[$z]['valor_venda'];
                $grade = $dao->listar_grade($listaProdutos[$z]['id']); ?>
                <thead>
                    <tr>
                        <th colspan="1"><?php echo $listaProdutos[$z]['referencia']; ?></th>
                        <th colspan="6"><?php echo $listaProdutos[$z]['nome']; ?></th>
                        <th colspan="2">Vl. Custo: <?php echo number_format($listaProdutos[$z]['valor_compra']/100, 2, ",", "."); ?></th>
                        <th colspan="2">Vl. Venda: <?php echo number_format(($listaProdutos[$z]['valor_venda']/100), 2, ",", "."); ?></th>
                        <th colspan="1">Estoque: <?php echo array_sum(array_column($grade, 'quantidade')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php 
                        for ($i=0; $i < count($arr_grades); $i++) { 
                            if($listaProdutos[$z]['grade'] == $i){  
                                for ($x=0; $x < 12; $x++) { 
                                    if($arr_grades_desc[$i][$x] != ''){
                                        $key = null;
                                        $key = array_search($arr_grades_desc[$i][$x], array_column($grade, 'tipo'));   
                                        $total += $grade[$key]['quantidade'];
                                        ?>
                            <td class="text-center"><?php echo $grade[$key]['tipo']."<br> [".$grade[$key]['quantidade']."]"; ?></td>
                        <?php }else{ ?>
                            <td class="text-center"></td>
                        <?php  } } } } ?>  
                    </tr> 
                </tbody>
                <?php } ?>
                <tfoot>
                    <tr class="fw-800">
                        <td colspan="2" class="text-end">Total de peças em estoque:</td>
                        <td colspan="1"><?php echo $total; ?></td>
                        <td colspan="2" class="text-end">Valor total de custo:</td>
                        <td colspan="1">R$ <?php echo number_format(($valorcompra/100), 2, ",", ".");  ?></td>
                        <td colspan="2" class="text-end">Valor total para venda:</td>
                        <td colspan="1">R$ <?php echo number_format(($valorvenda/100), 2, ",", "."); ?></td>
                        <td colspan="2" class="text-end"></td>
                        <td colspan="1"></td>
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
