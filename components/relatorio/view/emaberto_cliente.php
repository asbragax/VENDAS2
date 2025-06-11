<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php

include_once "components/pessoa/action/listar_pessoa.php"; 

if(isset($_POST['cliente'])){
    $cliente = $_POST['cliente'];
}else{
    $cliente = '*';
}

if(isset($_POST['vendedor'])){
    $vendedor = $_POST['vendedor'];
}else{
    $vendedor = '*';
}

if($cliente != '*'){
    $dao = new PessoaDAO();
    $pessoa = $dao->getPorIdAssoc($cliente);
}

$dao = new Pessoa_crediarioDAO();
$crediarios = $dao->listar_emaberto_porcliente($cliente, $vendedor);

$dao = new UserDAO();
$vendedores = $dao->listar_under_3();

if($_SESSION['nivel'] > 3){
    $users = $dao->listar_all_levelDesc();
}else{
    $users = $dao->listar_funcionariosDesc();   
}

$total = 0;
$totaljuros = 0;
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <!-- <h4 class="panel-title">Relatório de vendas</h4> -->
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select class="select2 form-control" name="cliente" id="cliente" required>
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
                    <select class="select2 form-control" name="vendedor" id="vendedor" required>
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
        VENDAS EM ABERTO POR CLIENTE (<?php echo $cliente != '*' ? $pessoa['nome'] : "Todos"; ?>)      <?php echo date("d/m/Y"); ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-content -->
    <div class="invoice-content">
        <!-- BEGIN table-responsive -->
        <div class="table-responsive overflow-hidden">
            <table class="table table-invoice mb-15px">
                <?php 
                        $dao = new Pessoa_crediarioDAO();
                        $vdao = new VendaDAO();
                        $dao2 = new Venda_produtoDAO();
                        for ($z=0; $z < count($crediarios); $z++) {  
                            $parcelas = $dao->listar_parcelas_abertas($crediarios[$z]['id']);
                            $todas = $dao->listar_parcelas($crediarios[$z]['id']);
                            $venda = $vdao->getPorIdDetails($crediarios[$z]['id_venda']);
                            $total += array_sum(array_column($parcelas, 'valor_pag'));
                            $itens = $dao2->listar($crediarios[$z]['id_venda']); 
                        ?>
                    <thead>
                        <tr>
                            <th>Venda</th>
                            <th>Data Venda</th>
                            <th colspan="2">Cliente</th>
                            <th>Vendedor</th>
                            <th>Valor</th>
                            <th>Em aberto</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <tr>
                        <td><a href="?dtlVenda=<?php echo $crediarios[$z]['id_venda']; ?>" target="_blank" rel="noopener noreferrer"><?php echo $crediarios[$z]['id_venda']; ?></a></td>
                        <td><?php echo $venda['dataf']; ?></td>
                        <td colspan="2"><?php echo $venda['nome']; ?></td>
                        <td><?php echo $venda['nome_vendedor']; ?></td>
                        <td><?php echo number_format($crediarios[$z]['valor']/100, 2, ",", "."); ?></td>
                        <td><?php echo number_format(array_sum(array_column($parcelas, 'valor_pag'))/100, 2, ",", "."); ?></td>
                    </tr>
                    </tbody>
                    <tbody>
                        <tr class="fw-700">
                            <td>Quantidade</td>
                            <td colspan="5">Item</td>
                            <td>Valor Unit.</td>
                        </tr>
                        <?php for ($x=0; $x < count($itens); $x++) { ?>
                        <tr>
                            <td>
                                <?php echo $itens[$x]['quantidade']; ?>
                            </td>
                            <td colspan="5"><?php echo $itens[$x]['nome']." #".$itens[$x]['tamanho']; ?></td>
                            <td>
                                R$ <?php echo number_format($itens[$x]['valor_unit']/100, 2, ",", "."); ?>
                            </td>
                        </tr>   
                        <?php } ?>
                    </tbody>
                    <tbody>
                    <tr>
                        <td colspan="7" class="text-center fw-700">PARCELAS</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Vencimento</th>
                        <th <?php echo $JUROS == 0 ? "colspan='3'":""; ?>>Status</th>
                        <?php if($JUROS == 1){ ?><th>Valor</th>
                        <th>Juros</th><?php } ?>
                        <th>Total</th>
                    </tr>
                    <?php 
                    
                    for ($i=0; $i < count($todas); $i++) { 
                       if($JUROS == 1){ 
                            if($todas[$i]['flag'] == 0){
                                $earlier = new DateTime($todas[$i]['vencimento']);
                                $later = new DateTime(date('Y-m-d'));
                                
                                $diff = $later->diff($earlier);
                                // echo (($JUROS_MORA * $conta['valor_pag'])/30) * $dias;
                                if($diff->invert == 1){
                                    $valor_juros = ($todas[$i]['valor_pag'] * $JUROS_AO_MES) + ((($JUROS_MORA * $todas[$i]['valor_pag'])/30) * $diff->days);
                                }else{
                                    $valor_juros = 0;
                                }
                            }else{
                                $valor_juros = 0;
                            }
                            $totaljuros += $valor_juros;
                       }else{
                        $valor_juros = 0;
                       }
                    ?>
                    <tr class="<?php echo ($todas[$i]['vencimento'] < date('Y-m-d') && $todas[$i]['flag'] == 0) ? 'text-danger' : ''; ?>" >
                        <td></td>
                        <td><a href="?pagPrestacao=<?php echo $todas[$i]['id']; ?>" target="_blank" rel="noopener noreferrer"><?php echo $i+1; ?></a></td>
                        <td><?php echo $todas[$i]['vencimentof']; ?></td>
                        <td <?php echo $JUROS == 0 ? "colspan='3'":""; ?>><?php echo $todas[$i]['flag'] == 1 ? "Pago (".$todas[$i]['data_pagf'].")" : "Em aberto"; ?></td>
                        <?php if($JUROS == 1){ ?> <td><?php echo number_format($todas[$i]['valor_pag']/100, 2, ",", "."); ?></td>
                        <td><?php echo number_format($valor_juros/100, 2, ",", "."); ?></td><?php } ?>
                        <td><strong><?php echo number_format(($todas[$i]['valor_pag'] + $valor_juros)/100, 2, ",", "."); ?></strong></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php } ?>
                <tfoot>
                    <tr class="fw-800">
                        <td class="text-end"></td>
                        <td class="text-end">Total em aberto:</td>
                        <?php if($JUROS == 1){ ?>
                            <td></td>
                            <td class="text-end"></td>
                            <td></td>
                            <td class="text-end"></td>
                            <td><?php echo number_format(($total+$totaljuros)/100, 2, ",", "."); ?></td>
                        <?php }else{ ?>
                            <td></td>
                            <td></td>
                            <td><?php echo number_format($total/100, 2, ",", "."); ?></td>
                        <?php } ?>
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

    
    $(document).on("click", ".btnRecibo", function() {

    let dados = "cliente=" + $('#cliente').val();
    dados += "&nome_cliente=" + $('#cliente :selected').text().trim();
    dados += "&vendedor=" + $("#vendedor").val();
    dados += "&nome_vendedor=" + $('#vendedor :selected').text().trim();
    dados += "&email=" + $("#email").val();
    dados += "&nome=" + $("#email option:selected").text();
    console.log(dados);
    $.post("components/relatorio/export/emaberto_cliente.php", dados,
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
