<div class="modal fade" id="modal-add-fotos" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title color-black">
                    Incluir foto(s)
                </h4>
                <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="form-label">Imagem</label>
                            <input type="file" class="form-control border-primary" name="arquivos[]" multiple>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary" name="salvar_fotos">
                        <i class="fa fa-save"></i>
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-cor" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title color-black">
                    Incluir cor
                </h4>
                <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="form-label">Cor</label>
                            <input type="text" value="black" name="cor" class="form-control" id="colorpicker-default" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form-label">Nome da cor</label>
                            <input type="text" required value="Preto" name="nome" class="form-control" />
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary" name="salvar_cores">
                        <i class="fa fa-save"></i>
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>