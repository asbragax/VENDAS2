<?php

      if ( isset($_POST['salvar']) ) {
        $subcategoria = new Subcategoria();

        $subcategoria->setNome($_POST['nome']);       

        $gravou = $subcategoria->grava();


    }
  ?>