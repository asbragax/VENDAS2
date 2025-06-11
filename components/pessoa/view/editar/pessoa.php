<?php 
include_once('components/pessoa/action/editar_pessoa.php'); 
$id = $_GET['edtPessoa'];
$dao = new PessoaDAO();
$pessoa = $dao->getPorIdAssoc($id);
?>
<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Editar cliente</h4>
    <a href="?consPessoa" class="btn btn-primary btn-sm">Ver clientes</a>
  </div>
  <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" required autofocus value="<?php echo $pessoa['nome']; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Apelido</label>
                    <input type="text" class="form-control border-primary" name="apelido" value="<?php echo $pessoa['apelido']; ?>">
                </div>
                <div class="form-group mb-3 mb-3 col-sm-3">
                    <label class="form-label">Sexo</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="masc" name="sexo" value="m" checked />
                        <label class="form-check-label" for="masc">Masc.</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="fem" name="sexo" value="f" <?php echo $pessoa['sexo'] == 'f' ? "checked" : ""; ?> />
                        <label class="form-check-label" for="fem">Fem.</label>
                    </div>
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Nascimento</label>
                    <input type="date" class="form-control border-primary" name="data_nascimento" value="<?php echo $pessoa['data_nascimento']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control border-primary" name="cpf" data-inputmask="'alias':'cpf'" value="<?php echo $pessoa['cpf']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">E-mail</label>
                    <input type="text" class="form-control border-primary" name="email" id="email"  value="<?php echo $pessoa['email']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label class="form-label">Celular</label>
                    <input type="text" class="form-control border-primary" data-inputmask="'mask': '(99)99999-9999'" name="celular" id="celular"  value="<?php echo $pessoa['celular']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">CEP</label>
                    <input class="form-control border-primary" name="cep" type="text" id="cep" data-inputmask="'mask': '99999-999'"  value="<?php echo $pessoa['cep']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Número</label>
                    <input class="form-control border-primary" name="numero" type="text" id="numero"  value="<?php echo $pessoa['numero']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Complemento</label>
                    <input class="form-control border-primary" name="complemento" type="text" id="complemento"  value="<?php echo $pessoa['complemento']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label class="form-label">Rua</label>
                    <input class="form-control border-primary" name="rua" type="text" id="rua"  value="<?php echo $pessoa['rua']; ?>">
                </div>

                <div class="form-group mb-3 col-sm-5">
                    <label class="form-label">Bairro</label>
                    <input class="form-control border-primary" name="bairro" type="text" id="bairro"  value="<?php echo $pessoa['bairro']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-5">
                    <label class="form-label">Cidade</label>
                    <input class="form-control border-primary" name="cidade" type="text" id="cidade"  value="<?php echo $pessoa['cidade']; ?>">
                </div>
                <div class="form-group mb-3 col-sm-2">
                    <label class="form-label">Estado</label>
                    <input class="form-control border-primary" name="uf" type="text" id="uf"  value="<?php echo $pessoa['estado']; ?>">
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
    $(document).ready(function() {
        $(":input").inputmask();
        
        // $('.select2-placeholder').select2({
        //     placeholder: "Selecione...",
        //     allowClear: true
        // });

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

    });
</script>