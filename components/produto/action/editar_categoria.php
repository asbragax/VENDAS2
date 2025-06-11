<?php

      if ( isset($_POST['salvar']) ) {
        $categoria = new Categoria();
        $dao = new CategoriaDAO();

        $oldcategoria = $dao->getPorId($_POST['id']);

        $categoria->id = $_POST['id'];
        $categoria->nome = $_POST['nome'];

        if (isset($_FILES['foto']['tmp_name']) && $_FILES["foto"]["error"] == 0) {
            $arquivo_tmp = $_FILES['foto']['tmp_name'];
            $nome = $_FILES['foto']['name'];
        
            // Pega a extensao
            $extensao = strrchr($nome, '.');
            // Converte a extensao para mimusculo
            $extensao = strtolower($extensao);
            // Somente imagens, .jpg;.jpeg;.gif;.png
            if (strstr('.jpg,.jpeg,.png,.heif,.heic', strtolower($extensao))) {
              // Cria um nome único para esta imagem
              $novoNome = md5(microtime()) . $extensao;
        
              // Concatena a pasta com o nome
              $destino = 'arquivos/categorias/' . $novoNome;
        
              // tenta mover o arquivo para o destino
              if (@move_uploaded_file($arquivo_tmp, $destino)) {
                $_FILES['foto']['name'] = null;
              } else {
                echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
              }
            } else {
              echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
            }
            $categoria->foto = $novoNome;
        }else{
            $categoria->foto = $oldcategoria->foto;
        }
        
        $gravou = $dao->alterar($categoria);
        
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
                <span class="h5 color-success-600">Categoria cadastrada com sucesso!</span>
                <br>
                <?php echo $categoria->nome; ?>
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