<?php
if (isset($_POST['foto'])) {
    $dao = new ProdutoDAO();
    for ($i = 0; $i < count($_POST['foto']); $i++) {
        $pieces = explode('|', $_POST['foto'][$i]);
        $excluir = $dao->excluir_foto($pieces[0]);
        unlink('fotos/' . $pieces[1]);
    }
?>
    <meta http-equiv="refresh" content="0;">
<?php
}

?>