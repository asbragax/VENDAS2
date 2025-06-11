<?php include_once('components/conta/action/cadastrar_contareceita.php'); ?>
<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                <i class='subheader-icon fa fa-comments-dollar me-1'></i> Nova <span class="fw-300"><i>conta receita</i></span>
            </h2>
            <div class="panel-toolbar">
                <a href="?consContaReceita" class="btn btn-info btn-sm btn-pills">Ver contas receita</a>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label class="form-label">Código</label>
                            <input type="text" class="form-control border-primary" name="id" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="form-label">Código reduzido</label>
                            <input type="text" class="form-control border-primary" name="id_reduzido" required>
                        </div>
                        <div class="form-group col-sm-8">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control border-primary" name="nome" required autofocus>
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