<?php

    if ( isset($_POST['salvar']) ) {
    $nota_produto = new Nota_produto();

    $nota_produto->id_nota = $_POST['id_nota'];
    $nota_produto->id_produto = $_POST['referencia'];
    $nota_produto->nome = $_POST['nome'];
    $nota_produto->grade = $_POST['grade'];

    
    $valorexp = explode("$ ", $_POST['valor']);
    $valor1 = str_replace( '.' ,'', $valorexp[1] );
    $valor =  100 * str_replace (',', '.', $valor1);

    $nota_produto->valor = $valor;

    $nota_produto->quantidade = $_POST['quantidade'];

    $gravou = $nota_produto->grava();

    $dao = new Nota_produtoDAO();
    for ($i=0; $i < count($arr_grades_desc[$_POST['grade']]); $i++) { 
        $dao->cadastrar_grade($_POST['id_nota'], $_POST['id_produto'], $arr_grades_desc[$_POST['grade']][$i], $_POST[$arr_grades_desc[$_POST['grade']][$i]]);
    }
    
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
                <span class="h5 color-success-600">Produto cadastrado na nota com sucesso!</span>
                <br>
                <?php echo $_POST['nome']; ?>
            </div>
    
        </div>
    </div>
    <meta http-equiv="refresh" content="0;URL=?cadNota_produto=<?php echo $_POST['id_nota']; ?>">
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