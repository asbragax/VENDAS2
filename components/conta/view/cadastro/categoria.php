<?php include_once('components/conta/action/cadastrar_categoria.php');
 include_once('components/conta/action/listar_grupo.php'); ?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                <i class='subheader-icon fa fa-tag me-1'></i> Nova <span class="fw-300"><i>categoria</i></span>
            </h2>
            <div class="panel-toolbar">
                <a href="?consCategoria" class="btn btn-info btn-sm btn-pills">Ver categorias</a>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="form-label">Descrição</label>
                            <input type="text" class="form-control border-primary" name="nome" required autofocus>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="form-label">CC</label>
                            <input type="text" class="form-control border-primary" name="cc">
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="form-label">CC reduzido</label>
                            <input type="text" class="form-control border-primary" name="cc_reduzido">
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form-label">Grupo</label>
                            <select class="select2-placeholder form-control" id="grupo" name="grupo">
                                <option></option>
                                <?php for ($i = 0; $i < count($listaGrupo); $i++) { ?>
                                    <option value="<?php echo $listaGrupo[$i]["id"]; ?>">
                                        <?php echo $listaGrupo[$i]["nome"]; ?>
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
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();
        $(".select2-placeholder").select2({
            allowClear: true,
            placeholder: "Selecione...",
            containerCssClass: "border-primary"
        });
    });
</script>