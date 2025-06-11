<?php

    if ( isset($_POST['salvar']) ) {
    $devolucao = new Devolucao();

    $devolucao->id =  $_POST['id'];
    $devolucao->tipo = $_POST['tipo'];
    $devolucao->obs = $_POST['obs'];
    $devolucao->data = $_POST['data'];
    $devolucao->fornecedor = $_POST['fornecedor'];
    // echo 1;
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    $devolucao->user = $_SESSION['id'];
    $devolucao->time = date("Y-m-d H:i:s");
    $gravou = $devolucao->altera();
    
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
                <span class="h5 color-success-600">Devolucao editada com sucesso!</span>
                <br>
            </div>
    
        </div>
    </div>
    <meta http-equiv="refresh" content="0;URL=?cadDevolucao_produto=<?php echo $devolucao->id; ?>">
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