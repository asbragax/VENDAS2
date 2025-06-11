<?php 
$dao = new UserDAO();
$vendedores = $dao->listar_under_3();

if(isset($_POST['vendedor'])){
    $id = $_POST['vendedor'];
}else{
    $id = $vendedores[0]['id'];
}

if(isset($_POST['status'])){
    $status = $_POST['status'];
}else{
    $status = '*';
}


$dao = new VendaDAO();
$listaVendas = $dao->listar_por_vendedor($id, $status);
?>
<div class="btn-group w-100">
  <a href="?consVendaConsignado" class="btn btn-purple">Consignado</a>
  <a href="?consVenda" class="btn btn-purple">Concluídas</a>
  <a href="?consVendaVendedor" class="btn btn-purple active">Por vendedor</a>
  <a href="?consVendaSite" class="btn btn-purple">Do site</a>
</div>
<div class="panel panel-inverse bg-dark">
    <div class="panel-body row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-6 text-white">
                    <label class="form-label">Vendedor</label>
                    <select class="select2 form-control" required name="vendedor" id="vendedor">
                        <option value=""></option>
                        <?php for ($i = 0; $i < count($vendedores); $i++) { ?>
                            <option value="<?php echo $vendedores[$i]['id']; ?>" <?php echo $vendedores[$i]['id'] == $id ? 'selected' : 0; ?>>
                                <?php echo $vendedores[$i]['nome']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-white">Status</label>
                    <select required class="form-control select2" name="status" id="status">
                        <option value="*" <?php echo '*' == $status ? "selected" : ""; ?>>Todas</option>
                        <option value="1" <?php echo '1' == $status ? "selected" : ""; ?>>Consignado</option>
                        <option value="0" <?php echo '0' == $status ? "selected" : ""; ?>>Concluídas</option>
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
        <h4 class="panel-title">Lista de vendas por vendedor</h4>
        <a href="?cadVenda" class="btn btn-primary btn-sm">Nova venda</a>
    </div>
    <div class="panel-body">
        <div class="table-responsive overflow-hidden">
            <table id="table-porvendedor" class="table table-bordered table-hover table-striped w-100">
                <thead class="bg-primary">
                    <tr>
                        <th>Id</th>
                        <th>Data</th>
                        <th>Produto / Quantidade</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Vendedor</th>
                        <th>Pagamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dao = new Venda_produtoDAO();
                    $pdao = new Venda_pagamentoDAO();
                    for ($i = 0; $i < count($listaVendas); $i++) {
                        $produtos = $dao->listar($listaVendas[$i]['id']);  
                        $pagamentos = $pdao->listar($listaVendas[$i]['id']);  
                         ?>
                        <tr>
                            <td><?php echo $listaVendas[$i]["id"]; ?></td>
                            <td><?php echo $listaVendas[$i]["dataf"]; ?></td>
                            <td>
                                <?php 
                                    for ($x = 0; $x < count($produtos); $x++) {
                                        echo $produtos[$x]["nome"] . " #".$produtos[$x]["tamanho"]." x " . $produtos[$x]["quantidade"] . "<br>";
                                    }
                                    $produtos = null;
                                ?>
                            </td>

                            <td>
                                <?php echo $listaVendas[$i]["nome_cliente"]; ?>
                            </td>
                            <td><?php echo "R$" . number_format((($listaVendas[$i]["valor"]-$listaVendas[$i]["desconto"]) / 100), "2", ",", "."); ?>
                            <td>
                                <?php echo $listaVendas[$i]["nome_vendedor"]; ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    if($listaVendas[$i]['prevenda'] == 1){
                                        echo "Consignado";
                                    }elseif($listaVendas[$i]['forma_pag'] == 98){
                                        echo "Crediário";
                                    }elseif($listaVendas[$i]['forma_pag'] == 96){
                                        echo "Parcelado";
                                    }elseif($listaVendas[$i]['forma_pag'] != 98){
                                        for ($x = 0; $x < count($pagamentos); $x++) {
                                            if($pagamentos[$x]["id_pagamento"] < 90){
                                                echo $pagamentos[$x]["nome"]."<br>";
                                            }elseif($pagamentos[$x]["id_pagamento"] == 96){
                                                echo "Parcelado<br>";
                                            }elseif($pagamentos[$x]["id_pagamento"] == 98){
                                                echo "Crediário<br>";
                                            }
                                        }
                                        $pagamentos = null;
                                    }
                                ?>
                            </td>

                            <td class="text-center">
                                <!-- <button class="confirmImprimir btn btn-sm btn-icon btn-default" name="ticket_venda" value="id=<?php echo $listaVendas[$i]["id"]; ?>">
                                    <i class="fa fa-print"></i>
                                </button> -->
                                    <a class="btn btn-sm btn-icon btn-info" href="?dtlVenda=<?php echo $listaVendas[$i]["id"]; ?>&vendedor=1">
                                    <i class="fa fa-search"></i>
                                </a> 
                                <?php if ($_SESSION['nivel'] >= 3) { ?>
                                    <a class="btn btn-sm btn-icon btn-warning" href="?edtVenda=<?php echo $listaVendas[$i]["id"]; ?>">
                                        <i class="fa fa-edit"></i>
                                    </a> 
                                    <button class="btn btn-danger btn-icon btn-sm confirmDeletar" name="excluir_venda" value="excVenda=<?php echo $listaVendas[$i]["id"]; ?>">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

    $(".select2").select2({ 
            placeholder: "Selecione",
            containerCssClass: "border-primary"
        });
 $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

    $('#table-porvendedor').dataTable({
        responsive: true,
        lengthChange: true,
        colReorder: true,
        stateSave: true,
        order: [[ 0, "desc" ]],
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


    $("#table-porvendedor").on("click", ".confirmDeletar", function() {
        var dados = $(this).val();
        var url = $(this).attr('name');
        swal({
            title: "EXCLUIR A VENDA?",
            text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa venda será apagado.",
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
});
</script>