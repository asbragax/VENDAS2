
<?php
  include_once("components/conta/action/listar_contacaixa.php");
 ?>
<div class="row">
    <div class="col-sm-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <i class='subheader-icon fa fa-comments-alt-dollar me-1'></i> Lista de <span class="fw-300"><i>conta caixa</i></span>
                </h2>
                <div class="panel-toolbar">
                    <a href="?cadContaCaixa" class="btn btn-sm btn-success btn-pills">Novo conta caixa</a>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <table id="table-consContaCaixa" data-page-length='20' class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                  <th>Cód</th>
                                  <th>Cód. reduzido</th>
                                  <th>Descrição</th>
                                  <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ( $i = 0; $i < count($listaContaCaixa); $i++ ) {?>

                                    <tr>

                                        <td><?php echo $listaContaCaixa[$i]["id"]; ?></td>
                                        <td><?php echo $listaContaCaixa[$i]["id_reduzido"]; ?></td>
                                        <td><?php echo $listaContaCaixa[$i]["nome"]; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-icon btn-sm" href="?edtContaCaixa=<?php echo $listaContaCaixa[$i]["id"]; ?>"><span class="fa fa-edit"></span>
                                            </a>
                                            <button name="excluir_contacaixa" value="id=<?php echo $listaContaCaixa[$i]["id"]; ?>" class="btn btn-danger btn-icon btn-sm confirmDeletar"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                  <th>Cód</th>
                                  <th>Cód. reduzido</th>
                                  <th>Descrição</th>
                                  <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();


        var table = $('#table-consContaCaixa').DataTable({
            responsive: true,
            lengthChange: false,
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

       

        $("#table-consContaCaixa").on("click", ".confirmDeletar", function() {
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
                    title: "EXCLUIR A CONTA CAIXA?",
                    text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa conta caixa será apagado.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim.",
                    cancelButtonText: "Não!",
                    reverseButtons: true
                })
                .then(function(result) {
                    if (result.value) {
                        $.post("components/conta/action/" + url + ".php", dados,
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
    });
</script>
