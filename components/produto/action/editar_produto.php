<?php

      if ( isset($_POST['editar']) ) {
        $produto = new Produto();

        $produto->id = $_POST['id'];
        $produto->estoque = $_POST['estoque'];
        $produto->nome = $_POST['nome'];
        $produto->referencia = $_POST['referencia'];

        $valorexp = explode("$ ", $_POST['valor_compra']);
        $valor1 = str_replace( '.' ,'', $valorexp[1] );
        $valor =  100 * str_replace (',', '.', $valor1);
        
        $produto->valor_compra = $valor;
        
        $valorexp = explode("$ ", $_POST['valor_venda']);
        $valor1 = str_replace( '.' ,'', $valorexp[1] );
        $valor =  100 * str_replace (',', '.', $valor1);
        
        $produto->valor_venda = $valor;
        
        // $valorexp = explode("$ ", $_POST['valor_atacado']);
        // $valor1 = str_replace( '.' ,'', $valorexp[1] );
        // $valor =  100 * str_replace (',', '.', $valor1);
        
        // $produto->valor_atacado = $valor;
        $produto->sociedade = $_POST['sociedade'];
        $produto->gender = $_POST['gender'];
        $produto->categoria = $_POST['categoria'];
        $produto->grade = $_POST['grade'];
        $produto->user = $_SESSION['id'];
        
        $dao = new ProdutoDAO();
        $dao->excluir_grade($_POST['id']);
        for ($i=0; $i < count($arr_grades_desc[$_POST['grade']]); $i++) { 
           $dao->cadastrar_grade($_POST['id'], $arr_grades_desc[$_POST['grade']][$i], $_POST[$arr_grades_desc[$_POST['grade']][$i]]);
        }

        $gravou = $dao->alterar($produto);
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
                <span class="h5 color-success-600">Produto editado com sucesso!</span>
                <br>
                <?php echo $produto->nome; ?>
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