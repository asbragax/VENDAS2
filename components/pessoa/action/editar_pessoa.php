<?php

      if ( isset($_POST['salvar']) ) {
        $pessoa = new Pessoa();

        $pessoa->setId($_POST['id']);

        $pessoa->setNome($_POST['nome']);
        $pessoa->setApelido($_POST['apelido']);
        $pessoa->setSexo($_POST['sexo']);
        $pessoa->setData_nascimento($_POST['data_nascimento']);
        $pessoa->setCpf($_POST['cpf']);
        $pessoa->setEmail($_POST['email']);
        $pessoa->setCelular($_POST['celular']);
        $pessoa->setCEP($_POST['cep']);
        $pessoa->setRua($_POST['rua']);
        $pessoa->setNumero($_POST['numero']);
        $pessoa->setComplemento($_POST['complemento']);
        $pessoa->setBairro($_POST['bairro']);
        $pessoa->setCidade($_POST['cidade']);
        $pessoa->setEstado($_POST['uf']);
        $pessoa->setUser_mod($_SESSION['id']);
        
        $dao = new PessoaDAO();
        

        $gravou = $dao->alterar($pessoa);
        if ($gravou) {
            ?>
    <div class="alert border-faded bg-transparent text-secondary fade show" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon">
                <span class="icon-stack icon-stack-md">
                    <i class="base-7 icon-stack-3x color-success-600"></i>
                    <i class="fa fa-check icon-stack-1x text-white"></i>
                </span>
            </div>
            <div class="flex-1">
                <span class="h5 color-success-600">Pessoa editada com sucesso!</span>
                <br>
                <?php echo $pessoa->getNome(); ?>
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
            <a href="http://geeksistemas.com.br/#contact" target="_blank"
                class="btn btn-outline-danger btn-sm btn-w-m">Reportar</a>
        </div>
    </div>
    <?php }
    }
  ?>