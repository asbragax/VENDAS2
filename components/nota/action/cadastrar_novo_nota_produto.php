<?php

    if ( isset($_POST['novo_salvar']) ) {
    $produto = new Produto();

    $produto->id = $_POST['novo_referencia'];
    $produto->estoque = $_POST['novo_estoque'];
    $produto->nome = $_POST['novo_nome'];
    $produto->referencia = $_POST['novo_referencia'];

    $valorexp = explode("$ ", $_POST['novo_valor_compra']);
    $valor1 = str_replace( '.' ,'', $valorexp[1] );
    $valor =  100 * str_replace (',', '.', $valor1);
    $produto->valor_compra = $valor;
    
    $valorexp = explode("$ ", $_POST['novo_valor_venda']);
    $valor1 = str_replace( '.' ,'', $valorexp[1] );
    $valor =  100 * str_replace (',', '.', $valor1);
    
    $produto->valor_venda = $valor;
    
    // $valorexp = explode("$ ", $_POST['valor_atacado']);
    // $valor1 = str_replace( '.' ,'', $valorexp[1] );
    // $valor =  100 * str_replace (',', '.', $valor1);
    
    // $produto->valor_atacado = $valor;
    
    $produto->sociedade = $_POST['novo_sociedade'];
    $produto->gender = $_POST['novo_gender'];
    $produto->categoria = $_POST['novo_categoria'];
    $produto->grade = $_POST['novo_grade'];
    $produto->user = $_SESSION['id'];
    
    
    $gravou = $produto->grava();

    $dao = new ProdutoDAO();
    for ($i=0; $i < count($arr_grades_desc[$_POST['novo_grade']]); $i++) { 
        $dao->cadastrar_grade($_POST['novo_referencia'], $arr_grades_desc[$_POST['novo_grade']][$i], 0);
    }

    
    $nota_produto = new Nota_produto();

    $nota_produto->id_nota = $_POST['id_nota'];
    $nota_produto->id_produto = $_POST['novo_referencia'];
    $nota_produto->nome = $_POST['novo_nome'];
    $nota_produto->grade = $_POST['novo_grade'];

    
    $valorexp = explode("$ ", $_POST['novo_valor_compra']);
    $valor1 = str_replace( '.' ,'', $valorexp[1] );
    $valor =  100 * str_replace (',', '.', $valor1);

    $nota_produto->valor = $valor * $_POST['novo_quantidade'];

    $nota_produto->quantidade = $_POST['novo_quantidade'];

    $gravou = $nota_produto->grava();

    $dao = new Nota_produtoDAO();
    for ($i=0; $i < count($arr_grades_desc[$_POST['novo_grade']]); $i++) { 
        $dao->cadastrar_grade($_POST['id_nota'], $_POST['novo_referencia'], $arr_grades_desc[$_POST['novo_grade']][$i], $_POST["novo_".$arr_grades_desc[$_POST['novo_grade']][$i]]);
    }
    // $gravou = 0;
    
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