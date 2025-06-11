<?php 
include_once('components/fornecedor/action/listar_fornecedor.php'); 
include_once('components/produto/action/listar_produto.php');
include_once('components/devolucao/action/cadastrar_devolucao_produto.php'); 
$id = $_GET['cadDevolucao_produto'];

$dao = new DevolucaoDAO();
$devolucao = $dao->getPorIdAssoc($id);

$dao = new Devolucao_produtoDAO();

$listaItens = $dao->listar($id);

if(isset($listaProdutos) && count($listaProdutos) > 0){
    $proxid = max(array_column($listaProdutos, 'id'))+1;
}else{
    $proxid = 1;
}
?>

<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Inserir novo produtos na devolução</h4>
    <a href="?consDevolucao" class="btn btn-primary btn-sm">Ver devoluções</a>
  </div>
  <div class="panel-body">
    <div class="tab-content bg-white p-3 rounded-bottom">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Referência</label>
                    <input type="text" class="form-control border-primary" name="referencia" id="referencia" autofocus>
                </div>
                <input type="hidden" name="id_produto" id="id_produto">
                <input type="hidden" name="id_devolucao" value="<?php echo $id; ?>">
                <div class="form-group mb-3 col-sm-7">
                    <label class="form-label">Produto</label>
                    <input type="text" class="form-control border-primary" name="nome" id="nome" readonly>
                    <input type="hidden" name="grade" id="grade">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Quantidade</label>
                    <input type="number" class="form-control border-primary" id="quantidade" name="quantidade" value="0" readonly>
                </div>
            </div>

            <h4 class="text-center">Quantidade</h4>
            <?php for ($i=0; $i < count($arr_grades); $i++) { ?>
                <div class="form-group mb-3 col-sm-12 divgrades" id="div_<?php echo $i; ?>">
                    <div class="row justify-content-center">
                    <?php for ($x=0; $x < count($arr_grades_desc[$i]); $x++) { ?>
                        <div class="form-group mb-1 col-sm-3">
                            <label class="form-label"><?php echo $arr_grades_desc[$i][$x]; ?></label>
                            <div class="input-group">
                                <button type="button" class="btn btn-danger dec_qtde" id="dec_<?php echo $arr_grades_desc[$i][$x]; ?>"><i class="fa fa-minus"></i></button>
                                <input type="text" class="form-control border-primary text-center campo_estoque" value="0" id="val_<?php echo $arr_grades_desc[$i][$x]; ?>" name="<?php echo $arr_grades_desc[$i][$x]; ?>">
                                <button type="button" class="btn btn-success inc_qtde" id="inc_<?php echo $arr_grades_desc[$i][$x]; ?>"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-12 text-end">
                <span class="h4" id="estoquetotal"></span>
            </div>
            
            <div class="col-sm-12 mt-2 px-0">
                
                <button type="submit" class="btn btn-success float-end me-1" name="salvar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>

        </form>
        <div class="col-sm-12 mt-2 px-0">
            <a href="?dtlDevolucao=<?php echo $id; ?>" class="btn btn-info float-end me-1">
                Avançar
                <span class="fa fa-arrow-right me-1"></span>
            </a>
        </div>
    </div>
       
  </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Produtos da devolucao</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive mt-4">
            <table id="table" class="table table-sm table-bordered table-hover table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th>Item</th>
                        <th>Quantidade</th>
                        <!-- <th>Valor Unitário</th>
                        <th>Subtotal</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ( $i = 0; $i < count($listaItens); $i++ ) {?>
                        <tr>
                            <td><?php echo $listaItens[$i]['id_produto']." - ".$listaItens[$i]['nome']; ?></td>
                            <td><?php echo $listaItens[$i]['quantidade']; ?></td>
                            <!-- <td>$ <?php //echo number_format(($listaItens[$i]['valor']/$listaItens[$i]['quantidade'])/100, 2, ",", "."); ?></td>
                            <td>$ <?php //echo number_format($listaItens[$i]['valor']/100, 2, ",", "."); ?></td> -->
                            <td class="text-center">
                                <button name="excluir_devolucao_produto" value="id=<?php echo $listaItens[$i]["id"]; ?>&devolucao=<?php echo $listaItens[$i]["id_devolucao"]; ?>&prod=<?php echo $listaItens[$i]["id_produto"]; ?>" class="btn btn-danger btn-icon btn-sm confirmDeletar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const produtos = <?php echo safe_json_encode($listaProdutos); ?>;
    var TAM_COD = <?php echo safe_json_encode($TAM_COD); ?>;
    $(document).ready(function() {
        $(":input").inputmask();

        $(".divgrades").hide();

        $('.select2').select2({
            placeholder: "Selecione...",
            allowClear: true,
            containerCssClass: "border-primary"
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $(document).on("keyup", "#referencia", function(){
            const ref = $("#referencia").val();
            // console.log(ref);
            if(ref.length >= TAM_COD){
                for (let i = 0; i < produtos.length; i++) {
                    if(produtos[i].id == ref){
                        $("#produto_alerta").hide();
                        $(".divgrades").hide();
                        $(`#div_${produtos[i].grade}`).show();
                        $(`#nome`).val(produtos[i].nome);
                        $(`#id_produto`).val(produtos[i].id);
                        $(`#grade`).val(produtos[i].grade);
                    }
                }
            }
        });

        // $(document).on("change", ".radio_grade", function(){
        //     const valor = $("input[name='grade']:checked").val();
        //     $(".divgrades").hide();
        //     $(`#div_${valor}`).show();
        // });

        $(document).on("click", ".inc_qtde", function() {
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#val_" + id[1]).val();
            $("#val_" + id[1]).val(+qtde + 1).change();
            calcula_estoque();
        });

        $(document).on("click", ".dec_qtde", function() {
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#val_" + id[1]).val();
            if( $("#val_" + id[1]).val() > 0){
                $("#val_" + id[1]).val(+qtde - 1).change();
            }
            calcula_estoque();
        });

        function calcula_estoque() {
            let campos = $(".campo_estoque");
            let qtde = 00;
            for (let i = 0; i < campos.length; i++) {
                qtde += +campos[i].value;
            }

            $("#estoquetotal").html("Total: "+qtde);
            $("#quantidade").val(qtde);
        }

        $(document).on("click", ".confirmDeletar", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR O PRODUTO?",
                text: "O item será removido da devolução.",
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
                    $.post("components/devolucao/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível excluir o produto."
                            });
                        }

                    }, "html");
                   
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
                        text: "Um erro ocorreu, impossível excluir o produto."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        });


        $(".novo_divgrades").hide();
        $("#novo_div_0").show();

        $("#produto_alerta").hide();

        $(document).on("keyup", "#novo_referencia", function(){
            const ref = $("#novo_referencia").val();
            // console.log(ref);
            if(ref.length >= TAM_COD){
                for (let i = 0; i < produtos.length; i++) {
                    if(produtos[i].id == ref){
                        // $("#produto_link").attr("href", "?edtProduto="+ref);
                        $("#produto_alerta").show();
                        break;
                    }else{
                        $("#produto_alerta").hide();
                    }
                }
            }else{
                $("#produto_alerta").hide();
            }
        });

        $(document).on("change", ".novo_radio_grade", function(){
            const valor = $("input[name='novo_grade']:checked").val();
            $(".novo_divgrades").hide();
            $(`#novo_div_${valor}`).show();
        });

        $(document).on("click", ".novo_inc_qtde", function() {
            var id = $(this).attr('id');
            id = id.split("_");
            // console.log(id);
            var qtde = $("#novo_val_" + id[2]).val();
            $("#novo_val_" + id[2]).val(+qtde + 1).change();
            novo_calcula_estoque();
        });

        $(document).on("click", ".novo_dec_qtde", function() {
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#novo_val_" + id[2]).val();
            if( $("#novo_val_" + id[2]).val() > 0){
                $("#novo_val_" + id[2]).val(+qtde - 1).change();
            }
            novo_calcula_estoque();
        });

        function novo_calcula_estoque() {
            let campos = $(".novo_campo_estoque");
            let qtde = 0;
            for (let i = 0; i < campos.length; i++) {
                qtde += +campos[i].value;
            }

            $("#novo_estoquetotal").html("Total: "+qtde);
            $("#novo_quantidade").val(qtde);
        }


    });
</script>