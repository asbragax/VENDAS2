
<!-- Modal center -->
<div class="modal fade" id="modal_compras" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title color-black">
                    Compras do(a) cliente.
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30 table-responsive">
                    <table class="table table-sm table-striped m-0 col-sm-12">
                        <thead class="bg-primary-500 color-black">
                            <tr colspan="12">
                                <th>Produto</th>
                                <th>Data</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($compras); $i++) {  ?>
                                <tr>
                                    <th scope="row"><?php echo $compras[$i]['nome']; ?></th>
                                    <td><?php echo $compras[$i]['data']; ?></td>
                                    <td><?php echo $compras[$i]['quantidade']; ?></td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal center -->
<div class="modal fade" id="modal_crediario" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title color-black">
                    Contas em aberto do(a) cliente.
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                <div class="modal-body min-vh-30 table-responsive">
                    <table class="table table-sm table-striped m-0 col-sm-12">
                        <thead class="bg-primary-500 color-black">
                            <tr colspan="12">
                                <th>Data</th>
                                <th>Cód. Venda</th>
                                <th>Valor</th>
                                <th>Valor Pag.</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($crediario); $i++) {  ?>
                                <tr>
                                    <th scope="row"><?php echo $crediario[$i]['dataf']; ?></th>
                                    <td><a target="_blank" href="?dtlVenda=<?php echo $crediario[$i]['id_venda']; ?>"><?php echo $crediario[$i]['id_venda']; ?></a></td>
                                    <td><?php echo number_format($crediario[$i]['crediario']/100, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($crediario[$i]['valor_pag']/100, 2, ",", "."); ?></td>
                                    <td><?php echo $crediario[$i]['pag_crediario'] == 1 ? "Pago" : "Em aberto"; ?></td>
                                    <td> 
                                        <a href="?dtlVenda=<?php echo $crediario[$i]['id_venda']; ?>" class="btn btn-sm btn-icon btn-info">
                                            <span class="fa fa-search"></span>
                                        </a>
                                        <a href="?pagCrediario=<?php echo $crediario[$i]['id_pessoa']; ?>&id_venda=<?php echo $crediario[$i]['id_venda']; ?>" class="btn btn-sm btn-icon btn-success">
                                            <span class="fa fa-sack-dollar"></span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger confirmDeletarCrediario" value="id_pessoa=<?php echo $crediario[$i]['id_pessoa']; ?>&id_venda=<?php echo $crediario[$i]['id_venda']; ?>" name="excluir_crediario">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
