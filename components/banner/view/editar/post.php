<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-cut'></i> EDITAR SERVIÇO
    </h1>
    <div class="subheader-block">
        <a href="?consServico" class="btn btn-info btn-pills">Ver serviços</a>
    </div>
</div>

<?php
include "components/banner/action/editar_servico.php";
$id = $_GET['edtServico'];

$dao = new ServicoDAO();
$servico = $dao->getPorId($id);
?>


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
                    <div class="form-group col-sm-6">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" autofocus class="form-control" value="<?php echo $servico->getNome(); ?>">
                    </div>

                    <div class="form-group col-sm-3">
                        <label class="form-label">Preço</label>
                        <input class="form-control" type="text" name="valor" id="valor" value="<?php echo str_replace('.', ',', ($servico->getValor() / 100)); ?>" data-inputmask='"alias":"currency"' />
                    </div>
                    <!-- <div class="form-group col-sm-3">
                                            <label class="form-label">Pontuação</label>
                                            <input type="text" class="form-control" name="ponto" id="ponto" value="<?php //echo $servico->getPonto();
                                                                                                                    ?>" data-inputmask='"alias":"decimal"' />
                                        </div> -->

                    <div class="form-group col-sm-3">
                        <label class="form-label">Porcentagem</label>
                        <input type="text" class="form-control" name="porcentagem" id="porcentagem" value="<?php echo $servico->getPorcentagem() * 100; ?>" />
                    </div>


                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="fal fa-save mr-1"></i>Salvar
                        </button>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets_coloradmin/js//jquery-2.2.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();
    });
</script>