<?php

    if ( isset($_POST['salvar']) ) {
    $nota = new Nota();

    $nota->id = uniqidReal(60);
    $nota->numero = $_POST['numero'];
    $nota->obs = $_POST['obs'];
    $nota->data = $_POST['data'];
    $nota->fornecedor = $_POST['fornecedor'];
    // echo 1;

    $valorexp = explode("$ ", $_POST['valor']);
    $valor1 = str_replace( '.' ,'', $valorexp[1] );
    $valor =  100 * str_replace (',', '.', $valor1);

    $nota->valor = $valor;
    if (isset($_FILES['arquivo']['tmp_name']) && $_FILES["arquivo"]["error"] == 0) {
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $nome = $_FILES['arquivo']['name'];
    
        // Pega a extensao
        $extensao = strrchr($nome, '.');
        // Converte a extensao para mimusculo
        $extensao = strtolower($extensao);
        // Somente imagens, .jpg;.jpeg;.gif;.png
        if (strstr('.jpg,.jpeg,.png,.heif,.heic,.pdf', strtolower($extensao))) {
            // Cria um nome único para esta imagem
            $novoNome = md5(microtime()) . $extensao;
    
            // Concatena a pasta com o nome
            $destino = 'arquivos/notas/' . $novoNome;
    
            // tenta mover o arquivo para o destino
            if (@move_uploaded_file($arquivo_tmp, $destino)) {
            $_FILES['arquivo']['name'] = null;
            } else {
            echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
        }
        $nota->arquivo = $novoNome;
    }else{
        $nota->arquivo = '';
    }
    
    $nota->user = $_SESSION['id'];
    $nota->time = date("Y-m-d H:i:s");
    $gravou = $nota->grava();
    
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
                <span class="h5 color-success-600">Nota cadastrada com sucesso!</span>
                <br>
                <?php echo $nota->numero; ?>
            </div>
    
        </div>
    </div>
    <meta http-equiv="refresh" content="0;URL=?cadNota_produto=<?php echo $nota->id; ?>">
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