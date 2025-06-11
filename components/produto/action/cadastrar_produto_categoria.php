<?php

if (isset($_POST['vincular'])) {
  $dao = new ProdutoDAO();
  for ($i=0; $i < count($_POST['produtos']); $i++) { 
    $gravou = $dao->editar_categoria($_POST['produtos'][$i],$id);
  }

  if ($gravou) { ?>
    <meta http-equiv="refresh" content="0;">
<?php
  }
}
