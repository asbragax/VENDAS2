<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fa fa-lock'></i> NOVO NÍVEL
    </h1>
    <div class="subheader-block">
        <a href="?consNivel" class="btn btn-info btn-pills">Ver niveis</a>
    </div>
</div>
<?php include("components/login/action/cadastrar_nivel.php"); ?>
<div id="panel-1" class="panel">
    <div class="panel-hdr">
        <h2>
            Informações
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                <div class="row">
                    <!-- Nome -->
                    <div class="form-group mb-3 col-sm-6">
                        <label class="control-label">Id</label>
                        <input type="text" class="form-control border-primary" name="id" id="id">
                    </div>
                    <div class="form-group mb-3 col-sm-6">
                        <label class="control-label">Nome do nível</label>
                        <input type="text" class="form-control border-primary" name="nome" id="nome">
                    </div>
                </div>
                <!-- Footer goes here -->
                <div class="col-sm-12 text-end">
                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-save"></i> Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
