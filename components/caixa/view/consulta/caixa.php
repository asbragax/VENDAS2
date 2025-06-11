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
$vendas = $dao->caixa_semana($dataini, $datafim);
$dao = new Pessoa_crediarioDAO();
$crediario = $dao->caixa_semana($dataini, $datafim);



$dao = new ApagarDAO();
$saidas = $dao->caixa_semana_avista($dataini, $datafim);
$saidas2 = $dao->caixa_semana_aprazo($dataini, $datafim);

$saidas = array_merge($saidas,$saidas2);

$dao = new UserDAO();
$vendedores = $dao->listar_under_3();
include_once("components/apagar/action/cadastrar_apagar.php");
include_once("components/conta/action/listar_pagamento.php");
include_once("components/fornecedor/action/listar_fornecedor.php");
include_once("components/apagar/action/editar_apagar.php");

include_once("components/caixa/view/consulta/modal.php");
?>
<div id="panel-1" class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Caixa</h4>
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
                    <button name="create_excel" id="create_excel" class="btn btn-warning">
                        <i class="fa fa-file-excel"></i> Exportar para Excel
                    </button>  
                    <button type="submit" class="btn btn-info float-end mx-1" name="buscar">
                        <span class="fa fa-search me-1"></span>
                        Buscar
                    </button>
                    <button class="btn btn-danger float-end mx-1" data-bs-toggle="modal" data-bs-target="#modal-cad-pagar" id="cad-apagar">
                        <i class="fa fa-minus-circle"></i> A pagar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php 
    $pags = [];
    $ents = [];
    $coms = [];
    $temp = 0;
    $valVenda = 0;
