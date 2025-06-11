<?php
    $id = $_GET['pagApagar'];
    // echo $id;
    $pagdao = new ApagarDAO();
    $conta = $pagdao->getPorIdDetailsParcela($id);

    include_once("components/conta/action/listar_contacaixa.php");
    include_once("components/apagar/action/pagar_parcela.php");
    include_once("components/conta/action/listar_pagamento.php");

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Pagar parcela</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <h5 class="card-title">
                    <?php echo $conta['nome']; ?>
                </h5>
                <hr>
            </div>
            <div class="col-md-3">
                <h5 class="card-title">
                    <strong>Fornecedor:</strong><br>

                    <?php echo $conta['nome_fornecedor']; ?>
                </h5>
                <hr>
                <h5 class="card-title">
                    <strong>Nota Fiscal:</strong>
                    <?php if ($conta['arquivo_nota'] != '') { ?>
                    <a href="arquivos/notas/<?php echo $conta['arquivo_nota']; ?>" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>
                    <?php  } ?>     
                </h5>
            </div>
            <div class="col-md-3">
                <h5 class="card-title">
                    <strong>Pago:</strong><br>
                    <?php if ($conta['status'] == 0) {
                        echo "<em class='text-danger'>Não</em>";
                    } elseif ($conta['status'] == 1) {
                        echo "<em class='text-success'>Pago</em>";
                    } ?>
                </h5>
                <hr>
                <h5 class="card-title">
                    <strong>Recibo:</strong>
                    <?php if ($conta['arquivo_recibo'] != '') { ?>
                    <a href="arquivos/recibos/<?php echo $conta['arquivo_recibo']; ?>" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>
                    <?php  } ?>     
                </h5>
            </div>
            <div class="col-md-3">
                <h5 class="card-title">Vencimento: <br><?php echo $conta['vencimentof']; ?></h5>
                <hr>
                <?php if ($conta['status'] > 0) { ?>
                    <h5 class="card-title">
                        <strong>Data de pagamento:</strong><br>

                        <?php echo $conta['data_pagf']; ?>
                    </h5>
                <?php  } ?>


            </div>
            <div class="col-md-3">
                <h5 class="card-title">
                    <strong>Valor: </strong><br>
                    <?php echo "R$ " . number_format($conta['valor'] / 100, 2, ',', '.'); ?>
                </h5>
                <hr>
                <h5 class="card-title">
                    <?php if ($conta['prestacao'] == 1) { ?>
                        À vista
                    <?php } else {
                        echo "Parcela " . ($conta['num'] +1) . " de " . $conta['prestacao'];
                    } ?>
                </h5>


            </div>

        </div>
        <hr>
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row  justify-content-center">
                <div class="col-sm-3 text-left">
                    <label class="form-label">Data do pagamento</label>
                    <input type="date" name="data_pag" id="data_pag" class="form-control border-primary" value="<?php echo $conta['data_pag'] != '' ? $conta['data_pag'] : date('Y-m-d'); ?>">
                </div>
                <div class="col-sm-4 text-left">
                    <label class="form-label">Forma de pagamento</label>
                    <select required class="form-control select2" name="conta_pag" id="conta_pag">
                        <?php for ($i = 0; $i < count($listaPagamento); $i++) { ?>
                            <option value="<?php echo $listaPagamento[$i]['id']; ?>" <?php echo $listaPagamento[$i]['id'] == $conta['conta_pag'] ? "selected" : ""; ?>>
                                <?php echo $listaPagamento[$i]['nome']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-5 text-left">
                    <label class="form-label">Recibo</label>
                    <input type="file" name="arquivo_recibo" id="arquivo_recibo" class="form-control border-primary">
                </div>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <input type="hidden" name="pagamento" id="pagamento" value="<?php echo $listaContaCaixa[0]['nome']; ?>">

                </div>
                <div class="col-sm-12 px-0 mt-2 text-end">
                    <button type="submit" class="btn float-end btn-primary" name="cadPagar" id="cadPagar">
                        <i class="fa fa-save"></i>
                        Pagar
                    </button>
                </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(":input").inputmask();

    $('.select2').select2({
        containerCssClass: "border-primary"
    });

    $(document).on('change', '#conta_pag', function() {
        $("#pagamento").val($("#conta_pag :selected").text());
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });



});
</script>