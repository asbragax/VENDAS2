<?php

if (isset($_POST['salvar'])) {
  $post = new Post();

  $post->setTexto($_POST['texto']);

  if (isset($_FILES['arquivo']['tmp_name']) && $_FILES["arquivo"]["error"] == 0) {
    $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
    $nome = $_FILES['arquivo']['name'];

    // Pega a extensao
    $extensao = strrchr($nome, '.');
    // Converte a extensao para mimusculo
    $extensao = strtolower($extensao);
    // Somente imagens, .jpg;.jpeg;.gif;.png
    if (strstr('.jpg,.jpeg,.png', strtolower($extensao))) {
      // Cria um nome único para esta imagem
      $novoNome = md5(microtime()) . $extensao;

      // Concatena a pasta com o nome
      $destino = 'arquivos/banners/' . $novoNome;

      // tenta mover o arquivo para o destino
      if (@move_uploaded_file($arquivo_tmp, $destino)) {
        $_FILES['arquivo']['name'] = null;
      } else {
        echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
      }
    } else {
      echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
    }
  }
  $post->setImg($novoNome);
  $gravou = $post->grava();

  if ($gravou) { ?>
    <div class="alert alert-info" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Cadastrado com <strong>sucesso!</strong>
    </div>
<?php
  }
}
