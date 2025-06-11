<?php 
include_once('components/fornecedor/action/listar_fornecedor.php'); 
include_once('components/nota/action/cadastrar_nota.php'); 
?>

<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Nova nota</h4>
    <a href="?consNota" class="btn btn-primary btn-sm">Ver notas</a>
  </div>
  <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-3 col-sm-4">
                    <label class="form-label">Número da nota</label>
                    <input type="text" class="form-control border-primary" name="numero" autofocus>
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control border-primary" required name="data" value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-group mb-3 col-sm-5">
                    <label class="form-label">Fornecedor</label>
                    <select class="select2 form-control" required name="fornecedor" id="fornecedor">
                        <option value=""></option>
                        <?php for ($i = 0; $i < count($listaFornecedores); $i++) { ?>
                            <option value="<?php echo $listaFornecedores[$i]['id']; ?>">
                                <?php echo $listaFornecedores[$i]['nome']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label">Valor</label>
                    <input class="form-control border-primary" required type="text" name="valor" id="valor" data-inputmask="'alias':'currency'" />
                </div>
                <div class="form-group mb-3 col-sm-9">
                    <label class="form-label">Arquivo</label>
                    <input type="file" class="form-control border-primary" name="arquivo">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Observação</label>
                    <textarea class="form-control border-primary" name="obs" id="obs"></textarea>
                </div>
            </div>
            
            <div class="col-sm-12 mt-2 px-0">
                <button type="submit" class="btn btn-success float-end" name="salvar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();

        $('.select2').select2({
            placeholder: "Selecione...",
            allowClear: true,
            containerCssClass: "border-primary"
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });
</script>