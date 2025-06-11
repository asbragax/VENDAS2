<?php 
    $id = $_GET['edtCategoria'];
    $dao = new CategoriaDAO();
    $categoria = $dao->getPorIdAssoc($id);
    include_once('components/produto/action/editar_categoria.php'); 
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Nova categoria</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" value="<?php echo $categoria['nome']; ?>" required autofocus>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Foto</label>
                    <input class="form-control border-primary" name="foto" type="file">
                </div>

                
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