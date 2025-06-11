
<?php
$dao = new PessoaDAO();
$id = $_GET['dtlPessoa'];
// echo $id;
$pessoa = $dao->getPorIdDetails($id);
$telefone = $pessoa['telefone'];

$telefone = str_replace('(', '', $telefone);
$telefone = str_replace(')', '', $telefone);
$telefone = str_replace(' ', '', $telefone);
$telefone = str_replace('-', '', $telefone);

$celular = $pessoa['celular'];

$celular = str_replace('(', '', $celular);
$celular = str_replace(')', '', $celular);
$celular = str_replace(' ', '', $celular);
$celular = str_replace('-', '', $celular);

$dao = new Venda_produtoDAO();
$compras = $dao->listarPorCliente($id);

$dao = new Pessoa_crediarioDAO();
$crediario = $dao->listar($id);

?>
<div class="profile">
    <div class="profile-header">
        <!-- BEGIN profile-header-cover -->
        <div class="profile-header-cover"></div>
        <!-- END profile-header-cover -->
        <!-- BEGIN profile-header-content -->
        <div class="profile-header-content">
            <!-- BEGIN profile-header-info -->
            <div class="profile-header-info">
                <h4 class="mt-0 mb-1"><?php echo $pessoa['nome']; ?></h4>
                <p class="mb-2"><?php echo $pessoa['apelido']; ?></p>
                <a href="?edtPessoa=<?php echo $_GET['dtlPessoa']; ?>" class="btn btn-xs btn-yellow">Editar Cliente</a>
            </div>
            <!-- END profile-header-info -->
        </div>
        <!-- END profile-header-content -->
        <!-- BEGIN profile-header-tab -->
        <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#profile-about">SOBRE</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profile-crediario">CREDIÁRIO</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profile-compras">COMPRAS</a></li>
        </ul>
        <!-- END profile-header-tab -->
    </div>
</div>
<div class="profile-content">
    <!-- BEGIN tab-content -->
    <div class="tab-content p-0">
        <!-- BEGIN #profile-about tab -->
        <div class="tab-pane fade active show" id="profile-about">
            <!-- BEGIN table -->
            <div class="table-responsive form-inline">
                <table class="table table-profile align-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                <h4><?php echo $pessoa['nome']; ?> <small><?php echo $pessoa['apelido']; ?></small></h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="field">CPF</td>
                            <td><?php echo $pessoa['cpf']; ?> </td>
                        </tr>
                        <tr class="divider">
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field">Celular</td>
                            <td><?php echo $pessoa['celular']; ?> <a target="_blank" href="tel:<?php echo $celular; ?>" class="ms-5px text-decoration-none fw-bold"><i class="fa fa-phone fa-fw"></i> Ligar</a></td>
                        </tr>
                        <tr>
                            <td class="field">WhatsApp</td>
                            <td><?php echo $pessoa['telefone']; ?> <a target="_blank" href="https://wa.me/55<?php echo $telefone; ?>" class="ms-5px text-decoration-none fw-bold"><i class="fab fa-whatsapp fa-fw"></i> Chamar</a></td>
                        </tr>
                        <tr class="divider">
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field">Cidade</td>
                            <td><?php echo $pessoa['cidade']; ?>/<?php echo $pessoa['estado']; ?></td>
                        </tr>
                        <tr>
                            <td class="field">Bairro</td>
                            <td><?php echo $pessoa['bairro']; ?></td>
                        </tr>
                        <tr>
                            <td class="field">Rua</td>
                            <td><?php echo $pessoa['rua']; ?><?php echo ', '.$pessoa['numero']; ?><?php echo $pessoa['complemento'] != '' ? ', '.$pessoa['complemento'] : ""; ?></td>
                        </tr>
                        <tr>
                            <td class="field">Sexo</td>
                            <td><?php echo strtoupper($pessoa['sexo']); ?></td>
                        </tr>
                        <tr>
                            <td class="field">Nascimento</td>
                            <td><?php echo $pessoa['dataf']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END table -->
        </div>
        <!-- END #profile-about tab -->
        <!-- BEGIN #profile-crediario tab -->
        <div class="tab-pane fade" id="profile-crediario" data-init="true">
            <h4 class="mb-3">CREDIÁRIO DO CLIENTE</h4>
            <div class="table-responsive">
                <table class="table table-sm table-striped m-0 col-sm-12">
                    <thead class="bg-warning color-black">
                        <tr colspan="12">
                            <th>Data</th>
                            <th>Cód. Venda</th>
                            <th>Valor</th>
                            <th>Valor Pag.</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($crediario); $i++) {  ?>
                            <tr>
                                <th scope="row"><?php echo $crediario[$i]['dataf']; ?></th>
                                <td><a target="_blank" href="?dtlVenda=<?php echo $crediario[$i]['id_venda']; ?>"><?php echo $crediario[$i]['id_venda']; ?></a></td>
                                <td><?php echo number_format($crediario[$i]['valor']/100, 2, ",", "."); ?></td>
                                <td><?php echo number_format($crediario[$i]['valor_pag']/100, 2, ",", "."); ?></td>
                                <td><?php echo $crediario[$i]['pag_crediario'] == 1 ? "Pago" : "Em aberto"; ?></td>
                                <td> 
                                    <a href="?dtlVenda=<?php echo $crediario[$i]['id_venda']; ?>" class="btn btn-sm btn-icon btn-info">
                                        <span class="fa fa-search"></span>
                                    </a>
                                    <a href="?pagCrediario=<?php echo $crediario[$i]['id_pessoa']; ?>&id_venda=<?php echo $crediario[$i]['id_venda']; ?>" class="btn btn-sm btn-icon btn-success">
                                        <span class="fa fa-dollar-sign"></span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-icon btn-danger confirmDeletarCrediario" value="id_pessoa=<?php echo $crediario[$i]['id_pessoa']; ?>&id_venda=<?php echo $crediario[$i]['id_venda']; ?>" name="excluir_crediario">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END #profile-crediario tab -->
        <!-- BEGIN #profile-vendas tab -->
        <div class="tab-pane fade" id="profile-compras">
            <h4 class="mb-3">COMPRAS DO CLIENTE</h4>
            <div class="table-responsive">
                <table class="table table-sm table-striped m-0 col-sm-12">
                    <thead class="bg-info color-black">
                        <tr colspan="12">
                            <th>Produto</th>
                            <th>Data</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($compras); $i++) {  ?>
                            <tr>
                                <th scope="row"><?php echo $compras[$i]['nome']; ?></th>
                                <td><?php echo $compras[$i]['data']; ?></td>
                                <td><?php echo $compras[$i]['quantidade']; ?></td>
                            </tr>
                        <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END #profile-vendas tab -->
        
    </div>
    <!-- END tab-content -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        
        $(".confirmDeletarCrediario").on("click", function(e) {
            var dados = $(this).val();
            var url = $(this).attr('name');

            e.preventDefault();
            $('#modal_crediario').modal('toggle');
            
            var swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger me-2"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
                .fire({
                    title: "EXCLUIR?",
                    text: "Excluir o débito em aberto do pessoa? Não será possível recuperar.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim.",
                    cancelButtonText: "Não!",
                    reverseButtons: true
                })
                .then(function(result) {
                    if (result.value) {
                        $.post("action/" + url + ".php", dados,
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
