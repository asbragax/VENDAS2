
<?php include_once('components/produto/action/listar_categoria.php'); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Lista de categorias</h4>
        <a href="?cadCategoria" class="btn btn-primary btn-sm">Nova categoria</a>
    </div>
    <div class="panel-body">
        <div class="table-responsive overflow-hidden">
            <table id="table" class="table table-bordered table-hover table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th>Cód</th>
                        <th>Nome</th>
                        <th>Foto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dao = new CategoriaDAO();
                    for ($i = 0; $i < count($listaCategorias); $i++) { 
                        ?>
                        <tr>
                            <td><?php echo $listaCategorias[$i]["id"]; ?></td>
                            <td><?php echo $listaCategorias[$i]["nome"]; ?></td>
                            <td><img src="arquivos/categorias/<?php echo $listaCategorias[$i]["foto"]; ?>" alt=""></td>
                            <td class="text-center">
                                <?php if($_SESSION['nivel'] >= 2){ ?>
                                    <a class="btn btn-info btn-icon btn-sm" href="?dtlCategoria=<?php echo $listaCategorias[$i]["id"]; ?>"><span class="fa fa-search"></span></a>
                                    <a class="btn btn-warning btn-icon btn-sm" href="?edtCategoria=<?php echo $listaCategorias[$i]["id"]; ?>"><span class="fa fa-edit"></span></a>
                                    <button name="excluir_categoria" value="id=<?php echo $id; ?>" class="btn btn-danger confirmDeletar btn-sm btn-icon">
                                        <i class="fa fa-trash"></i>
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
       
        $('#table').dataTable({
            responsive: true,
            lengthChange: true,
            colReorder: true,
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
        $(document).on("click", ".confirmDeletar", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR A CATEGORIA?",
                text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa categproa será apagado.",
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
                    $.post("components/produto/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            window.location.replace("?consProduto");
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível excluir a categoria."
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
                        text: "Um erro ocorreu, impossível excluir a categoria."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
       
    });
</script>