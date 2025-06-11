<?php include_once "components/banner/action/listar_posts.php"; ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Lista de banners</h4>
        <a href="?cadPost" class="btn btn-primary btn-sm">Novo banner</a>
    </div>
    <div class="panel-body">
        <div class="table-responsive overflow-hidden">
            <table id="table-consPosts" data-page-length='15' class="table table-bordered table-hover table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th>Texto</th>
                        <th>Imagem</th>
                        <th>
                            #
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($listaPosts); $i++) { ?>
                        <tr>
                            <td> <?php echo $listaPosts[$i]['texto']; ?>
                            </td>
                            <td> <img src="arquivos/banners/<?php echo $listaPosts[$i]['img']; ?>" class="img-responsive img-bordered" style="width:80px">
                            </td>
                            <td>
                                <button name="excluir_post" value="id=<?php echo $listaPosts[$i]["id"]; ?>&foto=<?php echo $listaPosts[$i]["img"]; ?>" class="btn btn-danger btn-icon btn-sm confirmDeletar"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
                <tfoot>
                    <th>Texto</th>
                    <th>Imagem</th>
                    <th>
                        #
                    </th>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="../assets_coloradmin/js//jquery-2.2.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table-consPosts').dataTable({
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
                    className: 'btn-outline-danger btn-sm mr-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Gerar Excel',
                    className: 'btn-outline-success btn-sm mr-1'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'Gerar CSV',
                    className: 'btn-outline-info btn-sm mr-1'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copiar',
                    titleAttr: 'Copiar para área de transferência',
                    className: 'btn-outline-warning btn-sm mr-1'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    titleAttr: 'Imprimir tabela',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });


        $(document).on("click", ".confirmDeletar", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR O BANNER?",
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
                    $.post("components/banner/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            window.reload();
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível excluir o banner."
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
                        text: "Um erro ocorreu, impossível excluir o banner."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
    });
</script>