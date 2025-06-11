<?php include_once('components/produto/action/cadastrar_produto.php'); 
include_once('components/produto/action/listar_produto.php');
include_once('components/produto/action/listar_categoria.php');
?>

<?php
if($ID_AUTO == 1){

    if(isset($listaProdutos) && count($listaProdutos) > 0){
        $proxid = max(array_column($listaProdutos, 'id'))+1;
    }else{
        $proxid = 1;
    }
}
    // print_r($arr_grades); echo "<br><br>";
    // print_r($arr_grades_desc);
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Novo produto</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <!-- <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Cód.</label>
                    <input type="text" class="form-control border-primary" name="id" required <?php //echo $ID_AUTO == 1 ? '' : "autofocus"; ?>  value="<?php echo $ID_AUTO == 1 ? $proxid : ""; ?>">
                </div> -->
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Referência</label>
                    <input type="text" class="form-control border-primary" name="referencia" id="referencia" <?php echo $ID_AUTO == 0 ? 'autofocus' : ""; ?> value="<?php echo $ID_AUTO == 1 ? $proxid : ""; ?>">
                    <div class="note note-warning note-with-end-icon py-1 mt-1" id="produto_alerta">
                        <div class="note-content text-end">
                            Referência já cadastrada, clique <a id="produto_link">aqui</a> para editá-lo
                        </div>
                        <div class="note-icon"><i class="fa fa-exclamation-circle"></i></div>
                    </div>
                </div>
                <div class="form-group mb-3 col-sm-9">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" required <?php echo $ID_AUTO == 1 ? 'autofocus' : ""; ?>>
                </div>
                <?php if($GRADE == 0){ ?>
                    <div class="form-group mb-3 col-sm-3">
                        <label class="form-label">Estoque</label>
                        <input type="number" class="form-control border-primary" name="estoque" required value="1" min="0">
                    </div>
                <?php }else{ ?>
                    <input type="hidden" name="estoque" value="0">
                <?php } ?>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Valor custo</label>
                    <input type="text" class="form-control border-primary" name="valor_compra" data-inputmask="'alias': 'currency'">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Valor venda</label>
                    <input type="text" class="form-control border-primary" name="valor_venda" type="text" required data-inputmask="'alias': 'currency'">
                </div>
                <!-- <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Valor atacado</label>
                    <input type="text" class="form-control border-primary" name="valor_atacado" type="text" required data-inputmask="'alias': 'currency'">
                </div> -->
                <?php if($SOCIEDADE == 1){ ?>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Sociedade</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="sociedaden" name="sociedade" value="0" checked />
                        <label class="form-check-label" for="sociedaden">Não</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="sociedades" name="sociedade" value="1" />
                        <label class="form-check-label" for="sociedades">Sim</label>
                    </div>
                </div>
                <?php }else{ ?>
                    <input type="hidden" name="sociedade" value="0">
                <?php } ?>
                <?php if($GRADE == 1){ ?>
                    <div class="form-group mb-3 col-sm-2">
                        <label class="form-label">Grade</label>
                        <?php for ($i=0; $i < count($arr_grades); $i++) { ?>
                            <div class="form-check">
                                <input class="form-check-input radio_grade" type="radio" id="<?php echo $i; ?>" name="grade" value="<?php echo $i; ?>" <?php echo $i == 0 ? 'checked' : ''; ?> />
                                <label class="form-check-label" for="<?php echo $i; ?>"><?php echo $arr_grades[$i]; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                    <div class="form-group mb-3 col-sm-2">
                        <label class="form-label">Tipo</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="fem" name="gender" value="f" checked />
                            <label class="form-check-label" for="fem">Feminino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="masc" name="gender" value="m" />
                            <label class="form-check-label" for="masc">Masculino</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Categoria</label>
                        <select class="select2 form-control" required name="categoria" id="categoria">
                            <option value=""></option>
                            <?php for ($i = 0; $i < count($listaCategorias); $i++) { ?>
                            <option value="<?php echo $listaCategorias[$i]['id']; ?>">
                                <?php echo $listaCategorias[$i]['nome']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Foto</label>
                        <input class="form-control border-primary" type="file" name="foto" id="foto">
                    </div>
                <?php if($GRADE == 1){ ?>
                    <h4 class="text-center">Estoque</h4>
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
                <?php } ?>
            </div>
            <div class="col-sm-12 text-end mt-2 px-0">
                <button type="submit" class="btn btn-success float-end" name="salvar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const produtos = <?php echo safe_json_encode($listaProdutos); ?>;
    var TAM_COD = <?php echo safe_json_encode($TAM_COD); ?>;
    // const gd_desc = <?php //echo safe_json_encode($arr_grade_desc); ?>;
    $(document).ready(function() {
        $(":input").inputmask();

        $(".divgrades").hide();
        $("#div_0").show();

        $(".select2").select2({ 
            placeholder: "Selecione",
            containerCssClass: "border-primary"
        });

        $("#produto_alerta").hide();

        $(document).on("keyup", "#referencia", function(){
            const ref = $("#referencia").val();
            // console.log(ref);
            if(ref.length >= TAM_COD){
                for (let i = 0; i < produtos.length; i++) {
                    if(produtos[i].id == ref){
                        $("#produto_link").attr("href", "?edtProduto="+ref);
                        $("#produto_alerta").show();
                    }
                }
            }
        });

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

    });
</script>