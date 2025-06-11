<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/page-invoice-new.css">
<?php
    $id = $_GET['dtlNota'];

    $pagdao = new NotaDAO();
    $nota = $pagdao->getPorIdDetails($id);
    $pagdao = new Nota_produtoDAO();
    $produtos = $pagdao->listar($id);

// ob_start();
?>
<!-- BEGIN invoice -->
<div class="invoice">
    <!-- BEGIN invoice-company -->
    <div class="invoice-company">
        <span class="float-end hidden-print">
            <?php if($nota['flag'] == 0){ ?>
                <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnAddEstoque" value="id=<?php echo $id; ?>"><i class="fa fa-plus-square  t-plus-1 text-info fa-fw fa-lg"></i> Adicionar ao estoque</button>
            <?php }else{ if($_SESSION['nivel'] >= 3){?>
                <button type="submit" class="btn btn-sm btn-white mb-10px btn-control btnDecEstoque" value="id=<?php echo $id; ?>"><i class="fa fa-minus-square  t-plus-1 text-danger fa-fw fa-lg"></i> Remover do estoque</button>
            <?php } } 
                if($nota['arquivo'] != ''){
            ?>
                <a target="_blank" href="arquivos/notas/<?php echo $nota['arquivo']; ?>" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-file-pdf text-indigo t-plus-1 fa-fw fa-lg"></i> Arquivo</a>
            <?php } ?>
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white mb-10px btn-control"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Imprimir</a>
        </span>
        <?php echo $EMPRESA_REDUZIDO; ?> #<?php echo $nota['id_auto']; ?>      <?php echo $nota['dataf']; ?>
    </div>
    <!-- END invoice-company -->
    <!-- BEGIN invoice-header -->
    <div class="invoice-header">
        <div class="row jusfity-content-between">
            <div class="invoice-from">
                <small>fornecedor</small>
                <address class="mt-2px mb-2px">
                    <strong class="text-inverse"><?php echo $nota['nome']; ?></strong><br />
                    <?php echo $nota['cpf']."<br />"; ?>
                </address>
            </div>
            <div class="invoice-from">
                <small>Observação</small>
                <address>
                    <strong class="text-inverse"><?php echo $nota['endereco']; ?></strong><br />
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
                        <th class="text-end" width="20%">VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $dao = new Nota_produtoDAO();
                        for ($i=0; $i < count($produtos); $i++) {
                            // echo $produtos[$i]['id_nota']." ".$produtos[$i]['id_produto'];
                            $grade = $dao->listar_grade($produtos[$i]['id_nota'], $produtos[$i]['id_produto']);
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
                        <td>
                            <span class="text-inverse"><?php echo $produtos[$i]['id_produto']." - ".$produtos[$i]['nome']." #".$grade[$x]['tipo']; ?></span>
                        </td>
                        <td class="text-center">R$ <?php echo number_format(($produtos[$i]['valor']/$produtos[$i]['quantidade'])/100, 2, ",", '.'); ?></td>
                        <td class="text-center"><?php echo $grade[$x]['quantidade']; ?></td>
                        <td class="text-end">R$ <?php echo number_format((($produtos[$i]['valor']/$produtos[$i]['quantidade'])*$grade[$x]['quantidade'])/100, 2, ",", '.'); ?></td>
                    </tr>
                    <?php } } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Qtde. produtos: <?php echo count($produtos); ?></th>
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
                        <small>SUBTOTAL</small>
                        <span class="text-inverse">R$ <?php echo number_format($nota['valor']/100, 2, ",", '.'); ?></span>
                    </div>
                    <!-- <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                    </div>
                    <div class="sub-price">
                        <small>DESCONTO</small>
                        <span class="text-inverse">R$ <?php //echo number_format($nota['desconto']/100, 2, ",", '.'); ?></span>
                    </div> -->
                </div>
            </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> <span class="fw-bold">R$ <?php echo number_format(($nota['valor']-$nota['desconto'])/100, 2, ",", '.'); ?></span>
            </div>
        </div>
        <!-- <div class="invoice-footer">
            <span class="text-muted-700">Após o vencimento, será cobrado juros de 5% ao mês e multa de 1%.</span>
        </div> -->
    </div>
    <!-- END invoice-content -->
    

</div>
<!-- END invoice -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var vendedor = <?php echo safe_json_encode($vendedor); ?>;
$(document).ready(function() {
    $(document).on("click", ".btnAddEstoque", function() {

        $(document).on("click", ".btnAddEstoque", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            // var url = $(this).attr('name');
            swal({
                title: "ADICIONAR PRODUTOS AO ESTOQUE?",
                text: "Tem certeza do que está fazendo?",
                icon: 'warning',
                buttons: {
                cancel: {
                    text: 'Não',
                    value: 'cancel',
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Sim',
                    value: 'proceed',
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                }
                }
            })
            .then(function(result) {
                switch (result) {
                case "cancel":
                swal({
                    icon: 'info',
                    text: "Ufa! Seus dados estão a salvo."
                });
                break;

                case 'proceed':
                    $.post("components/nota/action/adicionar_produtos_nota.php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Estoque adicionado com sucesso."
                            });
                            window.location.reload();
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível adicionar produtos ao estoque."
                            });
                        }

                    }, "html");
                   
                break;

                default:
                swal({
                    icon: 'info',
                    text: "Ufa! Seus dados estão a salvo."
                });
                }
            })
            .catch(err => {
                if(err){
                    swal({
                        icon: 'danger',
                        text: "Um erro ocorreu, impossível adicionar produtos ao estoque."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
    });
    $(document).on("click", ".btnDecEstoque", function(e) {
        e.preventDefault();
        var dados = $(this).val();
        // var url = $(this).attr('name');
        swal({
            title: "REMOVER PRODUTOS DO ESTOQUE?",
            text: "Tem certeza do que está fazendo?",
            icon: 'warning',
            buttons: {
            cancel: {
                text: 'Não',
                value: 'cancel',
                visible: true,
                className: 'btn btn-default',
                closeModal: true,
            },
            confirm: {
                text: 'Sim',
                value: 'proceed',
                visible: true,
                className: 'btn btn-primary',
                closeModal: true
            }
            }
        })
        .then(function(result) {
            switch (result) {
            case "cancel":
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            break;

            case 'proceed':
                $.post("components/nota/action/remover_produtos_nota.php", dados,
                function(data) {
                    debugger
                    if (data!= null && data != false) {
                        swal({
                            icon: 'success',
                            text: "Estoque adicionado com sucesso."
                        });
                        window.location.reload();
                    }else{
                        swal({
                            icon: 'warning',
                            text: "Um erro ocorreu, impossível remover produtos do estoque."
                        });
                    }

                }, "html");
                
            break;

            default:
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            }
        })
        .catch(err => {
            if(err){
                swal({
                    icon: 'danger',
                    text: "Um erro ocorreu, impossível remover produtos do estoque."
                });
            } else {
                swal.stopLoading();
                swal.close();
            }
        });
    });
});
</script>