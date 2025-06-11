<?php include_once('components/fornecedor/action/cadastrar_fornecedor.php'); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Novo fornecedor</h4>
        <a href="?consFornecedor" class="btn btn-primary btn-sm">Ver fornecedores</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-3 col-sm-9">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" required autofocus>
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">CNPJ</label>
                    <input type="text" class="form-control border-primary" name="cnpj" id="cnpj" required  data-inputmask="'alias':'cnpj'">
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">CEP</label>
                    <input type="text" class="form-control border-primary" name="cep" id="cep" data-inputmask="'mask': '99999-999'">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Número</label>
                    <input type="text" class="form-control border-primary" name="numero" id="numero">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Complemento</label>
                    <input type="text" class="form-control border-primary" name="complemento" id="complemento">
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Rua</label>
                    <input class="form-control border-primary" type="text" name="rua" id="rua">
                </div>

            </div>
            <div class="row">
                <div class="form-group mb-3 col-sm-5">
                    <label class="form-label">Bairro</label>
                    <input type="text" class="form-control border-primary" name="bairro" id="bairro">
                </div>
                <div class="form-group mb-3 col-sm-5">
                    <label class="form-label">Cidade</label>
                    <input type="text" class="form-control border-primary" name="cidade" id="cidade">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Estado</label>
                    <input class="form-control border-primary" type="text" name="uf" id="uf">
                </div>

            </div>
            <div class="col-sm-12 text-end mt-2 px-0">
                <button type="submit" class="btn float-end btn-success" name="salvar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();

    });


    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");


                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
</script>