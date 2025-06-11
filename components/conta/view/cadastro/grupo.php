<?php include_once('components/conta/action/cadastrar_grupo.php'); ?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                <i class='subheader-icon fa fa-tag me-1'></i> Novo <span class="fw-300"><i>grupo</i></span>
            </h2>
            <div class="panel-toolbar">
                <a href="?consGrupo" class="btn btn-info btn-sm btn-pills">Ver grupos</a>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="form-label">Id (Letra que aparecerá no relatório)</label>
                            <input type="text" class="form-control border-primary" name="id" required autofocus>
                        </div>
                        <div class="form-group col-sm-9">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control border-primary" name="nome" required>
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

    });
</script>