?>
<div data-size="A4" class="pagina p-0" id="content-caixa">
    <div class="px-0 mx-0 container" style="max-width:100vw !important">
        <div class="table-responsive">
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa0">
                    <thead class="bg-info color-black">  
                        <th class="text-center">VENDAS</th>
                    </thead>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa1">
                    <thead class="bg-info color-black">
                        <tr>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Produto(s)</th>
                            <th>Pagamento</th>
                            <th>Valor</th>
                            <?php echo $COMISSAO == 1 ? '<th>Comissão</th>' : ''; ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($vendas) >= 1) {
                            $dao = new Venda_produtoDAO();
                            $pdao = new Venda_pagamentoDAO();
                        for ($i=0; $i < count($vendas); $i++) {  
                            $produtos = $dao->listar($vendas[$i]['id']);
                             $pagamentos = null;
                            $pagamentos = $pdao->listar($vendas[$i]['id']);
                            // echo $vendas[$i]['vendedor'];
                            ?>
                            <tr style="color:#2267e6">
                                <td><a style="color:#2267e6" href="?dtlVenda=<?php echo $vendas[$i]['id']; ?>" target="_blank">Venda</a></td>
                                <?php if($diario == 0){ ?>
                                    <td>
                                        <?php echo $vendas[$i]['dataf']; ?>
                                    </td>
                                <?php } ?>
                                <td><a style="color:#2267e6" href="?dtlPessoa=<?php echo $vendas[$i]['cliente']; ?>" target="_blank"><?php echo $vendas[$i]['nome']; ?></a></td>
                                <td>
                                    <?php 
                                        for ($x = 0; $x < count($produtos); $x++) {
                                            echo $produtos[$x]["nome"] . " x " . $produtos[$x]["quantidade"] . "<br>";
                                        }
                                        $produtos = null;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                       
                                        for ($x = 0; $x < count($pagamentos); $x++) {
                                            if($pagamentos[$x]["id_pagamento"] < 90){
                                                echo $pagamentos[$x]["nome"]."<br>";
                                                $ents[$pagamentos[$x]["id_pagamento"]] += $pagamentos[$x]["valor"];

                                                $valVenda += $pagamentos[$x]["valor"];
                                                if ($COMISSAO == 1 && $vendas[$i]['comissao'] == 1) {
                                                    $coms[$pagamentos[$x]["id_pagamento"]][$vendas[$i]['vendedor']] +=  ($pagamentos[$x]["valor"] * $COMISSAO_PERCENT);
                                                    $temp += $pagamentos[$x]["valor"] * $COMISSAO_PERCENT;
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                <td><?php echo $valVenda > 0 ? number_format($valVenda/100, 2, ",", ".") : "-"; ?><t/d>
                                <?php echo $COMISSAO == 1 ? '<td class="text-danger">' : ''; ?>
                                <?php echo ($COMISSAO == 1 && $vendas[$i]['comissao'] == 1) ? number_format($temp/100, 2, ",", ".") : ''; ?>
                                <?php echo $COMISSAO == 1 ? '</td>' : ''; ?>
                                <td><?php echo $vendas[$i]['comissao'] == 1 ? number_format(($valVenda - $temp)/100, 2, ",", ".") : number_format($valVenda/100, 2, ",", "."); ?><t/d>
                            </tr>
                        <?php $temp = 0; }
                    } 
                    if (count($crediario) >= 1) {
                            $dao = new Venda_produtoDAO();
                        for ($i=0; $i < count($crediario); $i++) {  
                            $produtos = $dao->listar($crediario[$i]['id_venda']);
                            $ents[$crediario[$i]["forma_pag"]] += $crediario[$i]["valor_pag"]+$crediario[$i]['juros'];
                            if ($COMISSAO == 1 && $crediario[$i]['comissao'] == 1) {
                                $coms[$crediario[$i]["forma_pag"]][$crediario[$i]['vendedor']] +=  (($crediario[$i]['valor_pag']+$crediario[$i]['juros']) * $COMISSAO_PERCENT);
                            }
                            ?>
                            <tr style="color:#2267e6">
                                <td><a style="color:#2267e6" href="?dtlPrestacao=<?php echo $crediario[$i]['id']; ?>" target="_blank">Crediário</a></td>
                                <?php if($diario == 0){ ?>
                                    <td>
                                        <?php echo $crediario[$i]['data_pagf']; ?>
                                    </td>
                                <?php } ?>
                                <td><a style="color:#2267e6" href="?dtlPessoa=<?php echo $crediario[$i]['id_pessoa']; ?>" target="_blank"><?php echo $crediario[$i]['nome']; ?></a></td>
                                <td>
                                    <?php 
                                        for ($x = 0; $x < count($produtos); $x++) {
                                            echo $produtos[$x]["nome"] . " x " . $produtos[$x]["quantidade"];
                                            echo $produtos[$x]["kg"] == 1 ? " gr" : " un";
                                            echo "<br>";
                                        }
                                        $produtos = null;
                                    ?>
                                </td>
                                <td><?php echo $crediario[$i]['nome_pagamento']; ?></td>
                                <td><?php echo number_format(($crediario[$i]['valor_pag']+$crediario[$i]['juros'])/100, 2, ",", "."); ?><t/d>
                                <?php echo $COMISSAO == 1 ? '<td class="text-danger">' : ''; ?>
                                <a href="?dtlPrestacaoVendedor=<?php echo $crediario[$i]['id']; ?>" class="text-danger" target="_blank" rel="noopener noreferrer">
                                <?php echo ($COMISSAO == 1 && $crediario[$i]['comissao'] == 1) ? number_format((($crediario[$i]['valor_pag']+$crediario[$i]['juros']) * $COMISSAO_PERCENT)/100, 2, ",", ".") : ''; ?>
                                </a>
                                <?php echo $COMISSAO == 1 ? '</td>' : ''; ?>
                                <td><?php echo $crediario[$i]['comissao'] == 1 ? number_format((($crediario[$i]['valor_pag']+$crediario[$i]['juros']) - ($crediario[$i]['valor_pag'] * $COMISSAO_PERCENT))/100, 2, ",", ".") : number_format(($crediario[$i]['valor_pag']+$crediario[$i]['juros'])/100, 2, ",", "."); ?><t/d>
                            </tr>
                        <?php }  }  ?>
                    </tbody>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa2">
                    <thead class="bg-info color-black">
                        <tr>
                            <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                                <th><?php echo $listaPagamento[$z]['nome']; ?></th>
                            <?php } ?>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fw-600" style="color:#2267e6">
                            <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                                <td><?php echo number_format($ents[$listaPagamento[$z]['id']]/100, 2, ",", "."); ?></td>
                            <?php } ?>
                            <td><?php echo number_format(array_sum($ents)/100, 2, ",", "."); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php if($COMISSAO == 1){ ?>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa3">
                    <thead class="bg-gradient-red color-white">  
                        <th class="text-center">COMISSÕES</th>
                    </thead>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center">
                    <thead class="bg-gradient-red color-white">
                        <tr>
                            <th>Tipo</th>
                            <th>Vendedor(a)</th>
                            <th>Pagamento</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($x=0; $x < count($listaPagamento); $x++) {      
                        for ($i=0; $i < count($vendedores); $i++) {
                        // $key = array_search($coms,array_column($vendedores, 'id'));
                            if($coms[$listaPagamento[$x]['id']][$vendedores[$i]['id']] > 0){                       
                    ?>
                        <tr style="color:#ed1818">
                            <td><a style="color:#ed1818" href="?dtlPrestacaoDia=<?php echo $vendedores[$i]['id']; ?>&dtini=<?php echo $dataini; ?>&dtfim=<?php echo $datafim; ?>" target="_blank" rel="noopener noreferrer">Comissão</a></td>
                            <td><?php echo $vendedores[$i]['nome']; ?></td>
                            <td><?php echo $listaPagamento[$x]['nome']; ?></td>
                            <td><?php echo number_format($coms[$listaPagamento[$x]['id']][$vendedores[$i]['id']]/100, 2, ",", "."); ?></td>
                        </tr>
                    <?php } } }?>
                    </tbody>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa4">
                    <thead class="bg-gradient-red color-black">
                        <tr>
                            <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                                <th><?php echo $listaPagamento[$z]['nome']; ?></th>
                            <?php } ?>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fw-600" style="color:#ed1818">
                            <?php 
                            $ttl = 0;
                            for ($z=0; $z < count($listaPagamento); $z++) { 
                                if(isset($coms[$listaPagamento[$z]['id']])){ 
                                    $ttl += array_sum($coms[$listaPagamento[$z]['id']]);
                                    ?>
                                <td><?php echo number_format(array_sum($coms[$listaPagamento[$z]['id']])/100, 2, ",", "."); ?></td>
                            <?php }else{
                                echo '<td>0,00</td>';
                            }  }?>
                            <td><?php echo number_format($ttl/100, 2, ",", "."); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?>
                <?php if($_SESSION['nivel'] >= 3){ 
                    if (count($saidas) >= 1) {
                ?>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa5">
                    <thead class="bg-danger color-white">  
                        <th class="text-center">SAÍDAS</th>
                    </thead>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa6">
                    <thead class="bg-danger color-white">
                        <tr>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Fornecedor</th>
                            <th>Descrição</th>
                            <th>Pagamento</th>
                            <th>Valor</th>
                            <th class="none">#</th>
                            <th class="none">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        for ($i=0; $i < count($saidas); $i++) {
                            $pags[$saidas[$i]["conta_pag"]] += $saidas[$i]["valor"];

                            $arquivo_nota = explode(".", $saidas[$i]['arquivo_nota']);
                            $arquivo_boleto = explode(".", $saidas[$i]['arquivo_boleto']);
                            $arquivo_recibo = explode(".", $saidas[$i]['arquivo_recibo']); ?>
                        <tr style="color:#ed1818">
                            <td>Saída</td>
                            <td><?php echo $saidas[$i]['vencimentof']; ?></td>
                            <td><?php echo $saidas[$i]['nome_fornecedor']; ?></td>
                            <td><?php echo $saidas[$i]['nome']; ?></td>
                            <td><?php echo $saidas[$i]['nome_forma_pagamento']; ?></td>
                            <td><?php echo number_format($saidas[$i]['valor']/100, 2, ",", "."); ?></td>
                            <td class="none">
                            <?php  if ($saidas[$i]['arquivo_nota'] != '') { ?>
                                <a target="_blank" href="arquivos/notas/<?php echo $saidas[$i]['arquivo_nota']; ?>" class="btn btn-icon btn-outline-info btn-xs">
                                    <i class="fal 
                                    fa-file-<?php
                                    if ($arquivo_nota[1] == 'pdf') {
                                        echo 'pdf';
                                    } elseif ($arquivo_nota[1] == 'doc' || $arquivo_nota[1] == 'docx') {
                                        echo 'word';
                                    } elseif ($arquivo_nota[1] == 'xls' || $arquivo_nota[1] == 'xlsx') {
                                        echo 'excel';
                                    } elseif ($arquivo_nota[1] == 'jpg' || $arquivo_nota[1] == 'jpeg' || $arquivo_nota[1] == 'png') {
                                        echo 'image';
                                    }
                                    ?>" 
                                    data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Nota fiscal"></i>
                                </a>
                            <?php }
                            if ($saidas[$i]['arquivo_boleto'] != '') { ?>
                                <a target="_blank" href="arquivos/boletos/<?php echo $saidas[$i]['arquivo_boleto']; ?>" class="btn btn-icon btn-outline-dark btn-xs">
                                    <i class="fal 
                                    fa-file-<?php
                                    if ($arquivo_boleto[1] == 'pdf') {
                                        echo 'pdf';
                                    } elseif ($arquivo_boleto[1] == 'doc' || $arquivo_boleto[1] == 'docx') {
                                        echo 'word';
                                    } elseif ($arquivo_boleto[1] == 'xls' || $arquivo_boleto[1] == 'xlsx') {
                                        echo 'excel';
                                    } elseif ($arquivo_boleto[1] == 'jpg' || $arquivo_boleto[1] == 'jpeg' || $arquivo_boleto[1] == 'png') {
                                        echo 'image';
                                    }
                                    ?>" 
                                    data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Boleto"></i>
                                </a>
                            <?php }
                            if ($saidas[$i]['arquivo_recibo'] != '') { ?>
                                <a target="_blank" href="arquivos/recibos/<?php echo $saidas[$i]['arquivo_recibo']; ?>" class="btn btn-icon btn-outline-warning btn-xs">
                                    <i class="fal 
                                    fa-file-<?php
                                    if ($arquivo_recibo[1] == 'pdf') {
                                        echo 'pdf';
                                    } elseif ($arquivo_recibo[1] == 'doc' || $arquivo_recibo[1] == 'docx') {
                                        echo 'word';
                                    } elseif ($arquivo_recibo[1] == 'xls' || $arquivo_recibo[1] == 'xlsx') {
                                        echo 'excel';
                                    } elseif ($arquivo_recibo[1] == 'jpg' || $arquivo_recibo[1] == 'jpeg' || $arquivo_recibo[1] == 'png') {
                                        echo 'image';
                                    }
                                    ?>" 
                                    data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Recibo"></i>
                                </a>
                            <?php } ?>
                            </td>
                            <td class="none">
                                <?php if ($saidas[$i]['status'] == 0 && $saidas[$i]['forma_pag'] == 2) { ?>
                                <a class="btn btn-success btn-xs btn-icon" href="?pagApagar=<?php echo $saidas[$i]['id_parcela']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Pagar">
                                    <i class="fa fa-dollar-sign"> </i>
                                </a>
                                <?php } ?>
                                <button class="btn btn-warning btn-xs btn-icon edtApagar" value="<?php echo $saidas[$i]['id']; ?>_<?php echo $saidas[$i]['forma_pag']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Editar">
                                    <i class="fa fa-edit"> </i>
                                </button>
                                <button class="btn btn-danger btn-xs btn-icon btnDeleteSaida" name="excluir_apagar" value="id=<?php echo $saidas[$i]['id']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Excluir">
                                    <i class="fa fa-trash"> </i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa7">
                    <thead class="bg-danger color-black">
                        <tr>
                            <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                                <th><?php echo $listaPagamento[$z]['nome']; ?></th>
                            <?php } ?>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fw-600" style="color:#ed1818">
                            <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                                <td><?php echo number_format($pags[$listaPagamento[$z]['id']]/100, 2, ",", "."); ?></td>
                            <?php } ?>
                            <td><?php echo number_format(array_sum($pags)/100, 2, ",", "."); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } } ?>
            <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa8">
                <thead class="bg-success color-black">  
                    <th class="text-center">TOTAIS</th>
                </thead>
            </table>
            <table class="table table-striped table-sm table-bordered m-0 col-sm-12 text-center" id="table-caixa9">
                <thead class="bg-success color-white">
                    <tr>
                        <?php for ($z=0; $z < count($listaPagamento); $z++) {  ?>
                            <th><?php echo $listaPagamento[$z]['nome']; ?></th>
                        <?php } ?>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="fw-700 text-black-900">
                        <?php for ($z=0; $z < count($listaPagamento); $z++) { 
                                if(isset($coms[$listaPagamento[$z]['id']])){
                            ?>
                            <td><?php echo number_format(($ents[$listaPagamento[$z]['id']]-array_sum($coms[$listaPagamento[$z]['id']])-$pags[$listaPagamento[$z]['id']])/100, 2, ",", "."); ?></td>
                            <?php }else{ ?>
                            <td><?php echo number_format(($ents[$listaPagamento[$z]['id']]-$pags[$listaPagamento[$z]['id']])/100, 2, ",", "."); ?></td>
                        <?php } } ?>
                        <td class="fs-20px"><?php echo number_format((array_sum($ents)-$ttl-array_sum($pags))/100, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="components/caixa/view/consulta/script-caixa.js"></script>
<script src="components/caixa/view/consulta/script-a-pagar.js"></script>
<script>
$(document).ready(function(){

    $(document).on('change keyup', '.valores', function() {
        let total = 0;
        let temp = null;
        $(".valores").each(function() {
            temp = $(this).val();
            // console.log(temp);
            if (temp.length <= 0) {
                temp = 0;
            } else {
                temp = temp.split("$ ");
                temp = (temp[1].replace(".", "").replace(".", "").replace(",", ".") * 100);
            }
            total += +temp;
        });
        $("#valor").val((total/100).toFixed(2).replace(".", ","));
    });
    
});
</script>