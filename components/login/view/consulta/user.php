<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fa fa-users'></i> USUÁRIOS
    </h1>
    <div class="subheader-block">
        <a href="?cadUser" class="btn btn-success btn-pills">Novo usuário</a>
    </div>
</div>


<?php

if ($_SESSION['nivel'] == 4) {

    $userDao = new UserDAO();
    $usuarios = $userDao->listar_all_level();
} else {
    $userDao = new UserDAO();
    $usuarios = $userDao->listar_under_3();
}


?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">

                <h2>
                    Lista de <span class="fw-300"><i>usuários</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>Nível de acesso</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($usuarios); $i++) {  ?>
                                <tr>
                                    <td><?php echo $usuarios[$i]["nome"]; ?> </td>
                                    <td><?php echo $usuarios[$i]["username"]; ?> </td>
                                    <td><?php echo $usuarios[$i]["level"]; ?> </td>
                                    <td class="text-center">
                                        <?php
                                        if ($usuarios[$i]["verified"] == 0) {
                                            echo "<span class='badge badge-secondary badge-pill'>Inativo</span>";
                                        } else if ($usuarios[$i]["verified"] == 1) {
                                            echo "<span class='badge badge-success badge-pill'>Ativo</span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="?edtUser=<?php echo $usuarios[$i]["id"]; ?>" class="btn btn-primary btn-sm btn-icon"><i class="fa fa-edit"></i>
                                        </a>
                                        <?php if ($_SESSION['nivel'] >= 3) { ?>
                                            <button name="excluir_user" value="excUser=<?php echo $usuarios[$i]["id"]; ?>" class="btn btn-danger confirmUser btn-sm btn-icon">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <?php if ($usuarios[$i]["verified"] == 1) { ?>
                                                <button name="desativar_user" value="excUser=<?php echo $usuarios[$i]["id"]; ?>" class="btn btn-warning confirmDesativar btn-sm btn-icon">
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button name="ativar_user" value="excUser=<?php echo $usuarios[$i]["id"]; ?>" class="btn btn-success confirmAtivar btn-sm btn-icon">
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                        <?php }
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>Nível de acesso</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // initialize datatable
        $('#dt-basic-example').dataTable({
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

        $(document).on("click", ".confirmUser", function() {
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
                    title: "Você tem certeza?",
                    text: "Você não será capaz de reverter isso.",
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
                                debugger
                                if (data != false) {
                                    //$("#resposta").html(pegaRespostaDiv("delete", "ok")).show();
                                   location.reload();
                                    
                                }

                            }, "html");

                        swalWithBootstrapButtons.fire(
                            "Deletado!",
                            "O usuário foi apagado.",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelado",
                            "Seus dados estão seguros",
                            "error"
                        );
                    }
                });
        }); // A message with a custom image and CSS animation disabled


        $(document).on("click",".confirmDesativar", function() {
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
                    title: "Você tem certeza?",
                    text: "Você será capaz de reverter isso.",
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
                                debugger
                                if (data != false) {
                                    //$("#resposta").html(pegaRespostaDiv("delete", "ok")).show();
                                   location.reload();
                                    
                                }

                            }, "html");

                        swalWithBootstrapButtons.fire(
                            "Desativado!",
                            "O usuário foi apagado.",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelado",
                            "Seus dados estão seguros",
                            "error"
                        );
                    }
                });
        }); // A message with a custom image and CSS animation disabled

        $(document).on("click", ".confirmAtivar", function() {
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
                    title: "Você tem certeza?",
                    text: "Você será capaz de reverter isso.",
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
                                debugger
                                if (data != false) {
                                    //$("#resposta").html(pegaRespostaDiv("delete", "ok")).show();
                                   location.reload();
                                    
                                }

                            }, "html");

                        swalWithBootstrapButtons.fire(
                            "Ativado!",
                            "O usuário foi apagado.",
                            "success"
                        );
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelado",
                            "Seus dados estão seguros",
                            "error"
                        );
                    }
                });
        }); // A message with a custom image and CSS animation disabled


    });
</script>
