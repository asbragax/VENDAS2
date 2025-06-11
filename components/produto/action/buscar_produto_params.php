<?php
    include_once("../../../db/Conexao.class.php");
    include_once("../controller/ProdutoDAO.php");
    include_once("../../../includes/json_encode.php");
    $dao = new ProdutoDAO();
    // $_POST['id'] = 216004;
    $produtos = $dao->listar_produtos_site($_POST['cat'], $_POST['order'], $_POST['asc'], $_POST['name'], $_POST['gender'], $_POST['minprice'], $_POST['maxprice'],$_POST['offset'], $_POST['per_page']);


// print_r($Venda);
    // echo $_POST['cat']." ".$_POST['order']." ".$_POST['asc']." ".$_POST['name']." ".$_POST['minprice']." ".$_POST['maxprice']." ".$_POST['offset']." ".$_POST['per_page'];
    echo safe_json_encode($produtos);

?>