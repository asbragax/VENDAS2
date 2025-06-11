<!-- Modal center -->
<div class="modal fade" id="modal-entregas" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Entregas em aberto
                </h4>
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <div class="modal-body min-vh-30">
                <div class="table-responsive">
                    <table class="table table-striped table-border w-100">
                        <thead class="bg-info text-white">
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Produto(s)</th>
                            <th>Valor</th>
                            <th>Endereço</th>
                            <th>Pago</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php 
                            // if(isset($listaEntregasAbertas)){
                            //  $dao = new Venda_produtoDAO();
                            // for ($i=0; $i < count($listaEntregasAbertas); $i++) { 
                            //     $produtos = $dao->listar($listaEntregasAbertas[$i]['id']);
                            ?>
                            <tr>
                                <td><?php //echo $listaEntregasAbertas[$i]['dataf']; ?></td>
                                <td><?php //echo $listaEntregasAbertas[$i]['nome_cliente']; ?></td>
                                <td>
                                <?php 
                                    // for ($x = 0; $x < count($produtos); $x++) {
                                    //     echo $produtos[$x]["nome"] . " x " . $produtos[$x]["quantidade"] . "<br>";
                                    // }
                                    // $produtos = null;
                                    ?>
                                </td>
                                <td><?php //echo "R$" . number_format((($listaEntregasAbertas[$i]["valor"]-$listaEntregasAbertas[$i]["desconto"]) / 100), "2", ",", "."); ?>
                                <td><?php //echo $listaEntregasAbertas[$i]['endereco']; ?></td>
                                <td><?php //echo $listaEntregasAbertas[$i]['pag'] == 1 ? "Sim" : "Não"; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-info btnConcluiEntrega" value="id=<?php //echo $listaEntregasAbertas[$i]['id']; ?>" name="concluir_entrega">
                                        <i class="fa fa-check-square"></i>
                                    </button>
                                    <?php // if($_SESSION['nivel'] >= 3){ ?>   
                                        <button class="btn btn-danger btn-icon btn-sm confirmDeletar" name="excluir_venda" value="excVenda=<?php //echo $listaEntregasAbertas[$i]["id"]; ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    <?php // } ?>
                                </td>
                            </tr>
                            <?php // } 
                            // }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal center -->
<div class="modal fade" id="modal-prevendas" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Pré vendas em aberto
                </h4>
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <div class="modal-body min-vh-30">
                <div class="table-responsive">
                    <table class="table table-striped table-border w-100">
                        <thead class="bg-info text-white">
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Produto(s)</th>
                            <th>Valor</th>
                            <th>Endereço</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php 
                            // if(isset($listaPrevenda)){
                            //  $dao = new Venda_produtoDAO();
                            // for ($i=0; $i < count($listaPrevenda); $i++) { 
                            //     $produtos = $dao->listar($listaPrevenda[$i]['id']);
                            ?>
                            <tr>
                                <td><?php //echo $listaPrevenda[$i]['dataf']; ?></td>
                                <td><?php //echo $listaPrevenda[$i]['nome_cliente']; ?></td>
                                <td>
                                <?php 
                                   //
                                    ?>
                                </td>
                                <td><?php //echo "R$" . number_format((($listaPrevenda[$i]["valor"]-$listaPrevenda[$i]["desconto"]) / 100), "2", ",", "."); ?>
                                <td><?php //echo $listaPrevenda[$i]['endereco']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-info btnEfetivaVenda" value="id=<?php //echo $listaPrevenda[$i]['id']; ?>" name="efetivar_venda">
                                        <i class="fa fa-check-square"></i>
                                    </button>
                                    <?php //if($_SESSION['nivel'] >= 3){ ?>   
                                        <button class="btn btn-danger btn-icon btn-sm confirmDeletar" name="excluir_venda" value="excVenda=<?php //echo $listaPrevenda[$i]["id"]; ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php //} 
                            //}?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal center -->
