<?php 
$dao = new CategoriaDAO();
$categoria = $dao->getPorId($_GET['dtlCategoria']);
include_once('components/conta/action/vincular_subcategoria.php');
include_once('components/conta/action/listar_subcategoria.php');

$dao = new SubcategoriaDAO();
$subcategorias = $dao->listarPorCategoria($_GET['dtlCategoria']);

?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                <i class='subheader-icon fa fa-tag me-1'></i> Vincular <span class="fw-300"><i>categoria</i></span>
            </h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="form-label">Categoria</label>
                            <input type="text" class="form-control border-primary" name="nome" disabled value="<?php echo $categoria['nome']; ?>">
                            <input type="hidden" name="id" value="<?php echo $_GET['dtlCategoria']; ?>">
                        </div>

                        <div class="form-group col-sm-4">
                            <label class="form-label">Nova subcategoria</label>
                            <input type="text" class="form-control border-primary" name="novasub">
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="form-label">Subcategoria existente</label>
                            <select class="select2-placeholder form-control" id="id_sub" name="id_sub">
                                <option></option>
                                <?php for ($i = 0; $i < count($listaSubcategoria); $i++) { ?>
                                    <option value="<?php echo $listaSubcategoria[$i]["id"]; ?>" <?php echo is_integer(array_search($listaSubcategoria[$i]["id"], array_column($subcategorias, 'id_subcategoria'))) ? "disabled" : ""; ?>>
                                        <?php echo $listaSubcategoria[$i]["nome"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 text-end mt-2 px-0">
                        <button type="submit" class="btn btn-success" name="salvar">
                            <span class="fa fa-save me-1"></span>
                            Salvar
                        </button>
                    </div>

                </form>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-primary">
                            <th>Subcategoria</th>
                            <th>#</th>
                        </thead>
                        <tbody>
                            <?php for ($i=0; $i < count($subcategorias); $i++) { ?>
                                <tr>
                                    <td><?php echo $subcategorias[$i]['nome']; ?></td>
                                    <td>
                                        <button name="excluir_categoria_subcategoria" value="id=<?php echo $subcategorias[$i]["id_categoria"]; ?>&sub=<?php echo $subcategorias[$i]["id_subcategoria"]; ?>" class="btn btn-danger btn-icon btn-sm confirmDeletar"><i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();
        $(".select2-placeholder").select2({
            allowClear: true,
            placeholder: "Selecione..."
        });
        $(document).on("click", ".confirmDeletar", function() {
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
                    title: "DESVINCULAR SUBCATEGORIA?",
                    text: "Tem certeza do que está fazendo?",
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