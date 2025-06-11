<?php

      if ( isset($_POST['salvar']) ) {
        $produto = new Produto();

        $produto->id = $_POST['referencia'];
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

        $gravou = $produto->grava();
        // print_r($arr_grades_desc[$_POST['grade']]);
        $dao = new ProdutoDAO();
        for ($i=0; $i < count($arr_grades_desc[$_POST['grade']]); $i++) { 
            $dao->cadastrar_grade($_POST['referencia'], $arr_grades_desc[$_POST['grade']][$i], $_POST[$arr_grades_desc[$_POST['grade']][$i]]);
        }

        if(isset($_FILES['foto']['tmp_name']) && $_FILES["foto"]["error"] == 0){
            $arquivo_tmp = $_FILES['foto']['tmp_name'];
            $nome = $_FILES['foto']['name'];
            
            // Pega a extensao
            $extensao = strrchr($nome, '.');
            // Converte a extensao para mimusculo
            $extensao = strtolower($extensao);
            // Cria um nome único para esta imagem
            $novoNome = md5(microtime()) . $extensao;
            
            // Concatena a pasta com o nome
            $destino = 'arquivos/produtos/' . $novoNome;
            
            // tenta mover o arquivo para o destino
            if (@move_uploaded_file($arquivo_tmp, $destino)) {
                $_FILES['foto']['name'] = null;
                    $salvar = $dao->cadastrar_foto_principal($_POST['referencia'], $novoNome);
            } else {
                echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
            }
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
                <span class="h5 color-success-600">Produto cadastrado com sucesso!</span>
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