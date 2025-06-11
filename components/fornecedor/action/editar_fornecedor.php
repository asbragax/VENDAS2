<?php

      if ( isset($_POST['salvar']) ) {
        $fornecedor = new Fornecedor();

        $fornecedor->setId($_POST['id']);

        $fornecedor->setNome($_POST['nome']);
        $fornecedor->setCnpj($_POST['cnpj']);
        $fornecedor->setCep($_POST['cep']);
        $fornecedor->setRua($_POST['rua']);
        $fornecedor->setNumero($_POST['numero']);
        $fornecedor->setComplemento($_POST['complemento']);
        $fornecedor->setBairro($_POST['bairro']);
        $fornecedor->setCidade($_POST['cidade']);
        $fornecedor->setEstado($_POST['uf']);
        $dao = new FornecedorDAO();
        

        $gravou = $dao->alterar($fornecedor);
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
                <span class="h5 color-success-600">Fornecedor editad com sucesso!</span>
                <br>
                <?php echo $fornecedor->getNome(); ?>
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