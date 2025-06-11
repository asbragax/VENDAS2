<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="../assets_coloradmin/css/radio.css">
<?php 
include_once "components/conta/action/listar_pagamento.php";
include_once "components/produto/action/listar_produto.php";
include_once "components/pessoa/action/listar_pessoa.php"; 
include_once("components/venda/action/editar_venda.php");

$dao = new UserDAO(0);
$vendedores = $dao->listar_under_3();

$id = $_GET['edtVenda'];
$dao = new VendaDAO();
$venda = $dao->getPorIdAssoc($id);


$dao = new Pessoa_crediarioDAO();
$crediario = $dao->getPorId($venda['cliente'], $venda['id']);
$parcelas = $dao->listar_parcelas($crediario['id']);

?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Produtos</h4>
        <button name="excluir_venda" value="excVenda=<?php echo $id; ?>" class="btn btn-danger confirmDeletar me-1">
            Excluir venda
        </button>
        <a href="?consVenda" class="btn btn-primary btn-sm">Ver vendas</a>
    </div>
    <div class="panel-body">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="nav-item w-50 text-center border-bottom border-end border-dark"><a href="#venda" data-bs-toggle="tab" class="nav-link active text-uppercase h5">Venda</a></li>
                <li class="nav-item w-50 text-center border-bottom border-dark"><a href="#extra" data-bs-toggle="tab" class="nav-link text-uppercase h5">Pagamento</a></li>
            </ul>
            <div class="tab-content bg-white p-3 rounded-bottom">
                <div class="tab-pane fade active show" id="venda">
                    <div class="table-responsive overflow-hidden col-sm-12">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Referência</label>
                                <input type="text" name="cod" id="cod"  class="form-control border-primary" autofocus />
                            </div>
                            <div class="col-md-8 mb-2">
                                <label class="form-label">Produto</label>
                                <select data-placeholder="Produto" class="form-control select2" name="produto" id="produto">
                                    <option value=""></option>
                                    <?php for ($i = 0; $i < count($listaProdutos); $i++) { ?>
                                        <option value="<?php echo $listaProdutos[$i]["id"]; ?>">
                                        <?php echo $listaProdutos[$i]["referencia"]." - ".$listaProdutos[$i]["nome"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="note note-warning note-with-end-icon py-1 mt-1" id="sociedade_alerta">
                                <div class="note-content text-end">
                                    Produto de socidade, favor marcar a opção sociedade na outra aba caso inclua esse produto
                                </div>
                                <div class="note-icon"><i class="fa fa-exclamation-circle"></i></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Tamanho</label>
                                <ul class="ks-cboxtags" id="div_tamanho">
                                </ul>
                            </div>
                            <input type="hidden" id="valor_venda">
                            <!-- <input type="hidden" id="valor_atacado"> -->
                            <input type="hidden" id="valor_compra">

                            <div class="col-sm-12 mb-3">
                                <label class="form-label"> </label>
                                <button type="submit" name="incluir" id="incluir" class="btn float-end btn-warning btn-md"><i class="fa fa-plus me-3"></i>Incluir</button>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="col-md-12 mb-2">
                                    <input type="text" name="input-search" id="input-search" alt="table-vendas" class="form-control border-primary" placeholder="Pesquisar...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table overflow-hidden" id="table-vendas">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><b>#</b></th>
                                            <th><b>Produto</b></th>
                                            <th><b>Quantidade</b></th>
                                            <th class="text-center"><b>Preço Unitário</b></th>
                                            <th class="text-center"><b>Preço total</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="carrinho"></tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Qtde produtos: <span id="lbl-qtdeprod">0</span></td>
                                            <td>Qtde peças: <span id="lbl-qtdeitens">0</span></td>
                                            <td></td>
                                            <td class="text-center">
                                                <strong id="total-table">Total:</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="extra">
                <div class="table-responsive overflow-hidden col-sm-12">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Cliente</label>
                                <select class="select2 form-control" required name="cliente" id="cliente">
                                    <option value=""></option>
                                    <?php for ($i = 0; $i < count($listaPessoas); $i++) { ?>
                                        <option value="<?php echo $listaPessoas[$i]['id']; ?>" <?php echo $listaPessoas[$i]['id'] == $venda['cliente'] ? "selected" : ""; ?>>
                                            <?php echo $listaPessoas[$i]['nome']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Vendedor</label>
                                <select class="select2 form-control" required name="vendedor" id="vendedor">
                                    <option value=""></option>
                                    <?php for ($i = 0; $i < count($vendedores); $i++) { ?>
                                        <option value="<?php echo $vendedores[$i]['id']; ?>" <?php echo $vendedores[$i]['id'] == $venda['vendedor'] ? "selected" : ""; ?>>
                                            <?php echo $vendedores[$i]['nome']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Data</label>
                                <input class="form-control border-primary" type="date" name="data" id="data" value="<?php echo $venda['data']; ?>" />
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Desconto</label>
                                <input class="form-control border-primary" type="text" value="<?php echo number_format($venda['desconto']/100, 2, ",", "."); ?>" name="desconto" id="desconto" data-inputmask="'alias':'currency'" />
                            </div>
                            <div class="col-sm-6 mb-2 pt-4">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="prevenda" name="prevenda" value="1" <?php echo $venda['prevenda'] == 1 ? "checked" : ""; ?> />
                                    <label class="form-check-label" for="prevenda">Consignado</label>
                                </div>
                                <?php if($COMISSAO == 1){ ?>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="comissao" name="comissao" value="1" <?php echo $venda['comissao'] == 1 ? "checked" : ""; ?> />
                                    <label class="form-check-label" for="comissao">Comissão</label>
                                </div>
                                <?php }else{ ?>
                                    <input type="hidden" name="comissao" value="0">
                                <?php } ?>
                                <?php if($SOCIEDADE == 1){ ?>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sociedade" name="sociedade" value="1" <?php echo $venda['sociedade'] == 1 ? "checked" : ""; ?> />
                                    <label class="form-check-label" for="sociedade">Sociedade</label>
                                </div>
                                <?php }else{ ?>
                                    <input type="hidden" name="sociedade" value="0">
                                <?php } ?>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="entrega" name="entrega" value="1" <?php echo $venda['entrega'] == 1 ? "checked" : ""; ?> />
                                    <label class="form-check-label" for="entrega">Entrega</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Obs/Endereço</label>
                                <textarea class="form-control border-primary" name="endereco" id="endereco"><?php echo $venda['endereco']; ?></textarea>
                            </div>
                            <div class="col-sm-12 mt-3 text-end">
                                <div class="row  justify-content-center">
                                    <ul class="ks-cboxtags" id="divpag">   
                                        <?php for ($i=0; $i < count($listaPagamento); $i++) { ?> 
                                            <li class="credito">
                                                <input class="mpag" type="radio" 
                                                id="forma_<?php echo $listaPagamento[$i]['id']; ?>" 
                                                value="<?php echo $listaPagamento[$i]['id']; ?>" 
                                                name="radiopagamento"
                                                <?php echo $listaPagamento[$i]['id'] == $venda['forma_pag'] ? "checked" : ""; ?>
                                                >
                                                <label for="forma_<?php echo $listaPagamento[$i]['id']; ?>"><?php echo $listaPagamento[$i]['nome']; ?></label>
                                            </li>  
                                        <?php } ?>  
                                        <li class="dinheiro">
                                            <input class="mpag" type="radio" id="96" value="96" name="radiopagamento" <?php echo $venda['forma_pag'] == 96 ? 'checked' : ""; ?>>
                                            <label for="96">Parcelado</label>
                                        </li>                   
                                        <li class="debito">
                                            <input class="mpag" type="radio" id="diversos" value="diversos" name="radiopagamento" <?php echo $venda['forma_pag'] == 99 ? 'checked' : ""; ?>>
                                            <label for="diversos">Diversos</label>
                                        </li>
                                    </ul>
                                    <div class="col-sm-12 row px-0" id="divambos">
                                        <?php for ($i=0; $i < count($listaPagamento); $i++) { ?>
                                            <div class="col-sm-4">
                                                <label class="form-label"><?php echo $listaPagamento[$i]['nome']; ?></label>
                                                <input type="text" id="<?php echo $listaPagamento[$i]['id']; ?>_txt" class="valortxt form-control border-primary" data-inputmask="'alias':'currency'">
                                            </div>
                                        <?php } ?>
                                        <div class="col-sm-4">
                                            <label class="form-label">Parcelado</label>
                                            <input type="text" id="96_txt" class="valortxt form-control border-primary" data-inputmask="'alias':'currency'">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 row mt-2 p-0" id="divparcelado">
                                        <div class="form-group col-sm-4 mt-0 pt-0">
                                            <a class="btn btn-success w-100" href="javascript:void(0)" id="atualizar_parcelas">
                                                <i class="fa fa-redo-alt"></i>
                                                Atualizar
                                            </a>
                                        </div>
                                        <div class="form-group col-sm-8 mt-0 pt-0">
                                            <a class="btn btn-info w-100" href="javascript:void(0)" id="addInput">
                                                <i class="fa fa-plus-circle"></i>
                                                Adicionar parcela
                                            </a>
                                        </div>
                                        <div class="form-group col-sm-12">
                                        <?php if(isset($parcelas) && count($parcelas) > 0){ ?>
                                            <label class="form-label" id="label-parecelas"><?php echo count($parcelas); ?> Parcela(s)</label>
                                            <?php for ($i=0; $i < count($parcelas); $i++) { 
                                                if($parcelas[$i]['flag'] == 1){ ?>
                                            <div id="dynamicDiv">
                                                <div class="p-0 m-0 row divparcela dp<?php echo $i; ?>">
                                                    <div class="col-md-1  text-center p-0">
                                                        <span class="pt-3 h6"><?php echo $i+1; ?></span>
                                                    </div>
                                                    <div class="col-md-4 p-0">
                                                        <input type="text" name="parcela[<?php echo $i; ?>]"
                                                        data-inputmask="'alias': 'currency'" class="form-control border-primary col-sm-5 parcela"
                                                        style="display:inline; margin-bottom:2px; margin-right: 4px" 
                                                        value="<?php echo str_replace(".", ",",$parcelas[$i]['valor_pag']/100); ?>" 
                                                        readonly="readonly">
                                                    </div>
                                                    <div class="col-md-4 p-0">
                                                        <input class="form-control border-primary col-sm-5 vencimento" type="date" 
                                                        name="vencimento[<?php echo $i; ?>]" id="vencimento<?php echo $i; ?>" 
                                                        value="<?php echo $parcelas[$i]['data_pag']; ?>"
                                                        style="display:inline;" 
                                                        readonly="readonly">
                                                    </div>
                                                    <div class="col-md-2 text-center p-0">
                                                        <div class="form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="flag" name="flag[<?php echo $i; ?>]" value="1" checked />
                                                            <label class="form-check-label" for="flag">Pago</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="forma_pag[<?php echo $i; ?>]"
                                                            value="<?php echo $parcelas[$i]['forma_pag'] ?>">
                                                    <input type="hidden" name="data_pag[<?php echo $i; ?>]"
                                                        value="<?php echo $parcelas[$i]['data_pag'] ?>">
                                                   
                                                    <!-- <input type="hidden" name="flag[<?php //echo $i; ?>]"
                                                        value="<?php //echo $parcelas[$i]['flag'] ?>"> -->
                                                    <input type="hidden" name="id_crediario[<?php echo $i; ?>]"
                                                        value="<?php echo $parcelas[$i]['id_crediario'] ?>">
                                                    <div class="col-md-1 p-0">
                                                        <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0)"
                                                        id="remInput" style="float:right; pointer-events: none;" disabled="disabled">
                                                            <i class="fa fa-minus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php }else{ ?>
                                                <div id="dynamicDiv">
                                                <div class="p-0 m-0 row divparcela dp<?php echo $i; ?>">
                                                    <div class="col-md-1  text-center p-0">
                                                        <span class="pt-3 h6"><?php echo $i+1; ?></span>
                                                    </div>
                                                    <div class="col-md-4 p-0">
                                                        <input type="text" name="parcela[<?php echo $i; ?>]"
                                                        data-inputmask="'alias': 'currency'" class="form-control border-primary col-sm-5 parcela"
                                                        style="display:inline; margin-bottom:2px; margin-right: 4px" 
                                                        value="<?php echo str_replace(".", ",",$parcelas[$i]['valor_pag']/100); ?>">
                                                    </div>
                                                    <div class="col-md-4 p-0">
                                                        <input class="form-control border-primary col-sm-5 vencimento" type="date" 
                                                        name="vencimento[<?php echo $i; ?>]" id="vencimento<?php echo $i; ?>" 
                                                        value="<?php echo $parcelas[$i]['vencimento']; ?>"
                                                        style="display:inline;">
                                                    </div>
                                                    <div class="col-md-2 p-0">
                                                    </div>
                                                    <input type="hidden" name="forma_pag[<?php echo $i; ?>]"
                                                            value="0">
                                                    <input type="hidden" name="data_pag[<?php echo $i; ?>]"
                                                        value="<?php echo $parcelas[$i]['data_pag']; ?>">
                                                    <input type="hidden" name="flag[<?php echo $i; ?>]"
                                                        value="0">
                                                    <input type="hidden" name="id_crediario[<?php echo $i; ?>]"
                                                        value="<?php echo $parcelas[$i]['id_crediario'] ?>">
                                                    <div class="col-md-1 p-0">
                                                        <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0)"
                                                        id="remInput" style="float:right">
                                                            <i class="fa fa-minus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php } }
                                                }else{ ?>
                                                <label class="form-label" id="label-parecelas">1 Parcela</label>
                                                <div id="dynamicDiv">
                                                    <div class="p-0 m-0 row divparcela dp0">
                                                        <div class="col-md-1  text-center p-0">
                                                            <span class="pt-3 h6">1</span>
                                                        </div>
                                                        <div class="col-md-4 p-0">
                                                            <input type="text" name="parcela[0]"
                                                            data-inputmask="'alias': 'currency'" class="form-control border-primary col-sm-5 parcela"
                                                            style="display:inline; margin-bottom:2px; margin-right: 4px" />
                                                        </div>
                                                        <div class="col-md-4 p-0">
                                                            <input class="form-control border-primary col-sm-5 vencimento" type="date" name="vencimento[0]" id="vencimento0" value="<?php echo date('Y-m-d', strtotime(' + 1 month')); ?>"
                                                            style="display:inline;">
                                                        </div>
                                                        <div class="col-md-2 p-0">
                                                        </div>
                                                        <div class="col-md-1 p-0">
                                                            <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0)"
                                                            id="remInput" style="float:right">
                                                                <i class="fa fa-minus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-end mb-1 px-0">
                                        <h2 class="text-dark mx-5 float-end" id="label-total-select2">TOTAL:</h2>
                                    </div>
                                    <div class="col-md-12 text-end mt-2">
                                    <?php if($gravou){ ?>
                                        <button class="confirmImprimir btn btn-default me-1" name="ticket_venda" value="id=<?php echo $venda['id']; ?>">
                                            <i class="fa fa-print me-1"></i>
                                            Imprimir
                                        </button>
                                    <?php } ?>
                                            <button type="submit" name="salvar" id="salvar_pedido_fechado" class="float-end btn btn-md btn-primary"><i class="fa fa-save me-1"></i>
                                                Salvar
                                            </button>
                                    </div>
                                    <input type="hidden" name="idvenda" id="idvenda" value="<?php echo $id; ?>">
                                    <input type="hidden" name="edt_gk_carrinho" id="edt_gk_carrinho">
                                    <input type="hidden" name="total" id="total">
                                    <input type="hidden" name="pagamento" id="pagamento" value="<?php echo $venda['forma_pag'] < 99 ? $venda['forma_pag'] : 'diversos'; ?>">
                                    <input type="hidden" name="valor_98" id="valor_98">
                                    <input type="hidden" name="valor_96" id="valor_96">
                                    <?php for ($i=0; $i < count($listaPagamento); $i++) { ?>
                                        <input type="hidden" name="valor_<?php echo $listaPagamento[$i]['id']; ?>" id="valor_<?php echo $listaPagamento[$i]['id']; ?>">
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
var TAM_COD = <?php echo safe_json_encode($TAM_COD); ?>;
var pessoas = <?php echo safe_json_encode($listaPessoas); ?>;
var venda = <?php echo safe_json_encode($venda); ?>;
var produtos = <?php echo safe_json_encode($listaProdutos); ?>;
    $(document).ready(function() {
        $('#divambos').hide();
        // $('#salvar_pedido_fechado').prop('disabled', true);
        $(":input").inputmask();
        $('#divparcelado').hide();
        $(".select2").select2({ 
            placeholder: "Selecione",
            containerCssClass: "border-primary"
        });

       

        
        $("#incluir").click(function (e) { 
            e.preventDefault();
            let carrinho = localStorage.getItem('edt_gk_carrinho');
            // console.log(carrinho);
            if(!carrinho || carrinho == '[null]'){
                carrinho = [];
            }else{
                carrinho = JSON.parse(carrinho);
            }
            if($("#produto").val() && $("#produto option:selected").text() && $(".tamanho:checked").val() && $("#valor_compra").val() && $("#valor_venda").val()){
                carrinho.push(
                    {
                        id: $("#produto").val(),
                        nome: $("#produto option:selected").text().trim(),
                        ref: $("#produto").val(),
                        tamanho: $(".tamanho:checked").val(),
                        quantidade: 1,
                        valor_compra: $("#valor_compra").val(),
                        valor_venda: $("#valor_venda").val(),
                        estoque: $(".tamanho:checked").attr('data-quantidade'),
                        // valor_atacado: $("#valor_atacado").val()
                    }
                );
                localStorage.setItem('edt_gk_carrinho', JSON.stringify(carrinho));
                cria_campos();
                $("#produto").val('').change();
                $("#cod").val('');
                $("#div_tamanho").empty();
                $("#cod").focus();
            }else{
                alert("Selecione um produto e um tamanho por favor!!!");
            }
            
        });

        function cria_campos() { 
            let carrinho = localStorage.getItem('edt_gk_carrinho');
                carrinho = JSON.parse(carrinho);
            let div = $("#carrinho");
            let html = '';
            let total = 0;
            // console.log(carrinho);
            let total_itens = 0;
            for (let i = 0; i < carrinho.length; i++) {
              html += '<tr class="py-2">';  
              html += '<td><button type="button" class="btn btn-sm btn-danger btn-icon btn-excluir" value="'+i+'" name="excluir">';
              html += '<span class="fa fa-times"></span></button></td>';  
              html += '<td>'+carrinho[i].nome+' #'+carrinho[i].tamanho+'</td>';  
              html += '<td><button class="btn btn-sm btn-icon btn-danger me-2 dec_qtde" id="dec_'+i+'"><i class="fa fa-minus"></i></button>';  
              html += '<span id="val_'+i+'">'+carrinho[i].quantidade+'</span>';  
              html += '<button class="btn btn-sm btn-icon btn-success ms-2 inc_qtde" id="inc_'+i+'"><i class="fa fa-plus"></i></button></td>';  
              html += '<td class="text-center">'+(carrinho[i].valor_venda/100).toFixed(2).replace(".", ",")+'</td>';  
              html += '<td class="text-center">'+((carrinho[i].valor_venda*carrinho[i].quantidade)/100).toFixed(2).replace(".", ",")+'</td>';  
              html += '</tr>';  

              total_itens = total_itens + +carrinho[i].quantidade;
              total = total + (+carrinho[i].valor_venda * +carrinho[i].quantidade);
                
            }
            $("#lbl-qtdeprod").text(carrinho.length);
            $("#lbl-qtdeitens").text(total_itens);
            $("#label-total-select2").text('TOTAL: R$'+ (total/100).toFixed(2).replace(".", ","));
            $("#total-table").text('TOTAL: '+ (total/100).toFixed(2).replace(".", ","));
            $("#total").val(total);
            $("#desconto").keyup();
            div.empty();
            div.append(html);
            $("#edt_gk_carrinho").val(JSON.stringify(carrinho));

        }

        $(document).on("click", ".btn-excluir", function(e) {
            e.preventDefault();
            var index = $(this).val();
            let carrinho = localStorage.getItem('edt_gk_carrinho');
            carrinho = JSON.parse(carrinho);

            const item = carrinho.filter((item, i) => {
                // debugger
                if(i == index){
                    return item;
                }
            });

            swal({
                title: "EXCLUIR O PRODUTO?",
                text: "Nome: "+ item[0].nome+ " #"+item[0].tamanho+"\n Quantidade: "+item[0].quantidade,
                icon: 'warning',
                buttons: {
                cancel: {
                    text: 'Não',
                    value: 'cancel',
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Sim',
                    value: 'proceed',
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                }
                }
            })
            .then(function(result) {
                switch (result) {
                case "cancel":
                swal({
                    icon: 'info',
                    text: "Ufa! Produto não excluído."
                });
                break;

                case 'proceed':
                    carrinho = carrinho.filter((item, i) => {
                        // debugger
                        if(i != index){
                            return item;
                        }
                    });
                    // console.log(carrinho2);
                    localStorage.setItem('edt_gk_carrinho', JSON.stringify(carrinho));
                    cria_campos();
                    $("#input-search").val('');
                    $("#input-search").focus();
                break;

                default:
                swal({
                    icon: 'info',
                    text: "Ufa! Produto não excluído."
                });
                }
            })
            .catch(err => {
                if(err){
                    swal({
                        icon: 'danger',
                        text: "Um erro ocorreu, impossível excluir o produto."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
            
            
            
         
        });

        $(document).on("click", ".inc_qtde", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#val_" + id[1]).text();
            let carrinho = JSON.parse(localStorage.getItem('edt_gk_carrinho'));
            // console.log(carrinho[id[1]].estoque+ ' '+(+qtde+1));
            if(+carrinho[id[1]].estoque >= (+qtde+1)){

                $("#val_" + id[1]).text(+qtde + 1).change();
                carrinho[id[1]].quantidade = $("#val_" + id[1]).text();
                localStorage.setItem('edt_gk_carrinho', JSON.stringify(carrinho));
                cria_campos();

            }else{
                swal({
                    title: "Produto sem estoque suficiente",
                    icon: 'info',
                    buttons: {
                        confirm: {
                            text: 'Ok',
                            value: 'proceed',
                            visible: true,
                            className: 'btn btn-primary',
                            closeModal: true
                        }
                    }
                })
            }

        });

        $(document).on("click", ".dec_qtde", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#val_" + id[1]).text();
            if( $("#val_" + id[1]).text() > 1){
                $("#val_" + id[1]).text(+qtde - 1).change();
            }

            let carrinho = JSON.parse(localStorage.getItem('edt_gk_carrinho'));
            carrinho[id[1]].quantidade = $("#val_" + id[1]).text();
            localStorage.setItem('edt_gk_carrinho', JSON.stringify(carrinho));
            cria_campos();

        });
   

        if(venda.forma_pag == 99){
            $.post("components/venda/action/busca_pagamento.php", "id="+$("#idvenda").val(),
            function(data) {
                if(data != false){
                    const pagamentos = JSON.parse(data);
                    for (let i = 0; i < pagamentos.length; i++) {
                        $(`#${pagamentos[i].id_pagamento}_txt`).val((pagamentos[i].valor/100).toFixed(2).replace(".", ","));
                        $(`#valor_${pagamentos[i].id_pagamento}`).val(pagamentos[i].valor);

                        if(pagamentos[i].id_pagamento == 96){
                            $("#divparcelado").show();
                        }
                    }
                    $("#diversos").attr('checked', true).change();
                    $('#salvar_pedido_fechado').prop('disabled', false);
                }
            }, "html");
        }


        $(document).on("keyup", "#cod", function() {
            var valor = $("#cod").val();
            if(valor.length >= TAM_COD){
                $("#produto").val(valor).change();

                for (let i = 0; i < produtos.length; i++) {
                    if(produtos[i].id == valor){
                        // $("#ref").val(produtos[i].referencia);
                        $("#valor_venda").val(produtos[i].valor_venda);
                        $("#valor_compra").val(produtos[i].valor_compra);
                        // $("#valor_atacado").val(produtos[i].valor_atacado);
                    }
                    
                }
            }
        });

        $("#sociedade_alerta").hide();

        $("#produto").change(function (e) { 
            e.preventDefault();
            const prod = $(this).val();
            if(prod && prod.length >= TAM_COD){

           
                $.post("components/produto/action/buscar_grade.php", "id="+prod,
                    function(data) {
                        // debugger
                        if (data!= null && data != false) {
                        data = JSON.parse(data);
                        
                        $("#div_tamanho").empty();
                        let html = '';
                        for (let i = 0; i < data.length; i++) {
                                html += '<li class="credito">';
                                if(data[i].quantidade == 0){
                                    html += '<input class="tamanho" type="radio" id="'+data[i].tipo+'" value="'+data[i].tipo+'" disabled name="tamanho">';
                                }else{
                                    html += '<input class="tamanho" type="radio" id="'+data[i].tipo+'" value="'+data[i].tipo+'" data-quantidade="'+data[i].quantidade+'" name="tamanho">';
                                }
                                html += '<label for="'+data[i].tipo+'">'+data[i].tipo+ ' ['+data[i].quantidade+']'+'</label>';
                                html += '</li>';
                        }

                        $("#div_tamanho").append(html);

                        }else{
                            $("#div_tamanho").empty();
                            let html = 'Numeração não encontrada';
                            $("#div_tamanho").append(html);
                        }

                    }, "html");
                for (let i = 0; i < produtos.length; i++) {
                    if(produtos[i].id == prod){
                        $("#cod").val(produtos[i].id);
                        // $("#ref").val(produtos[i].referencia);
                        $("#valor_venda").val(produtos[i].valor_venda);
                        // $("#valor_atacado").val(produtos[i].valor_atacado);
                        $("#valor_compra").val(produtos[i].valor_compra);

                        if(produtos[i].sociedade == 1){
                            $("#sociedade_alerta").show();
                        }else{
                            $("#sociedade_alerta").hide();
                        }
                    }
                    
                }
            }else{
                $("#sociedade_alerta").hide();
            }
        });

        $(document).on("change", "#cliente", function() {
            var valor = $("#cliente").val();
            if($("#entrega").prop('checked')){
                for (let i = 0; i < pessoas.length; i++) {
                    if(valor == pessoas[i].id){
                        $("#endereco").text(pessoas[i].rua + " " +pessoas[i].numero + ", " +pessoas[i].complemento + ", " +pessoas[i].bairro + " - " +pessoas[i].cidade);
                    }
                }
            }
        });

        $(document).on("keyup", "#desconto", function() {
            var valor = $("#total").val();

            var desconto = $("#desconto").val();
            if(desconto.length <= 0){
                desconto = 0;
            }else{
                desconto = desconto.split("$ ");
                desconto = (desconto[1].replace(".", "").replace(",",".") * 100);
            }

            $("#label-total-select2").text('TOTAL: $ ' + ((+valor - +desconto)/100).toFixed(2).replace(".", ","));
        });

        $(document).on("keyup", ".valortxt", function(e) {
            var inputs = $(".valortxt");
            let total = 0;
            let temp = null;
            let temp2 = null;
            for (let i = 0; i < inputs.length; i++) {
                temp = inputs[i].value;
                if(temp.length <= 0){
                    temp = 0;
                }else{
                    temp = temp.split("$ ");
                    temp = (temp[1].replace(".","").replace(",",".") * 100);
                }
                total += +temp;
                
                temp2 = inputs[i].id;
                temp2 = temp2.split("_");
                $(`#valor_${temp2[0]}`).val(temp);

                if(temp2[0]  == '96' && +temp > 0){
                    $("#divparcelado").show();
                    atualiza_parcelas();
                }
            }
            var total_select = $("#total").val();
            var desconto = $("#desconto").val();

            if(desconto.length <= 0){
                desconto = 0;
            }else{
                desconto = desconto.split("$ ");
                desconto = (desconto[1].replace(".", "").replace(",",".") * 100);
            }
            // console.log(desconto);
            if((+total + +desconto).toFixed(0) < +total_select || (+total + +desconto).toFixed(0) > +total_select){
                $("#salvar_pedido_fechado").prop("disabled", true);
            }else{
                $("#salvar_pedido_fechado").prop("disabled", false);
            }

        });

       

        $(document).on("change", "#prevenda", function() {
            if ($("#prevenda").prop("checked") == true) {
                $("#divpag").hide();
            }else{
                $("#divpag").show();
            }
        });

        if ($("#prevenda").prop("checked") == true) {
            $("#divpag").hide();
        }


        var numero = $(".vencimento").length;
        let parcelas = $(".vencimento").length;

        $(document).on("change", "#vencimento0", function() {
            let vencimento = $("#vencimento0").val();
            // console.log(vencimento);
            if(vencimento != ''){
                $($(".vencimento").get()).each(function() {
                    if($(this).attr('id') != 'vencimento0'){
                        vencimento = moment(vencimento).add(1, 'month').format('YYYY-MM-DD');
                        $(this).val(vencimento);
                    }
                });
            }
        });

        $(document).on('click', '#addInput', function() {
            var scntDiv = $('#dynamicDiv');
            let vencimento = moment($(".vencimento").last().val()).format('YYYY-MM-DD');
            vencimento = moment(vencimento).add(1, 'month').format('YYYY-MM-DD');
       
            let html = '';
            html += '<div class="p-0 m-0 row divparcela dp'+numero+'">'
            html += '<div class="col-md-1 text-center p-0">'
            html += '<span class="pt-3 h6">'+(numero+1)+'</span>'
            html += '</div>'
            html += '<div class="col-md-4 p-0">'
            html += '<input type="text" name="parcela['+numero+']"'
            html += 'data-inputmask="\'alias\': \'currency\'" class="form-control border-primary col-sm-5 parcela"'
            html += 'style="display:inline; margin-bottom:2px; margin-right: 4px" />'
            html += '</div>'
            html += '<div class="col-md-4 p-0">'
            html += '<input class="form-control border-primary col-sm-5 vencimento" type="date" name="vencimento['+numero+']" id="vencimento'+numero+'" value="'+vencimento+'"'
            html += 'style="display:inline;">'
            html += '</div>'
            html += '<div class="col-md-2 p-0">'
            html += '<input type="hidden" name="forma_pag['+numero+']" value="0">';
            html += '<input type="hidden" name="data_pag['+numero+']" value="'+vencimento+'">';
            html += '<input type="hidden" name="flag['+numero+']" value="0">';
            // html += '<input type="hidden" name="id_crediario['+numero+']" value="">';
            html += '</div>'
            html += '<div class="col-md-1 p-0">'
            html += '<a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0)" id="remInput" style="float:right">'
            html += '<i class="fa fa-minus"></i>'
            html += '</a>'
            html += '</div>'
            html += '</div>'

            // $("#dynamicDiv").append(html).last();
            // console.log(`.dp${numero-1}`);
            $(html).insertAfter(`.dp${numero-1}`);
            // $(html).after( ".divparcela" );
            $(":input").inputmask();

            numero++;
            parcelas++;
            $("#label-parecelas").text(parcelas + " Parcela(s)");

            atualiza_parcelas();
        });

        $('#atualizar_parcelas').click( function (e) { 
            e.preventDefault();
            atualiza_parcelas();
        });

        function atualiza_parcelas() {
            let parcela = $(".parcela:not([readonly])").get();
            // console.log(parcela.length);
            let total = null;
            if($("#96").prop("checked") == true){
                total = $("#total").val();
                let desconto = $("#desconto").val();
                if(desconto.length <= 0){
                    desconto = 0;
                }else{
                    desconto = desconto.split("$ ");
                    desconto = desconto[1].replace(".", "");
                    desconto = desconto.replace(",", ".");
                    desconto = (desconto *100);
                }
                total = +total - +desconto;
                $(".parcela[readonly]").each(function( index ) {
                    let temp = $(this).val().split("$ ")[1].replace(",", ".");
                    total = +total - (temp*100);
                });
            }else{
                total = $("#valor_96").val();
                $(".parcela[readonly]").each(function( index ) {
                    let temp = $(this).val().split("$ ")[1].replace(",", ".");
                    total = +total - (temp*100);
                });
            }
            $(".parcela:not([readonly])").val(((+total/parcela.length)/100).toFixed(2).replace(".", ","));
        }
        

        $(document).on('click', '#remInput', function(e) {
            e.preventDefault();
            $(this).parents('.divparcela').remove();
            parcelas--;
            numero--;
            $("#label-parecelas").text(parcelas + " Parcela(s)");

            atualiza_parcelas();

            return false;
        });

        $.post("components/venda/action/busca_produtos_estoque.php", "id="+$("#idvenda").val(),
        function(data) {
            if(data != false){
                const produtos = JSON.parse(data);
                
                let carrinho = [];
                for (let i = 0; i < produtos.length; i++) {
                    carrinho.push({
                        id: produtos[i].id,
                        nome: produtos[i].nome,
                        ref: produtos[i].id,
                        tamanho: produtos[i].tamanho,
                        quantidade: produtos[i].quantidade,
                        valor_compra: produtos[i].valor_compra,
                        valor_venda: produtos[i].valor_unit,
                        estoque: produtos[i].estoque+produtos[i].quantidade,
                        // valor_atacado: produtos[i].valor_compra
                    });
                }
                localStorage.setItem('edt_gk_carrinho', JSON.stringify(carrinho));
                cria_campos();
                // atualiza_parcelas();
            }
        }, "html");

        $(document).on("change", ".mpag", function() {
            if ($("#diversos").prop("checked") == true) {
                $("#prevenda").prop('checked', false).change();
                $('#divambos').show();
                $("#0_txt").focus();
                $("#salvar_pedido_fechado").prop("disabled", true);
                $("#0_txt").keyup();
            }else if($("#96").prop("checked") == true){
                $("#prevenda").prop('checked', false).change();
                $('#divparcelado').show();
                $('#divambos').hide();
                // atualiza_parcelas();
                $("#salvar_pedido_fechado").prop("disabled", false);
            }else {
                $('#divambos').hide();
                $("#salvar_pedido_fechado").prop("disabled", false);
            }
            $("#pagamento").val($(".mpag:checked").val());
        });
        if(venda.forma_pag >= 96){
            $(".mpag").change();
        }

        $(document).on("click", ".confirmDeletar", function() {
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR A VENDA?",
                text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa venda será apagado.",
                icon: 'warning',
                buttons: {
                cancel: {
                    text: 'Não',
                    value: 'cancel',
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Sim',
                    value: 'proceed',
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                }
                }
            })
            .then(function(result) {
                switch (result) {
                case "cancel":
                swal({
                    icon: 'info',
                    text: "Ufa! Seus dados estão a salvo."
                });
                break;

                case 'proceed':
                    $.post("components/venda/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            location.replace('?consVendaConsignado');
                        }else{
                            swal({
                                icon: 'danger',
                                text: "Um erro ocorreu, impossível excluir a venda."
                            });
                        }

                    }, "html");
                    $("#input-search").focus();
                break;

                default:
                swal({
                    icon: 'info',
                    text: "Ufa! Seus dados estão a salvo."
                });
                }
            })
            .catch(err => {
                if(err){
                    swal({
                        icon: 'danger',
                        text: "Um erro ocorreu, impossível excluir a venda."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });
        $.extend($.expr[":"], {
            "contains-ci": function(elem, i, match, array) {
                return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });
        $("#input-search").keyup(function() {
            //pega o css da tabela 
            var tabela = $(this).attr('alt');
            if ($(this).val() != "") {
                // console.log($(this).val());
                $("#" + tabela + " tbody>tr").hide();
                $("#" + tabela + " td:contains-ci('" + $(this).val() + "')").parent("tr").show();
            } else {
                $("#" + tabela + " tbody>tr").show();
            }
        });

    });
</script>
