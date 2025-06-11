<?php 
include_once('components/produto/action/editar_produto.php'); 
include_once('components/produto/action/listar_categoria.php');
$id = $_GET['edtProduto'];
$dao = new ProdutoDAO();
$produto = $dao->getPorIdAssoc($id);
$grade = $dao->listar_grade($id);  

// print_r($grade);
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Editar produto</h4>
        <a href="?cadProduto" class="btn btn-primary btn-sm">Novo produto</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <!-- <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Cód.</label>
                    <input type="text" class="form-control border-primary" name="id" required readonly="readonly" value="<?php echo $id; ?>">
                </div> -->
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Referência</label>
                    <input type="text" class="form-control border-primary" readonly="readonly" name="referencia" value="<?php echo $produto['referencia']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-9">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" required value="<?php echo $produto['nome']; ?>">
                </div>
                <?php if($GRADE == 0){ ?>
                    <div class="form-group mb-3 col-sm-3">
                        <label class="form-label">Estoque</label>
                        <input type="number" class="form-control border-primary" name="estoque" required min="0" value="<?php echo $produto['estoque']; ?>">
                    </div>
                <?php }else{ ?>
                    <input type="hidden" name="estoque" value="0">
                <?php } ?>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Valor de Compra</label>
                    <input type="text" class="form-control border-primary" name="valor_compra" required data-inputmask="'alias': 'currency'" value="<?php echo str_replace(".", ",",$produto['valor_compra']/100); ?>">
                </div>

                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Valor de venda</label>
                    <input type="text" class="form-control border-primary" name="valor_venda" type="text" required data-inputmask="'alias': 'currency'" value="<?php echo str_replace(".", ",",$produto['valor_venda']/100); ?>">
                </div>
                <!-- <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Valor de atacado</label>
                    <input type="text" class="form-control border-primary" name="valor_atacado" type="text" required data-inputmask="'alias': 'currency'" value="<?php echo str_replace(".", ",",$produto['valor_atacado']/100); ?>">
                </div> -->
                    <?php if($SOCIEDADE == 1){ ?>
                <div class="form-group mb-3 col-sm-1">
                    <label class="form-label">Sociedade</label>
                    <div class="form-check custom-switch">
                        <input type="radio" class="form-check-input" id="sociedaden" name="sociedade" value="0" checked>
                        <label class="form-check-label" for="sociedaden">Não</label>
                    </div>
                    <div class="form-check custom-switch">
                        <input type="radio" class="form-check-input" id="sociedades" name="sociedade" value="1" <?php echo $produto['sociedade'] == 1 ? "checked" : ""; ?>>
                        <label class="form-check-label" for="sociedades">Sim</label>
                    </div>
                </div>
                <?php }else{ ?>
                    <input type="hidden" name="sociedade" value="0">
                <?php } ?>
                <?php if($GRADE == 1){ ?>
                    <div class="form-group mb-3 col-sm-1">
                        <label class="form-label">Grade</label>
                        <?php for ($i=0; $i < count($arr_grades); $i++) { ?>
                            <div class="form-check">
                                <input class="form-check-input radio_grade" onclick="return false;" type="radio" id="<?php echo $i; ?>" name="grade" value="<?php echo $i; ?>" <?php echo $i == $produto['grade'] ? 'checked' : ''; ?> />
                                <label class="form-check-label" for="<?php echo $i; ?>"><?php echo $arr_grades[$i]; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                    <div class="form-group mb-3 col-sm-1">
                        <label class="form-label">Tipo</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="fem" name="gender" value="f" checked />
                            <label class="form-check-label" for="fem">Feminino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="masc" name="gender" value="m" <?php echo $produto['gender'] == 'm' ? 'checked' : ""; ?> />
                            <label class="form-check-label" for="masc">Masculino</label>
                        </div>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Categoria</label>
                        <select class="select2 form-control" required name="categoria" id="categoria">
                            <option value=""></option>
                            <?php for ($i = 0; $i < count($listaCategorias); $i++) { ?>
                                <option value="<?php echo $listaCategorias[$i]['id']; ?>" <?php echo $listaCategorias[$i]['id'] == $produto['categoria'] ? "selected" : ""; ?>>
                                    <?php echo $listaCategorias[$i]['nome']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                <?php if($GRADE == 1){ ?>
                    <h4 class="text-center">Estoque</h4>
                    <?php for ($i=0; $i < count($arr_grades); $i++) { 
                         if($produto['grade'] == $i){   
                        ?>
                        <div class="form-group mb-3 col-sm-12 divgrades" id="div_<?php echo $i; ?>">
                            <div class="row justify-content-center">
                            <?php for ($x=0; $x < count($arr_grades_desc[$i]); $x++) { 
                                      $key = null;
                                      $key = array_search($arr_grades_desc[$i][$x], array_column($grade, 'tipo'));   
                                      ?>
                                <div class="form-group mb-1 col-sm-3">
                                    <label class="form-label"><?php echo $arr_grades_desc[$i][$x]; ?></label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-danger dec_qtde" id="dec_<?php echo $arr_grades_desc[$i][$x]; ?>"><i class="fa fa-minus"></i></button>
                                        <input type="text" class="form-control border-primary text-center campo_estoque" value="<?php echo is_int($key) ? $grade[$key]['quantidade'] : 0;  ?>" id="val_<?php echo $arr_grades_desc[$i][$x]; ?>" name="<?php echo $arr_grades_desc[$i][$x]; ?>">
                                        <button type="button" class="btn btn-success inc_qtde" id="inc_<?php echo $arr_grades_desc[$i][$x]; ?>"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    <?php } } ?>
                    <div class="col-sm-12 text-end">
                        <span class="h4" id="estoquetotal"></span>
                    </div>
                <?php }else{ ?>
                    <input type="hidden" name="grade" value="0">
                <?php } ?>
            </div>
            <div class="col-sm-12 text-end mt-2 px-0">
                <button name="excluir_produto" value="id=<?php echo $id; ?>" class="btn btn-danger confirmDeletar me-1">
                    <i class="fa fa-trash"></i>
                    Excluir produto
                </button>
                <button type="submit" class="btn btn-success float-end" name="editar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const produto = <?php echo safe_json_encode($produto); ?>;
    $(document).ready(function() {
        $(":input").inputmask();

        $(".divgrades").hide();
        $(`#div_${produto.grade}`).show();

        $(".select2").select2({ 
            placeholder: "Selecione",
            containerCssClass: "border-primary"
        });
        calcula_estoque();
        $(document).on("change", ".radio_grade", function(){
            const valor = $("input[name='grade']:checked").val();
            $(".divgrades").hide();
            $(`#div_${valor}`).show();
        });

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
        }

        $(document).on("click", ".confirmDeletar", function(e) {
            e.preventDefault();
            var dados = $(this).val();
            var url = $(this).attr('name');
            swal({
                title: "EXCLUIR O PRODUTO?",
                text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a esse produto será apagado.",
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
                    $.post("components/produto/action/" + url + ".php", dados,
                    function(data) {
                        debugger
                        if (data!= null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Registro apagado com sucesso."
                            });
                            window.location.replace("?consProduto");
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
    });
</script>