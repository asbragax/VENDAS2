<!-- Modal center -->

<div class="modal modal-message fade" id="modal-edt-item" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h4 class="modal-title">Editar produto</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <label class="form-label">Produto</label>
                            <select data-placeholder="Produto" class="form-control edtselect2" name="edt_produto" id="edt_produto">
                                <?php for ($i = 0; $i < count($listaProdutos); $i++) { ?>
                                    <option value="<?php echo $listaProdutos[$i]["id"]; ?>">
                                        <?php echo $listaProdutos[$i]["nome"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="edt_quantidade" id="edt_quantidade" min="1" class="form-control border-primary" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valor unit.</label>
                            <input type="text" name="edt_vlunit" id="edt_vlunit" data-inputmask="'alias':'currency'" class="form-control border-primary" />
                        </div>
                        <input type="hidden" name="edt_i" id="edt_i">
                        <input type="hidden" name="edt_nome" id="edt_nome">
                        <input type="hidden" name="edt_vlcompra" id="edt_vlcompra">
                        <input type="hidden" name="edt_kg" id="edt_kg">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Fechar</a>
                    <button type="submit" class="btn btn-primary" name="salvar-edt">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
