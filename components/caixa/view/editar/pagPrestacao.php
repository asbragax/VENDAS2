<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="../assets_coloradmin/css/radio.css">
<?php
include_once("components/conta/action/listar_pagamento.php");
        $id = $_GET['pagPrestacao'];
        $pagdao = new Pessoa_crediarioDAO();
        $conta = $pagdao->getUmaParcela($id);
        $parcelas = $pagdao->listar_parcelas($conta['id_crediario']);
        
        $pagdao = new VendaDAO();
        $venda = $pagdao->getPorIdDetails($conta['id_venda']);
        
        $pagdao = new Venda_produtoDAO();
        $produtos = $pagdao->listar($conta['id_venda']);

        if($JUROS == 1){
            $earlier = new DateTime($conta['vencimento']);
            $later = new DateTime(date('Y-m-d'));

            $diff = $later->diff($earlier);
            // echo (($JUROS_MORA * $conta['valor_pag'])/30) * $dias;
            if($diff->invert == 1){
                $valor_juros = ($conta['valor_pag'] * $JUROS_AO_MES) + ((($JUROS_MORA * $conta['valor_pag'])/30) * $diff->days);
                
            }else{
                $valor_juros = 0;
            }
        }else{
            $valor_juros = 0;
        }
        // print_r($diff);

        if (isset($_POST['cadPagar'])) {
            $pagdao = new Pessoa_crediarioDAO();
            $valorexp = explode("$ ", $_POST['total']);
            $valor1 = str_replace( '.' ,'', $valorexp[1] );
            $total =  100 * str_replace (',', '.', $valor1);

            if($JUROS == 1){
                $valorexp = explode("$ ", $_POST['juros']);
                $valor1 = str_replace( '.' ,'', $valorexp[1] );
                $juros =  100 * str_replace (',', '.', $valor1);
            }else{
                $juros = $_POST['juros'];
            }

            // echo 1;
            // $gravou = $pagdao->alterar($conta['id_crediario'], $status, ($conta['valor_pago']+$total));
            // echo $conta['valor_pag']." ".$total."<br>";
            //VERIFICA SE O VALOR QUE FOI PAGO FOI MENOR OU IGUAL AO DA CONTA
            if(intval($conta['valor_pag']) == intval($total)){
                //PAGA A CONTA INTEGRALMENTE
                // echo 1;
                $pagou = $pagdao->alterar_pagamento($conta['id'],$total, $_POST['data_pag'], $_POST['pagamento'], 1, $_POST['observacao'], $juros);
            }
            //VERIFICA SE O VALOR QUE FOI PAGO FOI MENOR AO DA CONTA
            if(intval($conta['valor_pag']) > intval($total)){
                // echo 2;
                // //PAGA A CONTA PARCIALMENTE
                $pagou = $pagdao->alterar_pagamento2($conta['id'],$total-$juros, $conta['vencimento'], $_POST['data_pag'], $_POST['pagamento'], 1, $_POST['observacao'], $juros);

                if($conta['valor_pag']-$total > 0){
                    // echo $conta['id_crediario'].' '.$conta['data_pag'].' '.($conta['valor_pag']-$total);
                    //CADASTRA OUTRA CONTA COM O VALOR RESTANTE
                    $pagdao->cadastrar_pagamento($conta['id_crediario'],$conta['vencimento'], '', ($conta['valor_pag']+$juros)-$total, '0' );
                }
                
            }
            //VERIFICA SE O VALOR QUE FOI PAGO FOI MAIOR AO DA CONTA
            elseif(intval($conta['valor_pag']) < intval($total)){
                // echo 3;
                $parcelas = $pagdao->listar_parcelas($conta['id_crediario']);

                //ALTERA A PARCELA ATUAL PARA O VALOR QUE FOI PAGO REALMENTE
                $pagou = $pagdao->alterar_pagamento($conta['id'],$conta['valor_pag'], $_POST['data_pag'], $_POST['pagamento'], 1, '', 0);
                
                $resto = $total-$conta['valor_pag'];
                for ($i=0; $i < count($parcelas); $i++) { 
                
                    if($parcelas[$i]['flag'] == 0 && $conta['id'] != $parcelas[$i]['id']){
                        // echo $resto."<br>";
                        if($resto <= $parcelas[$i]['valor_pag']){
                             $pagou = $pagdao->alterar_pagamento($parcelas[$i]['id'],$resto, $_POST['data_pag'], $_POST['pagamento'], 1, '', 0);
                             if(($parcelas[$i]['valor_pag'] - $resto) > 0){
                                 $pagdao->cadastrar_pagamento($conta['id_crediario'],$parcelas[$i]['vencimento'], '', $parcelas[$i]['valor_pag'] - $resto, '0' );
                             }
                            break;
                        }else{
                             $pagou = $pagdao->alterar_pagamento($parcelas[$i]['id'],$parcelas[$i]['valor_pag'], $_POST['data_pag'], $_POST['pagamento'], 1, '', 0);

                            $resto = $resto - $parcelas[$i]['valor_pag'];
                        }

                    }
                }

            }

         
            
    

            if ($pagou) { ?>
            <div class="alert border-faded bg-transparent text-secondary fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon">
                        <span class="icon-stack icon-stack-md">
                            <i class="base-7 icon-stack-3x color-success-600"></i>
                            <i class="fa fa-check icon-stack-1x text-white"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <span class="h5 color-success-600">Conta paga!</span>
                        <br>

                    </div>

                </div>
            </div>
            <meta http-equiv="refresh" content="0;URL=?dtlPrestacao=<?php echo $conta['id']; ?>">
        <?php
                } else { ?>
            <div class="alert border-danger bg-transparent text-secondary fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon">
                        <span class="icon-stack icon-stack-md">
                            <i class="base-7 icon-stack-3x color-danger-900"></i>
                            <i class="fa fa-times icon-stack-1x text-white"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <span class="h5 color-danger-900">Parece que alguma coisa deu errado... </span>
                    </div>
                    <a href="http://geeksistemas.com.br/#contact" target="_blank" class="btn btn-outline-danger btn-sm btn-w-m">Reportar</a>
                </div>
            </div>
<?php }
    }
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Pagar parcela</h4>
        <a href="?dtlVenda=<?php echo $conta['id_venda']; ?>" class="btn btn-sm btn-info me-1">Ver venda</a>
        <a href="?dtlPessoa=<?php echo $conta['id_pessoa']; ?>" class="btn btn-sm btn-info">Ver pessoa</a>
    </div>
    <div class="panel-body">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                <strong>Nome: </strong> <br><?php echo $venda['nome']; ?>
                            </h5>
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title"> <strong>Data venda:</strong> <br><?php echo $venda['dataf']; ?></h5>
                            <hr>
                            <h5 class="card-title"> 
                                <strong>Data vencimento:</strong> 
                                <br><?php echo $conta['vencimentof']; ?>
                                <?php if($diff->days > 0 && $diff->invert == 1 ){
                                    echo "<br> <span class='text-danger'>[".$diff->days." dia(s) de atraso]</span>";
                                } ?>
                            </h5>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">
                                <strong>Pago:</strong><br>
                                <?php if ($conta['flag'] != 1) {
                                    echo "<em class='text-danger'>Não</em>";
                                } else{
                                    echo "<em class='text-success'>Pago</em>";
                                } 
                                ?>
                            </h5>
                            <hr>
                        </div>
                        <div class="col-md-3 text-end">
                            <h5 class="card-title">
                                <strong>Valor: </strong><br>
                                <?php echo "R$ " . number_format($conta['valor_pag'] / 100, 2, ',', '.'); ?>
                            </h5>
                            <hr>
                            
                        </div>
                        <div class="col-sm-12 table-responsive mt-4">
                            <table class="table table-sm table-striped m-0 table-bordered">
                                <thead>
                                    <tr class="text-center fs-lg">
                                        <th colspan="4">DETALHES DA VENDA</th>
                                    </tr>
                                    <tr  class="bg-primary-500 color-black">
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Valor unit.</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($produtos); $i++) {  ?>
                                        <tr>
                                            <th scope="row"><?php echo $produtos[$i]['nome']; ?></th>
                                            <td><?php echo $produtos[$i]['quantidade']; ?></td>
                                            <td>R$ <?php echo number_format($produtos[$i]['valor_unit']/100, 2, ",", "."); ?></td>
                                            <td>R$ <?php echo number_format($produtos[$i]['valor_total']/100, 2, ",", "."); ?></td>
                                
                                        </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>         
                        </div>
                         <!-- BEGIN table-responsive -->
                        <div class="table-responsive mt-50px pt-50px">
                            <table class="table table-invoice">
                                <?php if(isset($parcelas) && count($parcelas) > 0){ ?>

                                <thead class="pt-35px">
                                    <tr>
                                        <th class="text-center fs-18px" colspan="4">Parcelas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Valor parcela</th>
                                        <th class="text-center" width="10%">Vencimento</th>
                                        <th class="text-end" width="20%">Forma pag.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $emaberto = 0; $pago = 0;
                                    for ($i=0; $i < count($parcelas); $i++) {  
                                        if($parcelas[$i]['flag'] == '1'){
                                            $pago += $parcelas[$i]['valor_pag'];
                                        }else{
                                            $emaberto += $parcelas[$i]['valor_pag'];
                                        }
                                        ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i+1; ?></td>
                                        <td class="text-center">R$ <?php echo number_format($parcelas[$i]['valor_pag']/100, 2, ",", '.'); ?></td>
                                        <td>
                                            <span class="text-inverse"><?php echo $parcelas[$i]['vencimentof']; ?></span>
                                        </td>
                                        <td class="text-center"><?php echo $parcelas[$i]['flag'] == 1 ? $parcelas[$i]['pagamento'] : ""; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-end">TOTAL PAGO:</th>
                                        <th>R$ <?php echo number_format($pago/100, 2, ",", '.'); ?></th>
                                        <th class="text-end">TOTAL RESTANTE:</th>
                                        <th>R$ <?php echo number_format($emaberto/100, 2, ",", '.'); ?></th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                        <!-- END table-responsive -->
                    </div>
                    <?php if ($conta['flag'] != 1) { ?>
                    <hr>
                        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                            <div class="row  justify-content-start mb-1">
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Data do pagamento</label>
                                    <input type="date" name="data_pag" id="data_pag" class="form-control border-primary" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Valor do pagamento</label>
                                    <input type="text" name="total" id="total" class="form-control border-primary" value="<?php echo str_replace(".", ",", ($conta['valor_pag'])/100); ?>" data-inputmask="'alias':'currency'">
                                </div>
                                <?php if($JUROS == 1){ ?>
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Juros</label>
                                    <input type="text" name="juros" id="juros" class="form-control border-primary" value="<?php echo str_replace(".", ",", $valor_juros/100); ?>" data-inputmask="'alias':'currency'">
                                </div>
                                <?php }else{ ?>
                                    <input type="hidden" name="juros" value="0">
                                <?php } ?>
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Forma de pagamento</label>
                                    <select required class="form-control select2" name="pagamento" id="pagamento">
                                        <?php for ($i = 0; $i < count($listaPagamento); $i++) { ?>
                                            <option value="<?php echo $listaPagamento[$i]['id']; ?>" <?php echo $listaPagamento[$i]['id'] == $conta['conta_pag'] ? "selected" : ""; ?>>
                                                <?php echo $listaPagamento[$i]['nome']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 text-left">
                                    <label class="form-label">Observação</label>
                                    <textarea name="observacao" id="observacao" rows="3" class="form-control border-primary"></textarea>
                                </div>
                                    <input type="hidden" name="valor_conta" id="valor_conta" value="<?php echo $conta['valor_pag']; ?>">
                                    <input type="hidden" name="valor" id="valor" value="<?php echo $conta['valor']; ?>">
                                </div>
                                <div class="col-sm-12 text-end my-2">
                                    <h4>Total: R$ <?php echo number_format(($conta['valor_pag']+$valor_juros)/100, 2, ",", "."); ?></h4>
                                </div>
                                <div class="col-sm-12 px-0 text-end">
                                    <button type="submit" class="btn float-end btn-primary" name="cadPagar" id="cadPagar">
                                        <i class="fa fa-save"></i>
                                        Salvar
                                    </button>
                                </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const JUROS_MES = <?php echo safe_json_encode($JUROS_AO_MES); ?>;
    const JUROS_MORA = <?php echo safe_json_encode($JUROS_MORA); ?>;
    const CONTA = <?php echo safe_json_encode($conta); ?>;
$(document).ready(function() {
    $(":input").inputmask();

    $('.select2').select2({
        containerCssClass: "border-primary"
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $(document).on('change','#data_pag', () => {
        const vencimento = moment(CONTA.vencimento);
        const data = moment($("#data_pag").val());
        const diff = data.diff(vencimento, 'days');
        const valor = $('#valor_conta').val();
        if(diff > 0){

            $("#juros").val(
                (
                    ((+valor * +JUROS_MES) + 
                    
                    ( ( (+JUROS_MORA * +valor) /30 ) * +diff ))
                    
                    /100
                ).toFixed(2).replace(".", ",")
            );
        }
    });



});
</script>