<div class="modal fade" id="modal-vencidas" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Parcelas em atraso
                </h4>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <div class="modal-body min-vh-30">
                <div class="table-responsive overflow-hidden">
                    <table id="table-vencidas" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-info text-white">
                            <th>Id venda</th>
                            <th>Vendedor</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Juros</th>
                            <th>Total</th>
                            <th>Vencimento</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($vencidas)){
                                $totaljuros = 0;
                            for ($i=0; $i < count($vencidas); $i++) { 
                                $earlier = new DateTime($vencidas[$i]['vencimento']);
                                $later = new DateTime(date('Y-m-d'));
                        
                                $diff = $later->diff($earlier);
                                // echo (($JUROS_MORA * $conta['valor_pag'])/30) * $dias;
                                if($diff->invert == 1){
                                    $valor_juros = ($vencidas[$i]['valor_pag'] * $JUROS_AO_MES) + ((($JUROS_MORA * $vencidas[$i]['valor_pag'])/30) * $diff->days);
                                    
                                }else{
                                    $valor_juros = 0;
                                }

                                $totaljuros += $valor_juros;
                            ?>
                            <tr>
                                <td><?php echo $vencidas[$i]["id_venda"]; ?></td>
                                <td><?php echo $vencidas[$i]["nome_vendedor"]; ?></td>
                                <td><?php echo $vencidas[$i]["nome"]; ?></td>
                                <td>R$ <?php echo number_format($vencidas[$i]["valor_pag"]/100, 2, ",", "."); ?></td>
                                <td>R$ <?php echo number_format($valor_juros/100, 2, ",", "."); ?></td>
                                <td><strong>R$ <?php echo number_format(($vencidas[$i]["valor_pag"] + $valor_juros)/100, 2, ",", "."); ?></strong></td>
                                <td><?php echo $vencidas[$i]["vencimentof"]; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-icon btn-sm" href="?pagPrestacao=<?php echo $vencidas[$i]["id"]; ?>"><span class="fa fa-dollar-sign"></span>
                                    </a>
                                    <?php if($_SESSION['nivel'] >= 2){ ?>
                                        <a class="btn btn-warning btn-icon btn-sm" href="?edtVenda=<?php echo $vencidas[$i]["id_venda"]; ?>"><span class="fa fa-edit"></span>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } 
                            }?>
                          
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>TOTAIS</th>
                                <th>R$ <?php echo number_format(array_sum(array_column($vencidas,"valor_pag"))/100, 2, ",", "."); ?></th>
                                <th>R$ <?php echo number_format($totaljuros/100, 2, ",", "."); ?></th>
                                <th><strong>R$ <?php echo number_format((array_sum(array_column($vencidas,"valor_pag")) + $totaljuros)/100, 2, ",", "."); ?></strong></th>
                                <th></th>
                                <th class="text-center"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal center -->
<div class="modal fade" id="modal-vencendo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Parcelas vencendo hoje
                </h4>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <div class="modal-body min-vh-30">
                <div class="table-responsive overflow-hidden">
                    <table id="table-vencendo" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-info text-white">
                            <th>Id venda</th>
                            <th>Vendedor</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($vencendo)){
                            for ($i=0; $i < count($vencendo); $i++) { 
                            ?>
                            <tr>
                                <td><?php echo $vencendo[$i]["id_venda"]; ?></td>
                                <td><?php echo $vencendo[$i]["nome_vendedor"]; ?></td>
                                <td><?php echo $vencendo[$i]["nome"]; ?></td>
                                <td>R$ <?php echo number_format($vencendo[$i]["valor_pag"]/100, 2, ",", "."); ?></td>
                                <td><?php echo $vencendo[$i]["vencimentof"]; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-icon btn-sm" href="?pagPrestacao=<?php echo $vencendo[$i]["id"]; ?>"><span class="fa fa-dollar-sign"></span>
                                    </a>
                                    <?php if($_SESSION['nivel'] >= 2){ ?>
                                        <a class="btn btn-warning btn-icon btn-sm" href="?edtVenda=<?php echo $vencendo[$i]["id_venda"]; ?>"><span class="fa fa-edit"></span>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } 
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>