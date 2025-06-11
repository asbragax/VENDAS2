<link rel="stylesheet" media="screen, print" href="../assets_coloradmin/css/statistics/chartjs/chartjs.css">
<?php

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
} else {
    $mes = date('m');
    $ano = date('Y');
}
include_once("components/apagar/action/listar_apagar_pagas.php");
include_once("components/apagar/action/cadastrar_apagar.php");
include_once("components/apagar/action/editar_apagar.php");
include_once("components/apagar/action/pagar_apagar_lote.php");
// include_once("components/conta/action/listar_contacaixa.php");
// include_once("components/conta/action/listar_contareceita.php");
// include_once("components/conta/action/listar_categoria.php");
include_once("components/fornecedor/action/listar_fornecedor.php");
include_once("components/pessoa/action/listar_pessoa.php");
// include_once('components/filial/action/listar_filial.php'); 
include_once('components/conta/action/listar_pagamento.php'); 
include_once("components/caixa/view/consulta/modal.php");
 ?>
<div class="row">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h3 class="panel-title">
                Total de contas pagas neste mês: R$ <?php echo number_format(array_sum(array_column($listaApagar2, "valor"))/100, 2, ",", "."); ?>
            </h3>
        </div>
        <div class="panel-body">
            <div id="apex-bar-chart"></div>
            <!-- <div id="horizontalBarChart">
                <canvas style="width:100%; height:75px;"></canvas>
            </div> -->
        </div>
    </div>
    <div class="col-sm-12 text-center mb-2">
        <div class="btn-group btn-group-md w-100">
            <a href="?consApagar" class="btn btn-success waves-effect waves-themed">Contas em aberto</a>
            <a href="?consApagarPagas" class="btn btn-primary waves-effect waves-themed">Contas pagas</a>
        </div>
    </div>
    <div class="panel panel-inverse bg-dark">
        <div class="panel-body row">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label text-white">Mês</label>
                        <select required class="form-control select2" name="mes" id="mes">
                            <?php for ($i = 1; $i <= count($arr_meses); $i++) {
                strlen($i) == 1 ? $i = '0' . $i : $i = $i; ?>
                            <option value="<?php echo $i; ?>" <?php echo $i == $mes ? "selected" : ""; ?>>
                                <?php echo $arr_meses[$i]; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-white">Ano</label>
                        <select required class="form-control select2" name="ano" id="ano">
                            <?php for ($i = date('Y') + 10; $i >= 2018; $i--) { ?>
                            <option value="<?php echo $i; ?>" <?php echo $i == $ano ? "selected" : ""; ?>>
                                <?php echo $i; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- SALVAR -->
                    <div class="col-md-12 text-end mt-2">
                        <button type="submit" class="btn btn-info btn-md"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Lista de contas a pagar quitadas</h4>
            <button  data-bs-toggle="modal" data-bs-target="#modal-cad-pagar" id="cad-apagar" class="btn btn-sm btn-success">Nova a pagar</button>
        </div>
        <div class="panel-body">
            <div class="table-responsive overflow-hidden">
                <table id="table-consApagars" data-page-length='20' class="table table-bordered table-hover table-striped w-100">
                    <thead class="bg-primary-600">
                        <tr>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Referência</th>
                            <th>Parcela</th>
                            <th>Valor</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ( $i = 0; $i < count($listaApagar); $i++ ) {?>

                            <tr>

                                <td><?php echo $listaApagar[$i]["vencimentof"]; ?></td>
                                <td><?php echo $listaApagar[$i]["pagamentof"]; ?></td>
                                <td><?php echo $listaApagar[$i]["nome"]; ?></td>
                                <td>A vista</td>
                                <td><?php echo number_format($listaApagar[$i]["valor"]/100, 2, ",", "."); ?></td>
                                <td></td>
                                <td class="none">
                                    <button class="btn btn-warning btn-xs btn-icon edtApagar" value="<?php echo $listaApagar[$i]['id']; ?>_<?php echo $listaApagar[$i]['forma_pag']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Editar">
                                        <i class="fa fa-edit"> </i>
                                    </button>
                                    <button class="btn btn-danger btn-xs btn-icon btnDeleteSaida" name="excluir_apagar" value="id=<?php echo  $listaApagar[$i]['id']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Excluir">
                                        <i class="fa fa-trash"> </i>
                                    </button>
                                </td>
                                
                            </tr>

                        <?php } ?>
                        <?php for ( $i = 0; $i < count($listaApagar2); $i++ ) {?>

                            <tr>

                                <td><?php echo $listaApagar2[$i]["vencimentof"]; ?></td>
                                <td><?php echo $listaApagar2[$i]["pagamentof"]; ?></td>
                                <td><?php echo $listaApagar2[$i]["nome"]; ?></td>
                                <td><?php echo ($listaApagar2[$i]["num"]+1)." de ".$listaApagar2[$i]["prestacao"]; ?></td>
                                <td><?php echo number_format(($listaApagar2[$i]["valor"]+$listaApagar2[$i]["juros"])/100, 2, ",", "."); ?></td>
                                <td class="none">
                                    <?php  if($listaApagar2[$i]['arquivo_nota'] != ''){ ?>
                                        <a target="_blank" href="arquivos/notas/<?php echo $listaApagar2[$i]['arquivo_nota']; ?>" class="btn btn-icon btn-outline-info btn-xs">
                                            <i class="fa 
                                            fa-file-<?php 
                                            if($arquivo_nota[1] == 'pdf'){ echo 'pdf';}
                                            elseif($arquivo_nota[1] == 'doc' || $arquivo_nota[1] == 'docx'){ echo 'word';}
                                            elseif($arquivo_nota[1] == 'xls' || $arquivo_nota[1] == 'xlsx'){ echo 'excel';}
                                            elseif($arquivo_nota[1] == 'jpg' || $arquivo_nota[1] == 'jpeg' || $arquivo_nota[1] == 'png'){ echo 'image';}
                                            ?>" 
                                            data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Nota fiscal"></i>
                                        </a>
                                    <?php } if($listaApagar2[$i]['arquivo_boleto'] != ''){ ?>
                                        <a target="_blank" href="arquivos/boletos/<?php echo $listaApagar2[$i]['arquivo_boleto']; ?>" class="btn btn-icon btn-outline-dark btn-xs">
                                            <i class="fa 
                                            fa-file-<?php 
                                            if($arquivo_boleto[1] == 'pdf'){ echo 'pdf';}
                                            elseif($arquivo_boleto[1] == 'doc' || $arquivo_boleto[1] == 'docx'){ echo 'word';}
                                            elseif($arquivo_boleto[1] == 'xls' || $arquivo_boleto[1] == 'xlsx'){ echo 'excel';}
                                            elseif($arquivo_boleto[1] == 'jpg' || $arquivo_boleto[1] == 'jpeg' || $arquivo_boleto[1] == 'png'){ echo 'image';}
                                            ?>" 
                                            data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Boleto"></i>
                                        </a>
                                    <?php }?>

                                    </td>
                                    <td class="none">
                                        <button class="btn btn-warning btn-xs btn-icon edtApagar" value="<?php echo $listaApagar2[$i]['id']; ?>_<?php echo $listaApagar2[$i]['forma_pag']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Editar">
                                            <i class="fa fa-edit"> </i>
                                        </button>
                                        <button class="btn btn-danger btn-xs btn-icon btnDeleteSaida" name="excluir_apagar" value="id=<?php echo  $listaApagar2[$i]['id']; ?>" data-bs-toggle="tooltip" data-placement="auto" title data-original-title="Excluir">
                                            <i class="fa fa-trash"> </i>
                                        </button>
                                    </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Referência</th>
                            <th>Parcela</th>
                            <th>Valor</th>
                            <th>Filial</th>
                            <th>Banco</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="../assets_coloradmin/plugins/apexcharts/dist/apexcharts.min.js"></script>
<script src="../assets_coloradmin/js/theme/default.js"></script>
<script src="../assets_coloradmin/plugins/moment/min/moment.min.js"></script>
<script src="../assets_coloradmin/plugins/moment/locale/pt-br.js"></script>
<script>
const TOTALAPAGAR = <?php echo safe_json_encode(array_sum(array_column($listaApagar, "valor"))+array_sum(array_column($listaApagar2, "valor"))); ?>;
</script>
<script src="components/caixa/view/consulta/script-caixa.js"></script>
<script src="components/caixa/view/consulta/script-a-pagar.js"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();

        $(function() {
            $('.select2-placeholder').select2({
                placeholder: "Selecione...",
                allowClear: true,
                containerCssClass: 'border-primary'
            });

        });


        var table = $('#table-consApagars').DataTable({
            responsive: true,
            lengthChange: false,
            colReorder: true,
            stateSave: true,
            ordering: false,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Gerar PDF',
                    className: 'btn-outline-danger btn-sm me-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Gerar Excel',
                    className: 'btn-outline-success btn-sm me-1'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'Gerar CSV',
                    className: 'btn-outline-info btn-sm me-1'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copiar',
                    titleAttr: 'Copiar para área de transferência',
                    className: 'btn-outline-warning btn-sm me-1'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    titleAttr: 'Imprimir tabela',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });

       

        $("#table-consApagars").on("click", ".confirmDeletar", function() {
            var dados = $(this).val();
            var url = $(this).attr('name');

            var swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger me-2"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
                .fire({
                    title: "EXCLUIR O MEMBRO?",
                    text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a esse apagar será apagado.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim.",
                    cancelButtonText: "Não!",
                    reverseButtons: true
                })
                .then(function(result) {
                    if (result.value) {
                        $.post("components/apagar/action/" + url + ".php", dados,
                            function(data) {
                                debugger
                                if (data != false) {
                                   location.reload();
                                }

                            }, "html");

                        swalWithBootstrapButtons.fire(
                            "EXCLUÍDO!",
                            "Ótimo!",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelado",
                            "Tenha certeza do que está fazendo!",
                            "error"
                        );
                    }
                });
        });

        chart.render();
    });
    var chart = new ApexCharts(
        document.querySelector('#apex-bar-chart'), {
        chart: { height: 100, type: 'bar', },
        plotOptions: {
            bar: { horizontal: true,  dataLabels: { position: 'top' } }  
        },
        dataLabels: { enabled: true, offsetX: -6, style: { fontSize: '12px', colors: [COLOR_WHITE] } },
        colors: [COLOR_RED],
        stroke: { show: true, width: 1, colors: [COLOR_WHITE] },
        series: [
            { 
                name: "Total",
                data: [
                    (TOTALAPAGAR/100).toFixed(2)
                ]
            },
        ],
        xaxis: {
            categories: [moment().format('MMMM')],
            axisBorder: { show: true, color: COLOR_SILVER_TRANSPARENT_5, height: 1, width: '100%', offsetX: 0, offsetY: -1 },
            axisTicks: { show: true, borderType: 'solid', color: COLOR_SILVER, height: 6, offsetX: 0, offsetY: 0 }
        }
        }
    );
</script>
