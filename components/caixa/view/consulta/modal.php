
<!-- Modal center -->
<div class="modal fade" id="modal-cad-pagar" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Cadastrar conta a pagar
                </h4>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <form class="form-horizontal" id="meuForm" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30">

                    <div class="row">
                        <div class="form-group mb-3 col-sm-8">
                            <label class="form-label">Referência</label>
                            <input type="text" placeholder="" name="referencia_apagar" id="referencia_apagar" class="form-control border-primary" required>
                        </div>
                        <div class="col-sm-4 text-left">
                            <!-- <br> -->
                            <div class="row">
                                <div class="col-md-4">
                                    <br>
                                    <div class="form-check form-switch">
                                        <input type="radio" class="formaPag form-check-input" id="avista" name="forma_pag" value="1" checked />
                                        <label class="form-check-label" for="avista">A vista</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="radio" class="formaPag form-check-input" id="aprazo" name="forma_pag" value="2" />
                                        <label class="form-check-label" for="aprazo">A prazo</label>
                                    </div>
                                  
                                </div>
                                <div class="col-sm-8"  id="divprestacao">
                                    <label class="form-label col-sm-12 px-0">Nº de parcelas</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-sm btn-danger dec_parcela"><i class="fa fa-minus"></i></button>
                                        <input class="form-control text-center text-dark prestacao" readonly type="text" name="prestacao" id="prestacao" value="1">
                                        <button type="button" class="btn btn-sm btn-success inc_parcela"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label class="form-label">Fornecedor</label>
                            <select required class="form-control pag-select2" name="fornecedor" id="fornecedor">
                                <option></option>
                                <?php for ($i = 0; $i < count($listaFornecedores); $i++) { ?>
                                    <option value="<?php echo $listaFornecedores[$i]['id']; ?>"><?php echo $listaFornecedores[$i]['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-3 col-sm-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="data" id="data" value="<?php echo date('Y-m-d'); ?>" required
                                class="form-control border-primary">
                        </div>

                        <div class="form-group mb-3 col-sm-3">
                            <label class="form-label">Valor</label>
                            <input type="text" placeholder="" name="valor" id="valor"
                                data-inputmask="'alias': 'currency'" class="form-control border-primary" required>
                        </div>
                
                        <div class="form-group mb-3 col-sm-6">
                            <label class="form-label">Nota Fiscal (Arquivo)</label>
                            <input type="file" name="arquivo_nota" id="arquivo_nota" class="form-control border-primary">
                        </div>
                        <div class="form-group mb-3 col-sm-6">
                            <label class="form-label">Boleto (Arquivo)</label>
                            <input type="file" name="arquivo_boleto" id="arquivo_boleto" class="form-control border-primary">
                        </div>
                    </div>
                    <div class="row  justify-content-center" id="divcontapaga">
                        <div class="form-group mb-3 col-sm-9">
                            <label class="form-label">Recibo (Arquivo)</label>
                            <input type="file" name="arquivo_recibo" id="arquivo_recibo" class="form-control border-primary">
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            <label class="form-label">Pagamento</label>
                            <select required class="form-control pag-select2" name="conta_pag" id="conta_pag">
                                <?php for ($i=0; $i < count($listaPagamento); $i++) {  ?>
                                <option value="<?php echo $listaPagamento[$i]['id']; ?>"><?php echo $listaPagamento[$i]['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row  mt-2" id="divparcelas"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary" name="cadPagar" id="cadPagar">
                        <i class="fa fa-save"></i>
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal center -->
<div class="modal fade" id="modal-edt-pagar" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Editar conta a pagar
                </h4>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <form class="form-horizontal" id="meuFormEdt" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30">
                    <input type="hidden" name="edt_id_apagar" id="edt_id_apagar">
                    <div class="row">
                        <div class="form-group mb-3 col-sm-8">
                            <label class="form-label">Referência</label>
                            <input type="text" placeholder="" name="edt_referencia_apagar" id="edt_referencia_apagar" class="form-control border-primary" required>
                        </div>
                        <div class="col-sm-4 text-left">
                            <!-- <br> -->
                            <div class="row">
                                <div class="col-md-4">
                                <br>
                                    <div class="form-check form-switch">
                                        <input type="radio" class="edt_formaPag form-check-input" id="edt_avista" name="edt_forma_pag" value="1" checked />
                                        <label class="form-check-label" for="edt_avista">A vista</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="radio" class="edt_formaPag form-check-input" id="edt_aprazo" name="edt_forma_pag" value="2" />
                                        <label class="form-check-label" for="edt_aprazo">A prazo</label>
                                    </div>
                                  
                                </div>
                                <div class="col-sm-8"  id="edt_divprestacao">
                                    <label class="form-label col-sm-12 px-0">Nº de parcelas</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-sm btn-danger edt_dec_parcela"><i class="fa fa-minus"></i></button>
                                        <input class="form-control text-center text-dark edt_prestacao" readonly type="text" name="edt_prestacao" id="edt_prestacao" value="1">
                                        <button type="button" class="btn btn-sm btn-success edt_inc_parcela"><i class="fa fa-plus"></i></button>
                                    </div>

                                </div>
        
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label class="form-label">Fornecedor</label>
                            <select required class="form-control edt-pag-select2" name="edt_fornecedor" id="edt_fornecedor">
                                <option></option>
                                <?php for ($i = 0; $i < count($listaFornecedores); $i++) { ?>
                                    <option value="<?php echo $listaFornecedores[$i]['id']; ?>"><?php echo $listaFornecedores[$i]['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                       
                        <div class="form-group mb-3 col-sm-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="edt_data" id="edt_data" required class="form-control border-primary">
                        </div>

                        <div class="form-group mb-3 col-sm-3">
                            <label class="form-label">Valor</label>
                            <input type="text" placeholder="" name="edt_valor" id="edt_valor"
                                data-inputmask="'alias': 'currency'" class="form-control border-primary" required>
                        </div>
                
                                              
                        <div class="form-group mb-3 col-sm-6">
                            <label class="form-label">Nota Fiscal (Arquivo)</label>
                            <input type="file" name="aedt_rquivo_nota" id="edt_arquivo_nota" class="form-control border-primary">
                        </div>
                        <div class="form-group mb-3 col-sm-6">
                            <label class="form-label">Boleto (Arquivo)</label>
                            <input type="file" name="edt_arquivo_boleto" id="edt_arquivo_boleto" class="form-control border-primary">
                        </div>
                    </div>
                    <div class="row  justify-content-center" id="edt_divcontapaga">
                        <div class="form-group mb-3 col-sm-9">
                            <label class="form-label">Recibo (Arquivo)</label>
                            <input type="file" name="arquivo_recibo" id="edt_arquivo_recibo" class="form-control border-primary">
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            <label class="form-label">Pagamento</label>
                            <select required class="form-control edt-pag-select2" name="edt_conta_pag" id="edt_conta_pag">
                                <?php for ($i=0; $i < count($listaPagamento); $i++) {  ?>
                                <option value="<?php echo $listaPagamento[$i]['id']; ?>"><?php echo $listaPagamento[$i]['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row  justify-content-center mt-2" id="edt_divparcelas"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary" name="edtPagar" id="edtPagar">
                        <i class="fa fa-save"></i>
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal center -->
<div class="modal fade" id="modal-pag-lote" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    PAGAR CONTAS EM LOTE 
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30">
                    <div class="row">
                    <input type="hidden" name="ids_parcelas" id="ids_parcelas">
                        
                        <div class="form-group col-md-6">
                            <h2 id="num_contas"></h2>
                        </div>
                        <div class="form-group col-md-6">
                            <h2 id="val_contas"></h2>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">Forma Pagamento</label>
                            <select required class="form-control lote-select2" name="pag-forma_pag" id="pag-forma_pag">
                                <option></option>
                                <?php for ($i = 0; $i < count($listaPagamento); $i++) { ?>
                                    <option value="<?php echo $listaPagamento[$i]['id']; ?>"><?php echo $listaPagamento[$i]['nome']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="data-lote" id="data-lote" value="<?php echo date('Y-m-d'); ?>" required class="form-control border-primary">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fal fa-times"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-primary" name="cad-pag-lote" id="cad-pag-lote">
                        <i class="fal fa-badge-dollar"></i>
                        Pagar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>