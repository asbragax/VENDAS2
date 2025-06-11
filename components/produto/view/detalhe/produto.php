<?php 
$id = $_GET['dtlProduto'];
$dao = new ProdutoDAO();
$produto = $dao->getPorIdAssoc($id);
$fotos = $dao->listar_fotos($id);  
$cores = $dao->listar_cor($id);  
include_once('components/produto/view/detalhe/modal.php'); 
include_once('components/produto/action/incluir_fotos.php'); 
include_once('components/produto/action/incluir_cor.php'); 
include_once('components/produto/action/excluir_fotos.php'); 

// print_r($grade);
?>
<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_excluir_fotos">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Fotos do produto</h4>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-add-cor" class="btn btn-orange btn-sm me-1">Incluir cor</a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-add-fotos" class="btn btn-purple btn-sm me-1">Incluir fotos</a>
            <button class="btn btn-sm btn-danger float-end" id="excluir_fotos" name="excluir_fotos">
                <i class="fa fa-trash"></i> Excluir fotos
            </button>
            <a href="?consProduto" class="btn btn-primary btn-sm">Ver produtos</a>
        </div>
        <div class="panel-body">
            <div class="row">
            <input type="hidden" id="id" value="<?php echo $id; ?>">
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Cód.</label>
                    <input type="text" class="form-control border-primary" name="id" required readonly="readonly" value="<?php echo $id; ?>">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Referência</label>
                    <input type="text" class="form-control border-primary" readonly="readonly" name="referencia" value="<?php echo $produto['referencia']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" readonly="readonly" name="nome" required value="<?php echo $produto['nome']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <h4 class="text-center"><?php echo count($fotos); ?> fotos</h4>
                    <?php for ($i=0; $i < count($fotos); $i++) {  ?>
                    <div class="w-25 mb-3" style="position: relative;">
                        <img src="arquivos/produtos/<?php echo $fotos[$i]['foto']; ?>" class="mw-100 rounded" alt="Foto do produto <?php echo $produto['nome']; ?>">
                        <div class="checkfoto" style="position:absolute; top:0px; right:10px">
                            <input style="display:none" class="form-check-input realcheckfoto" type="checkbox" name="foto[]" id="<?php echo $fotos[$i]['foto']; ?>" value="<?php echo $fotos[$i]['id_foto'] . '|' . $fotos[$i]['foto']; ?>">
                            <label class="labelcheckfoto" for="<?php echo $fotos[$i]['foto']; ?>"><i class="fa fa-trash btn btn-md btn-default btn-icon"></i></label>
                        </div>
                        <button class="btn btn-sm btn-<?php echo $fotos[$i]['main'] == '1' ? 'success' : 'secondary' ?> btn-icon  mainFoto" style="position:absolute; top:0px; right:45px"  value="<?php echo $fotos[$i]['id_foto']; ?>">
                            <i class="fa fa-check btn btn-md btn-<?php echo $fotos[$i]['main'] == '1' ? 'success' : 'secondary' ?> btn-icon "></i>
                        </button>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-sm-4">
                    <h4 class="text-center"><?php echo count($cores); ?> cores</h4>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <?php for ($i=0; $i < count($cores); $i++) {  ?>
                                <tr>
                                    <th class="text-center">
                                        <a href="#" style="background-color: <?php echo $cores[$i]['cor']; ?>" class="btn-sm btn btn-icon border-1 border"></a>
                                    </th>
                                    <th>
                                        <button class="btn btn-sm btn-danger btn-icon btnDeletarCor" value="id=<?php echo $cores[$i]['id']; ?>&cor=<?php echo $cores[$i]['cor']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </th>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
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

        $("#excluir_fotos").hide();

        $(document).on("click",".checkfoto", function(e){
            e.preventDefault();
            // $(".superbox-show").remove();
            var check = $(this);
            var btn = check.find("input");
            var label = check.find("label");
            var i = label.find("i");
            if(btn.prop('checked') == true){
                btn.attr("checked", false);
                i.removeClass("btn-danger");
                i.addClass("btn-default");
            }else{
                btn.attr("checked", true);
                i.removeClass("btn-default");
                i.addClass("btn-danger");
            }

            var checkedBoxes = $(".realcheckfoto:checked");
            if(checkedBoxes.length > 0){
                $("#excluir_fotos").show();
            }else{
                $("#excluir_fotos").hide();
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
        });

        $(document).on("click", ".dec_qtde", function() {
            var id = $(this).attr('id');
            id = id.split("_");
            var qtde = $("#val_" + id[1]).val();
            if( $("#val_" + id[1]).val() > 0){
                $("#val_" + id[1]).val(+qtde - 1).change();
            }
        });

        $(document).on("click",".mainFoto", function(e){
            // console.log('id='+$("#id").val()+'&foto='+$(this).val());
            var foto = $(this).val();
            e.preventDefault();
            swal({
                title: "Definir a foto como principal?",
                text: "Tem certeza do que está fazendo?",
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
                    text: "Ufa! Foi por pouco."
                });
                break;

                case 'proceed':
                    // console.log('id='+$("#id").val()+'&foto='+foto);
                    $.post("components/produto/action/altera_foto_principal.php", 'id='+$("#id").val()+'&foto='+foto,
                    function(data) {
                        debugger
                        if (data != null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Foto alterada com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível definir a foto como principal."
                            });
                        }

                }, "html");

                break;

                default:
                swal({
                    icon: 'info',
                    text: "Ufa! Foi por pouco."
                });
                }
            })
            .catch(err => {
                if(err){
                    swal({
                        icon: 'warning',
                        text: "Um erro ocorreu, impossível definir a foto como principal."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });

        });

        $(document).on("click",".btnDeletarCor", function(e){
            // console.log('id='+$("#id").val()+'&foto='+$(this).val());
            var dados = $(this).val();
            // console.log(dados);
            e.preventDefault();
            swal({
                title: "Deseja excluir a cor do produto?",
                text: "Tem certeza do que está fazendo?",
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
                    text: "Ufa! Foi por pouco."
                });
                break;

                case 'proceed':
                    $.post("components/produto/action/excluir_cor.php", dados,
                    function(data) {
                        debugger
                        if (data != null && data != false) {
                            swal({
                                icon: 'success',
                                text: "Cor excluída com sucesso."
                            });
                            location.reload();
                        }else{
                            swal({
                                icon: 'warning',
                                text: "Um erro ocorreu, impossível excluir a cor."
                            });
                        }

                }, "html");

                break;

                default:
                swal({
                    icon: 'info',
                    text: "Ufa! Foi por pouco."
                });
                }
            })
            .catch(err => {
                if(err){
                    swal({
                        icon: 'warning',
                        text: "Um erro ocorreu, impossível excluir a cor."
                    });
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });

        });

        $("#colorpicker-default").spectrum({
            showInput: true
        });
    });
</script>