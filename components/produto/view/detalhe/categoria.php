<?php
$id = $_GET['dtlCategoria'];
include "components/produto/action/cadastrar_produto_categoria.php";

$dao = new CategoriaDAO();
$categoria = $dao->getPorIdAssoc($id);

$dao = new ProdutoDAO();
$produtos = $dao->listar();
$produtosCat = $dao->listarPorCategoria($id);

?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h2 class="panel-title">Categoria <?php echo $categoria['nome']; ?></h2>
        <a href="?consCategoria" class="btn btn-primary btn-sm">Ver categorias</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label class="form-label">Produtos</label>
                    <select class="form-control select2-placeholder" multiple="multiple" name="produtos[]" id="produtos">
                        <option></option>
                        <?php for ($i = 0; $i < count($produtos); $i++) { ?>
                            <option value="<?php echo $produtos[$i]['id']; ?>"><?php echo $produtos[$i]['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-12 text-end mt-2">
                    <button type="submit" class="btn btn-md btn-primary" name="vincular">
                        <i class="fa fa-save me-1"></i>Incluir
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h2>Produtos da categoria <?php echo $categoria['nome']; ?></h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm text-center">
                <thead>
                    <tr>
                        <th>Referência</th>
                        <th>Nome</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(isset($produtos) && count($produtos) > 0){
                    for ($i=0; $i < count($produtosCat); $i++) {  ?>
                        <tr>
                            <td><?php echo $produtosCat[$i]['id']; ?></td>
                            <td><?php echo $produtosCat[$i]['nome']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-danger confirmDeletar" name="alterar_produto_categoria" value="id=<?php echo $produtosCat[$i]['id']; ?>&categoria=0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){ 
        $('.select2-placeholder').select2({
            placeholder: "Selecione...",
            containerCssClass: 'border-primary'
        });

        $(document).on("click", ".confirmDeletar", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR O PRODUTO DA CATEGORIA?",
                text: "Tem certeza do que está fazendo? Esse produto será removido desta categoria.",
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
                                text: "Um erro ocorreu, impossível excluir o produto da categoria."
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
                        text: "Um erro ocorreu, impossível excluir o produto da categoria."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
     });
</script>