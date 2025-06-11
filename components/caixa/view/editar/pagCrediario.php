<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="../assets_coloradmin/css/radio.css">
<?php
include_once("components/conta/action/listar_pagamento.php");
        $id_pessoa = $_GET['pagCrediario'];
        $id_venda = $_GET['id_venda'];

        $pagdao = new Pessoa_crediarioDAO();
        $conta = $pagdao->getPorId($id_pessoa, $id_venda);
        $pagamentos = $pagdao->getPagamentos($conta['id']);

        $pagdao = new VendaDAO();
        $venda = $pagdao->getPorId($id_venda);

        $pagdao = new Venda_produtoDAO();
        $produtos = $pagdao->listar($id_venda);
    // print_r($horarios);

        if (isset($_POST['cadPagar'])) {
            $pagdao = new Pessoa_crediarioDAO();

            $valorexp = explode("$ ", $_POST['total']);
            $valor1 = str_replace( '.' ,'', $valorexp[1] );
            $total =  100 * str_replace (',', '.', $valor1);

            if(($conta['valor_pag']+$total) == $conta['crediario']){
                $status = 2;
            }elseif(($conta['valor_pag']+$total) < $conta['crediario']){
                $status = 1;
            }
            $gravou = $pagdao->alterar($conta['id'], $status, ($conta['valor_pag']+$total));

            $pagou = $pagdao->cadastrar_pagamento($conta['id'], $_POST['data_pag'], $_POST['pagamento'], $total);

    

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
            <meta http-equiv="refresh" content="0;">
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
        <a href="?dtlVenda=<?php echo $id_venda; ?>" class="btn btn-sm btn-info me-1">Ver venda</a>
        <a href="?dtlPessoa=<?php echo $id_pessoa; ?>" class="btn btn-sm btn-info">Ver pessoa</a>
    </div>
    <div class="panel-body">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                <strong>Nome: </strong> <?php echo $conta['nome']; ?>
                            </h5>
                            <hr>
                            
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">Data: <?php echo $conta['dataf']; ?></h5>
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <h5 class="card-title">
                                <strong>Pago:</strong>
                                <?php if ($conta['pag_crediario'] == 0) {
                                    echo "<em class='text-danger'>Não</em>";
                                } elseif ($conta['pag_crediario'] == 1) {
                                    echo "<em class='text-info'>Pago parcialmente</em>";
                                } elseif ($conta['pag_crediario'] == 2) {
                                    echo "<em class='text-success'>Pago</em>";
                                } 
                                ?>
                            </h5>
                            <hr>
                        </div>
                        <div class="col-md-3 text-end">
                            <h5 class="card-title">
                                <strong>Valor total: </strong>
                                <?php echo "R$ " . number_format($conta['crediario'] / 100, 2, ',', '.'); ?>
                            </h5>
                            <h5 class="card-title">
                                <strong>Valor pago: </strong>
                                <?php echo "R$ " . number_format($conta['valor_pag'] / 100, 2, ',', '.'); ?>
                            </h5>
                            <h5 class="card-title">
                                <strong>Valor restante: </strong>
                                <?php echo "R$ " . number_format(($conta['crediario']-$conta['valor_pag']) / 100, 2, ',', '.'); ?>
                            </h5>
                            <hr>
                            
                        </div>
                        <?php if (count($pagamentos) >= 1) { ?>
                        <div class="col-sm-12 table-responsive mt-4">
                            <table class="table table-sm table-striped m-0 table-bordered">
                                <thead>
                                    <tr class="text-center fs-lg">
                                        <th colspan="3">PAGAMENTO(S)</th>
                                    </tr>
                                    <tr  class="bg-success-500 color-black">
                                        <th>Data.</th>
                                        <th>Forma</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($pagamentos); $i++) {  ?>
                                        <tr>
                                            <th scope="row"><?php echo $pagamentos[$i]['data_pagf']; ?></th>
                                            <td><?php echo $pagamentos[$i]['nome']; ?></td>
                                            <td><?php echo number_format($pagamentos[$i]['valor_pag']/100, 2, ",", "."); ?></td>
                                
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>         
                        </div>
                        <?php } ?>
                        <div class="col-sm-12 table-responsive mt-4">
                            <table class="table table-sm table-striped m-0 table-bordered">
                                <thead>
                                    <tr class="text-center fs-lg">
                                        <th colspan="3">DETALHES DA VENDA</th>
                                    </tr>
                                    <tr  class="bg-primary-500 color-black">
                                        <th>Cód.</th>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($produtos); $i++) {  ?>
                                        <tr>
                                            <th scope="row"><?php echo $produtos[$i]['id']; ?></th>
                                            <td><?php echo $produtos[$i]['nome']; ?></td>
                                            <td><?php echo $produtos[$i]['kg'] == 1 ? $produtos[$i]['quantidade']." gr" : $produtos[$i]['quantidade']." un"; ?></td>
                                
                                        </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>         
                        </div>
                    </div>
                    <?php if ($conta['pag_crediario'] <= 1) { ?>
                    <hr>
                        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                            <div class="row  justify-content-around mb-1">
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Data do pagamento</label>
                                    <input type="date" name="data_pag" id="data_pag" class="form-control border-primary" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-sm-3 text-left">
                                    <label class="form-label">Valor do pagamento</label>
                                    <input type="text" name="total" id="total" class="form-control border-primary" value="<?php echo str_replace(".", ",", ($conta['crediario']-$conta['valor_pag'])/100); ?>" data-inputmask="'alias':'currency'">
                                </div>
                                <div class="col-sm-6 text-left">
                                    <label class="form-label">Forma de pagamento</label>
                                    <select required class="form-control select2" name="pagamento" id="pagamento">
                                        <?php for ($i = 0; $i < count($listaPagamento); $i++) { ?>
                                            <option value="<?php echo $listaPagamento[$i]['id']; ?>" <?php echo $listaPagamento[$i]['id'] == $conta['conta_pag'] ? "selected" : ""; ?>>
                                                <?php echo $listaPagamento[$i]['nome']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                    <input type="hidden" name="valor" id="valor" value="<?php echo $conta['valorprestacao']; ?>">
                                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
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
$(document).ready(function() {
    $(":input").inputmask();

    $('.select2').select2({
        containerCssClass: "border-primary"
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

});
</script>