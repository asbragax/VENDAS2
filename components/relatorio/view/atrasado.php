<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php

if(isset($_POST['vendedor'])){
    $vendedor = $_POST['vendedor'];
}else{
    $vendedor = '*';
}
include_once "components/pessoa/action/listar_pessoa.php"; 

$dao = new UserDAO();
$vendedores = $dao->listar_under_3();

if(isset($_POST['cliente'])){
    $cliente = $_POST['cliente'];
}else{
    $cliente = '*';
}

if($cliente != '*'){
    $dao = new PessoaDAO();
    $pessoa = $dao->getPorIdAssoc($cliente);
}


$dao = new Pessoa_crediarioDAO();
$vencidas = $dao->listar_vencidas_vendedor_cliente(date("Y-m-d"), $vendedor, $cliente);

$total = 0;

$pagdao = new UserDAO();
if($_SESSION['nivel'] > 3){
    $users = $pagdao->listar_all_levelDesc();
}else{
    $users = $pagdao->listar_funcionariosDesc();   
}

// include_once("components/conta/action/listar_pagamento.php");
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Relatório de parcelas atrasadas</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select class="select2 form-control" name="cliente" id="cliente">
                            <option value="*">Todos</option>
                            <?php for ($i = 0; $i < count($listaPessoas); $i++) { ?>
                                <option value="<?php echo $listaPessoas[$i]['id']; ?>" <?php echo $cliente == $listaPessoas[$i]['id'] ? "selected" : ""; ?>>
                                    <?php echo $listaPessoas[$i]['nome']; ?>
                                </option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Vendedor</label>
                    <select class="select2 form-control" name="vendedor" id="vendedor">
                            <option value="*">Todos</option>
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
            <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnRecibo" value="<?php echo $id; ?>"><i class="fa fa-paper-plane t-plus-1 text-info fa-fw fa-lg"></i> E-mail</button>
        </span>
        <span class="me-2 float-end hidden-print">
        <select name="email" id="email" class="form-control col-sm-3">
            <?php for ($i=0; $i < count($users); $i++) { if($users[$i]['email'] != '') { ?>
                <option value="<?php echo $users[$i]['email']; ?>"><?php echo $users[$i]['nome']; ?></option>
                <?php } } ?>
            </select>
        </span>
        <?php echo $EMPRESA_REDUZIDO; ?> - RELATÓRIO DE VALORES EM ATRASO
    </div>
    <!-- END invoice-company -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive">
            <table class="table table-invoice">
                <thead class="bg-primary">
                    <th>Id venda</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <?php if($JUROS == 1){ ?><th>Valor</th>
                    <th>Juros</th><?php } ?>
                    <th>Total</th>
                    <th>Vencimento</th>
                    <th class="hidden-print btn-control"></th>
                </thead>
                <tbody>
                    <?php 
                    if(isset($vencidas)){
                        $totaljuros = 0;
                    for ($i=0; $i < count($vencidas); $i++) { 
                        if($JUROS == 1){ 
                            $earlier = new DateTime($vencidas[$i]['vencimento']);
                            $later = new DateTime(date('Y-m-d'));
                    
                            $diff = $later->diff($earlier);
                            // echo (($JUROS_MORA * $conta['valor_pag'])/30) * $dias;
                            if($diff->invert == 1){
                                $valor_juros = ($vencidas[$i]['valor_pag'] * $JUROS_AO_MES) + ((($JUROS_MORA * $vencidas[$i]['valor_pag'])/30) * $diff->days);
                                
                            }else{
                                $valor_juros = 0;
                            }

                            $totaljuros += $valor_juros;
                        }
                    ?>
                    <tr>
                        <td><?php echo $vencidas[$i]["id_venda"]; ?></td>
                        <td><?php echo $vencidas[$i]["nome_vendedor"]; ?></td>
                        <td><?php echo $vencidas[$i]["nome"]; ?></td>
                        <?php if($JUROS == 1){ ?> <td>R$ <?php echo number_format($vencidas[$i]["valor_pag"]/100, 2, ",", "."); ?></td>
                        <td>R$ <?php echo number_format($valor_juros/100, 2, ",", "."); ?></td><?php } ?>
                        <td><strong>R$ <?php echo number_format(($vencidas[$i]["valor_pag"] + $valor_juros)/100, 2, ",", "."); ?></strong></td>
                        <td><?php echo $vencidas[$i]["vencimentof"]; ?></td>
                        <td class="text-center hidden-print btn-control">
                            <a class="btn btn-success btn-icon btn-sm" href="?pagPrestacao=<?php echo $vencidas[$i]["id"]; ?>"><span class="fa fa-dollar-sign"></span>
                            </a>
                            <?php if($_SESSION['nivel'] >= 2){ ?>
                                <a class="btn btn-warning btn-icon btn-sm" href="?edtVenda=<?php echo $vencidas[$i]["id_venda"]; ?>"><span class="fa fa-edit"></span>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } 
                    }?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>TOTAIS</th>
                        <?php if($JUROS == 1){ ?><th>R$ <?php echo number_format(array_sum(array_column($vencidas,"valor_pag"))/100, 2, ",", "."); ?></th>
                        <th>R$ <?php echo number_format($totaljuros/100, 2, ",", "."); ?></th><?php } ?>
                        <th><strong>R$ <?php echo number_format((array_sum(array_column($vencidas,"valor_pag")) + $totaljuros)/100, 2, ",", "."); ?></strong></th>
                        <th class="text-center hidden-print btn-control"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- END invoice-content -->
    

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
    $(".select2").select2({ 
        containerCssClass: "border-primary"
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $(document).on("click", ".btnRecibo", function() {

        let dados = "cliente=" + $('#cliente').val();
        dados += "&vendedor=" + $("#vendedor").val();
        dados += "&email=" + $("#email").val();
        dados += "&nome=" + $("#email option:selected").text();
        // console.log(dados);
        $.post("components/relatorio/export/atrasado.php", dados,
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
