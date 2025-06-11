<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
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


$dao = new UserDAO();
$vendedores = $dao->listar_under_3();

if($_SESSION['nivel'] > 3){
    $users = $dao->listar_all_levelDesc();
}else{
    $users = $dao->listar_funcionariosDesc();   
}

if(isset($_POST['vendedor'])){
    $vendedor = $_POST['vendedor'];
}else{
    $vendedor = $vendedores[0]['id'];
}

$key = array_search($vendedor, array_column($vendedores, 'id'));
$dao = new VendaDAO();
$vendas = $dao->listar_por_vendedor_periodo($vendedor, 0, $dataini, $datafim);

$total = 0;
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <!-- <h4 class="panel-title">Relatório de vendas</h4> -->
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-7">
                    <label class="form-label">Período</label>
                    <div id="advance-daterange" name="datepicker" class="btn btn-default border-primary d-flex text-start align-items-center">
                        <span class="flex-1"></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="hidden" name="dtini" id="dtini" value="<?php echo $dataini; ?>">
                    <input type="hidden" name="dtfim" id="dtfim" value="<?php echo $datafim; ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Vendedor</label>
                    <select class="select2 form-control" name="vendedor" id="vendedor" required>
                        <?php for ($i = 0; $i < count($vendedores); $i++) { ?>
                            <option value="<?php echo $vendedores[$i]['id']; ?>" <?php echo $vendedor == $vendedores[$i]['id'] ? "selected" : ""; ?>>
                                <?php echo $vendedores[$i]['nome']; ?>
                            </option>
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
        <span class="me-2 float-end hidden-print">
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <span class="me-2 float-end hidden-print">
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnRecibo"><i class="fa fa-paper-plane t-plus-1 text-info fa-fw fa-lg"></i> E-mail</button>
        </span>
        <span class="me-2 float-end hidden-print">
        <select name="email" id="email" class="form-control col-sm-3">
            <?php for ($i=0; $i < count($users); $i++) { if($users[$i]['email'] != '') { ?>
                <option value="<?php echo $users[$i]['email']; ?>"><?php echo $users[$i]['nome']; ?></option>
                <?php } } ?>
            </select>
        </span>
        COMISSÕES DE VENDAS POR VENDEDOR (<?php echo $vendedores[$key]['nome']; ?>)      <?php echo $dtini." à ".$dtfim; ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive overflow-hidden">
            <table class="table table-invoice">
                <?php 
                        $dao = new Venda_produtoDAO();
                        $total = array_sum(array_column($vendas, 'valor_comissao'));
                        for ($z=0; $z < count($vendas); $z++) {  
                            $produtos = $dao->listar($vendas[$z]['id']);
                            ?>
                    <thead>
                        <tr class="text-center">
                            <th>Id Venda</th>
                            <th>Data Venda</th>
                            <th colspan="2">Cliente</th>
                            <th>Comissão</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="text-center">
                        <td><a href="?dtlVenda=<?php echo $vendas[$z]['id']; ?>" target="_blank" rel="noopener noreferrer"><?php echo $vendas[$z]['id']; ?></a></td>
                        <td><?php echo $vendas[$z]['dataf']; ?></td>
                        <td colspan="2"><?php echo $vendas[$z]['nome_cliente']; ?></td>
                        <td><?php echo number_format($vendas[$z]['valor_comissao']/100, 2, ",", "."); ?></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="5" class="text-center fw-700">PRODUTOS</td>
                    </tr>
                    <tr class="text-center">
                        <th>Referência</th>
                        <th colspan="2">Nome</th>
                        <th>Tamanho</th>
                        <th>Quantidade</th>
                    </tr>
                    <?php for ($i=0; $i < count($produtos); $i++) { ?>
                    <tr class="text-center">
                        <td><?php echo $produtos[$i]['id']; ?></td>
                        <td colspan="2"><?php echo $produtos[$i]['nome']; ?></td>
                        <td><?php echo $produtos[$i]['tamanho']; ?></td>
                        <td><?php echo $produtos[$i]['quantidade']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php } ?>
                <tfoot>
                    <tr class="fw-800">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-end">Total de comissão:</td>
                        <td>R$ <?php echo number_format($total/100, 2, ",", "."); ?></td>
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

    
    $(document).on("click", ".btnRecibo", function(e) {
        e.preventDefault();
        let dados = "vendedor=" + $("#vendedor").val();
        dados += "&nome_vendedor=" + $('#vendedor :selected').text().trim();
        dados += "&dtini=" + $("#dtini").val();
        dados += "&dtfim=" + $("#dtfim").val();
        dados += "&dataini=" + moment($("#dtini").val()).format("DD/MM/YYYY");
        dados += "&datafim=" + moment($("#dtfim").val()).format("DD/MM/YYYY");
        dados += "&email=" + $("#email").val();
        dados += "&nome=" + $("#email option:selected").text();
        console.log(dados);
        $.post("components/relatorio/export/comissao.php", dados,
            function(data) {
                console.log(data);
                debugger
                if (data != false) {
                    location.reload();
                }

        }, "html");
    });
});
</script>
