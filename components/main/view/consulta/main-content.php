
<?php 
if($_SESSION['nivel'] >= 3){  
    $dao = new Pessoa_crediarioDAO();
    $vencidas = $dao->listar_vencidas(date("Y-m-d"));
    $vencendo = $dao->listar_vencendo_hoje(date("Y-m-d"));
    include_once("components/main/view/consulta/modal_main.php");
}
?>

<!-- BEGIN page-header -->
<h1 class="page-header mb-3">Início</h1>
<!-- END page-header -->
<?php if($_SESSION['nivel'] >= 3){ ?>  
<div class="row p-0 mt-3">
    <div class="col-sm-12 px-0 my-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-vencendo" class="btn btn-lg btn-warning"><i class="fa fa-exclamation-triangle"></i> (<?php echo count($vencendo); ?>) Vencendo hoje</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-vencidas" class="btn btn-lg btn-danger"><i class="fa fa-exclamation-triangle"></i> (<?php echo count($vencidas); ?>) Em atraso</a>
    </div>
    <div class="panel panel-inverse col-lg-6  p-0">
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Vendas</h4>
        </div>
        <div class="panel-body">
            <div class="row justify-content-end">
                <div class="col-sm-4 row mb-3">
                    <label class="form-label col-form-label col-md-3">Mês</label>
                    <div class="col-md-9">
                        <select name="selectMesGraficoVenda" id="selectMesGraficoVenda" class="form-control form-control-sm form-select">
                            <?php for ($i=1; $i <= count($arr_meses); $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo $i == date("m") ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 row mb-3">
                    <label class="form-label col-form-label col-md-3">Ano</label>
                    <div class="col-md-9">
                        <select name="selectAnoGraficoVenda" id="selectAnoGraficoVenda" class="form-control form-control-sm form-select">
                            <?php for ($i=date("Y"); $i >= 2020; $i--) { ?>
                            <option value="<?php echo $i; ?>"  <?php echo $i == date("Y") ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="chart-vendas" class="h-250px"></div>
        </div>
    </div>
    <div class="panel panel-inverse col-lg-6 p-0">
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Valores</h4>
        </div>
        <div class="panel-body">
            <div class="row justify-content-end">
                <div class="col-sm-4 row mb-3">
                    <label class="form-label col-form-label col-md-3">Mês</label>
                    <div class="col-md-9">
                        <select name="selectMesGraficoValores" id="selectMesGraficoValores" class="form-control form-control-sm form-select">
                            <?php for ($i=1; $i <= count($arr_meses); $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo $i == date("m") ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 row mb-3">
                    <label class="form-label col-form-label col-md-3">Ano</label>
                    <div class="col-md-9">
                        <select name="selectAnoGraficoValores" id="selectAnoGraficoValores" class="form-control form-control-sm form-select">
                            <?php for ($i=date("Y"); $i >= 2020; $i--) { ?>
                            <option value="<?php echo $i; ?>"  <?php echo $i == date("Y") ? "selected" : ""; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="chart-valores" class="h-250px"></div>
        </div>
    </div>
</div>
<?php }?>
<?php include_once('components/conta/action/listar_pagamento.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const pagamentos = <?php echo safe_json_encode($listaPagamento); ?>;
    const arrayColumn = (arr, n) => arr.map(x => x[n]);

    $(document).ready(function() {

        $(document).on("change", "#selectMesGraficoVenda, #selectAnoGraficoVenda", function(){
            const mes = $("#selectMesGraficoVenda").val();
            const ano = $("#selectAnoGraficoVenda").val();

            busca_valor_venda(mes, ano);

        });
        $(document).on("change", "#selectMesGraficoValores, #selectAnoGraficoValores", function(){
            const mes = $("#selectMesGraficoValores").val();
            const ano = $("#selectAnoGraficoValores").val();

            busca_valor_valores(mes, ano);

        });

        function busca_valor_venda(mes, ano) {
            var dados = "mes="+mes+"&ano="+ano;
            $.post("components/venda/action/buscar_por_mes_diario.php", dados,
                function(data) {
                    if (data != null) {
                        data = JSON.parse(data);
                        // console.log(data);
                        graficoVendas(data, mes, ano);
                }
            }, "html");
        };
        function busca_valor_valores(mes, ano) {
            var dados = "mes="+mes+"&ano="+ano;
            $.post("components/venda/action/buscar_valores_por_mes_diario.php", dados,
                function(data1) {
                    if (data1 != null) {
                        data1 = JSON.parse(data1);
                        // console.log(data1);
                        graficoValores(data1, mes, ano);
                }
            }, "html");
        };
        $("#selectMesGraficoVenda").change();
        $("#selectMesGraficoValores").change();

        function graficoVendas(vendas, mes, ano){
            $('#chart-vendas').empty();
            let dias = [];
            for (let i = 0; i < (new Date(ano, mes, 0 )).getDate(); i++) {
                dias[i] = (i+1);
            }
            var chart = new ApexCharts(
                
                document.querySelector('#chart-vendas'), {
                chart: {
                    height: 350,
                    type: 'line',
                    shadow: { enabled: true, color: COLOR_DARK, top: 18, left: 7, blur: 10, opacity: 1 },
                    toolbar: { show: false }
                },
                title: { text: 'Vendas por dia', align: 'center' },
                colors: [COLOR_BLUE],
                dataLabels: { enabled: true },
                stroke: { curve: 'smooth', width: 3 },
                series: [
                    { name: 'Vendas', data: vendas }
                ],
                grid: {
                    row: { colors: [COLOR_SILVER_TRANSPARENT_1, 'transparent'],  opacity: 0.5 },
                },
                markers: { size: 4 },
                xaxis: {
                    categories: dias,
                    axisBorder: { show: true, color: COLOR_SILVER_TRANSPARENT_5, height: 1, width: '100%', offsetX: 0, offsetY: -1 },
                    axisTicks: { show: true, borderType: 'solid', color: COLOR_SILVER, height: 6, offsetX: 0, offsetY: 0 }
                },
                legend: { show: true, position: 'top', offsetY: -10, horizontalAlign: 'right', floating: true }
                }
            );
        
            chart.render();
        }

        function graficoValores(valores1, mes, ano){
            $('#chart-valores').empty();

            let dias = [];
            for (let i = 0; i < (new Date(ano, mes, 0 )).getDate(); i++) {
                dias[i] = (i+1);
            }

            // function getDataset(name, data, id) { 
            //     return { 
            //         data: data,
            //         name: name
            //     }; 
            // }
            // const datasets = [];

            // for (let index = 0; index < valores1.length; index++) {
            //     const foundPagamento = pagamentos.find(element => element.id == (index+1));
            //     if(foundPagamento !== undefined){
            //         if(valores1[index].find(el => el > 0)){
            //             datasets.push(getDataset(foundPagamento.nome,valores1[index],index)); 
            //         }
            //     }
            // }

            var chart = new ApexCharts(
                
                document.querySelector('#chart-valores'), {
                chart: {
                    height: 350,
                    type: 'line',
                    shadow: { enabled: true, color: COLOR_DARK, top: 18, left: 7, blur: 10, opacity: 1 },
                    toolbar: { show: false }
                },
                title: { text: 'Valores por dia', align: 'center' },
                colors: [...COLORS],
                dataLabels: { enabled: true },
                stroke: { curve: 'smooth', width: 2 },
                series: [
                    { name: 'Total', data: valores1 }
                ],
                grid: {
                    row: { colors: [COLOR_SILVER_TRANSPARENT_1, 'transparent'],  opacity: 0.5 },
                },
                markers: { size: 2 },
                xaxis: {
                    categories: dias,
                    axisBorder: { show: true, color: COLOR_SILVER_TRANSPARENT_5, height: 1, width: '100%', offsetX: 0, offsetY: -1 },
                    axisTicks: { show: true, borderType: 'solid', color: COLOR_SILVER, height: 6, offsetX: 0, offsetY: 0 },

                },
                legend: { show: true, position: 'bottom', offsetY: 0, horizontalAlign: 'center', floating: false, }
                }
            );
        
            chart.render();
        }
        
        $(document).on("click", ".btnConcluiEntrega", function() {
            $("#modal-entregas").modal("toggle");   
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "Marcar a entrega como concluída?",
                text: "Você ainda poderá consultar os detalhes da venda no menu 'Venda'",
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
                    $.post("components/venda/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'danger',
                                text: "Um erro ocorreu, impossível concluir a entrega."
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
                        text: "Um erro ocorreu, impossível concluir a entrega."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
        
        
        $(document).on("click", ".btnEfetivaVenda", function() {
            $("#modal-prevendas").modal("toggle");   
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "Marcar a venda como confirmada?",
                text: "Os detalhes da venda estarão disponíveis no menu 'Venda'",
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
                    $.post("components/venda/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'danger',
                                text: "Um erro ocorreu, impossível concluir a venda."
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
                        text: "Um erro ocorreu, impossível concluir a venda."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
        
        
        $(document).on("click", ".confirmDeletar", function() {
            $("#modal-entregas").modal("hide");   
            $("#modal-prevendas").modal("hide");   
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR A VENDA?",
                text: "Você não será mais capaz de recuperar esses dados!",
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
                    $.post("components/venda/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'danger',
                                text: "Um erro ocorreu, impossível excluir a venda."
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
                        text: "Um erro ocorreu, impossível excluir a venda."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });

        $('#table-vencidas').dataTable({
            responsive: true,
            lengthChange: true,
            colReorder: true,
            stateSave: true,
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
        $('#table-vencendo').dataTable({
            responsive: true,
            lengthChange: true,
            colReorder: true,
            stateSave: true,
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
    });
</script>