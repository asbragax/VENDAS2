<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fa fa-lock'></i> NIVEIS
    </h1>
    <div class="subheader-block">
        <a href="?cadNivel" class="btn btn-success btn-pills">Novo nivel</a>
    </div>
</div>

<?php
include("components/login/action/listar_nivel.php");

?>

<div class="row">
    <div class="col-sm-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Lista de <span class="fw-300"><i>níveis de acesso</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <table id="table-consNiveis" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($listaNivel); $i++) { ?>

                                    <tr>
                                        <td> <?php echo $listaNivel[$i]["id"]; ?> </td>
                                        <td> <?php echo $listaNivel[$i]["nome"]; ?> </td>
                                        <td>
                                            <a href="?edtNivel=<?php echo $listaNivel[$i]["id"]; ?>" class="btn btn-info btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                            <button name="excluir_nivel" value="excNivel=<?php echo $listaNivel[$i]["id"]; ?>" class="btn btn-danger btn-icon confirmDeletar btn-sm"><i class="fa fa-trash"></i></button>

                                        </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
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
        $('#table-consNiveis').dataTable({
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

        $(".confirmDeletar").on("click", function() {
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
                    title: "EXCLUIR?",
                    text: "EXCLUIR O NIVEL?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim.",
                    cancelButtonText: "Não!",
                    reverseButtons: true
                })
                .then(function(result) {
                    if (result.value) {
                        $.post("components/login/action/" + url + ".php", dados,
                            function(data) {
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
