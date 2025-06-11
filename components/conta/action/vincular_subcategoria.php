<?php

      if ( isset($_POST['salvar']) ) {
        $dao = new SubcategoriaDAO();
        
        if($_POST['novasub'] != ''){
          
          $subcategoria = new Subcategoria();
          $ultimo = $dao->getUltimo();
          
          $subcategoria->setNome($_POST['novasub']);       
          echo $_POST['novasub'];
          $subcategoria->grava();
          // print_r( $subcategoria);

          $gravou = $dao->vincular_categoria($_POST['id'], $ultimo['Auto_increment']);
        }elseif($_POST['id_sub'] > 0){
          $gravou = $dao->vincular_categoria($_POST['id'], $_POST['id_sub']);
        }


    }
  ?>