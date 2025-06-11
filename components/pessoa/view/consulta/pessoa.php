
<?php
  include_once("components/pessoa/action/listar_pessoa.php");
 ?>

<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Lista de clientes</h4>
    <a href="?cadPessoa" class="btn btn-primary btn-sm">Novo cliente</a>
  </div>
  <div class="panel-body">
    <div class="table-responsive overflow-hidden">
        <table id="table-clientes" class="table table-bordered table-hover table-striped w-100">
            <thead class="bg-primary">
                <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Apelido</th>
                <th>Celular</th>
                <th>Endereço</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                <?php for ( $i = 0; $i < count($listaPessoas); $i++ ) {?>
                    <tr>
                        <td><?php echo $listaPessoas[$i]["id_auto"]; ?></td>
                        <td><?php echo $listaPessoas[$i]["nome"]; ?></td>
                        <td><?php echo $listaPessoas[$i]["apelido"]; ?></td>
                        <td><?php echo $listaPessoas[$i]["celular"]; ?></td>
                        <td><?php echo $listaPessoas[$i]["rua"]." ".$listaPessoas[$i]["numero"].", ".$listaPessoas[$i]["complemento"].", ".$listaPessoas[$i]["bairro"].", ".$listaPessoas[$i]["cidade"]; ?></td>
                        <td class="text-center">
                            <a class="btn btn-info btn-icon btn-sm" href="?dtlPessoa=<?php echo $listaPessoas[$i]["id"]; ?>"><span class="fa fa-search"></span>
                            </a>
                        <?php if($_SESSION['nivel'] >= 2){ ?>
                            <a class="btn btn-warning btn-icon btn-sm" href="?edtPessoa=<?php echo $listaPessoas[$i]["id"]; ?>"><span class="fa fa-edit"></span>
                            </a>
                            <?php } ?>
                            <?php if($_SESSION['nivel'] >= 2){ ?>
                                <button name="excluir_pessoa" value="id=<?php echo $listaPessoas[$i]["id"]; ?>" class="btn btn-danger btn-icon btn-sm confirmDeletar"><i class="fa fa-trash"></i>
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
        var table = $('#table-clientes').DataTable({
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


        $(document).on("click", ".confirmDeletar", function() {
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR O CLIENTE?",
                text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa pessoa será apagado.",
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
                    $.post("components/pessoa/action/" + url + ".php", dados,
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
                                text: "Um erro ocorreu, impossível excluir o cliente."
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
                        text: "Um erro ocorreu, impossível excluir o cliente."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
    });
</script>
