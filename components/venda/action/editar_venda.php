<?php

if(isset($_POST['salvar'])){

    $dao = new VendaDAO();

    $id = $_POST['idvenda'];
    $CARRINHO = json_decode($_POST["edt_gk_carrinho"], true);

    if(isset($CARRINHO) && count($CARRINHO) > 0){

        $dao = new Venda_produtoDAO();
        $oldproducts = $dao->listar($id);
        $dao2 = new ProdutoDAO();
        for ($x=0; $x < count($oldproducts); $x++) { 
            $deduz = $dao2->aumentar_quantidade($oldproducts[$x]["id"],$oldproducts[$x]["tamanho"], $oldproducts[$x]["quantidade"]);
        }

        $dao->excluir($id);

        $venda_produto = new Venda_produto();
        $venda_produto->id_venda = ($id);
        $valor_compra = 0;

        for ($x = 0; $x < count($CARRINHO); $x++) {
            if($CARRINHO[$x]["id"] != '' && $CARRINHO[$x]["ref"] != '' && $CARRINHO[$x]["valor_venda"] != ''){
                $valor_compra += $CARRINHO[$x]["valor_compra"]*$CARRINHO[$x]["quantidade"];
                
                $venda_produto->id_produto = ($CARRINHO[$x]["id"]);
                $venda_produto->quantidade = ($CARRINHO[$x]["quantidade"]);
                $venda_produto->nome = ($CARRINHO[$x]["nome"]);
                $venda_produto->tamanho = ($CARRINHO[$x]["tamanho"]);
                $venda_produto->valor_unit = ($CARRINHO[$x]["valor_venda"]);
                $venda_produto->valor_total = ($CARRINHO[$x]["valor_venda"] * $CARRINHO[$x]["quantidade"]);
                $venda_produto->valor_compra = ($CARRINHO[$x]["valor_compra"] * $CARRINHO[$x]["quantidade"]);
                $gravou1 = $venda_produto->grava();
            }
        }
        
        $venda = new Venda();
        
        $valorexp = explode("$ ", $_POST['desconto']);
        $valor1 = str_replace('.', '', $valorexp[1]);
        $desconto = 100 * str_replace(',', '.', $valor1);
        
        $venda->id = ($id);
        $venda->valor = ($_POST['total']);
        $venda->valor_compra = $valor_compra;
        $venda->desconto = ($desconto);
        $venda->data = ($_POST['data']);
        $venda->user = ($_SESSION['username']);
        $venda->forma_pag = ($_POST['pagamento'] == 'diversos' ? '99' : $_POST['pagamento']);

        if($_POST['prevenda'] == 1){
            $pag = 0;
        }else{
            $pag = 1;
        }
       $venda->pag = ($pag);
        $venda->cliente = ($_POST['cliente']);
        $venda->vendedor = ($_POST['vendedor']);

        if($_POST['entrega'] == 1){
            $venda->entrega = (1);
            $venda->status = (0);
        }else{
            $venda->entrega = (0);
            $venda->status = (0);
        }
          
        if(isset($_POST['sociedade']) && $_POST['sociedade'] == 1){
            $venda->sociedade = (1);
        }else{
            $venda->sociedade = (0);
        }
        
        if(isset($_POST['prevenda']) && $_POST['prevenda'] == 1){
            $venda->prevenda = (1);
        }else{
            $venda->prevenda = (0);
        }

        if(isset($_POST['comissao']) && $_POST['comissao'] == 1){
            $venda->comissao = (1);
        }else{
            $venda->comissao = (0);
        }
        $venda->valor_comissao = ($_POST['total'] - $desconto) * $COMISSAO_PERCENT;
        
        
        
        
        $venda->endereco = ($_POST['endereco']);
        $venda->time = (date('Y-m-d H:i:s'));  
        
        $dao = new Venda_pagamentoDAO();
        $dao->excluir_todos($_POST['idvenda']);

        if($venda->prevenda == 0){
            if( $_POST['pagamento'] == ''){$_POST['pagamento'] = 96; }
            
            if($_POST['pagamento'] == 'diversos'){
                $pdao = new PagamentoDAO();
                $listaPagamento = $pdao->listar();
                for ($i=0; $i < count($listaPagamento); $i++) { 
                    $valor =  $_POST['valor_'.$listaPagamento[$i]['id']];

                    if($valor > 0){
                        $grava = $dao->cadastrar($_POST['idvenda'], $listaPagamento[$i]['id'], $valor);
                    } 
                }

                //PARCELADO
                $valor =  $_POST['valor_96'];
            
                if($valor > 0 || (count($_POST['parcela']) > 0 && $_POST['parcela'][0] != '$ 0,00')){
                    $ultimo_pagamento = $dao->getUltimo();

                    $pdao = new Pessoa_crediarioDAO();
                    $ultimo_crediario = $pdao->getUltimo();
                    $pdao->excluir($_POST['idvenda']);
                    
                    $grava = $pdao->cadastrar($_POST['cliente'], $_POST['idvenda'], $ultimo_pagamento['Auto_increment'], $valor, 1);

                    $grava = $dao->cadastrar($_POST['idvenda'], 96, $valor);

                    $z;
                    $pdao = new Pessoa_crediarioDAO();
                    if($_POST['id_crediario'][0] != ''){
                        $excluir = $pdao->excluir_parcelas($_POST['id_crediario'][0]);
                    }
                    // echo 1;
                    for ($z=0; $z < count($_POST['parcela']); $z++) { 
                        
                        $valorexp = explode("$ ", $_POST['parcela'][$z]);
                        $valor1 = str_replace('.', '', $valorexp[1]);
                        $valor = 100 * str_replace(',', '.', $valor1);
                        $vencimento = $_POST['vencimento'][$z];
                        $data_pag = $_POST['data_pag'][$z];
                        
                        if (isset($_POST['forma_pag'][$z]) != NULL) {
                            $forma_pag = $_POST['forma_pag'][$z];
                        } else {
                            $forma_pag = 0;
                        }

                        
                        if ($_POST['flag'][$z] != NULL) {
                            $flag = $_POST['flag'][$z];
                        } else {
                            $flag = 0;
                        }
                        // echo $ultimo_crediario['Auto_increment']. " ". $forma_pag . " ". $valor. " ". $vencimento. " ". $flag;

                        if($valor > 0){
                            $salvou = $pdao->salvarParcelasEditadas($ultimo_crediario['Auto_increment'], $forma_pag, $valor, $data_pag != '' ? $data_pag : $vencimento, $vencimento, $flag);
                        }
                        
                    }

                } 

            }elseif($_POST['pagamento'] == '96' || (count($_POST['parcela']) > 0 && $_POST['parcela'][0] != '$ 0,00')){
                $ultimo_pagamento = $dao->getUltimo();
                
                $pdao = new Pessoa_crediarioDAO();
                $pdao->excluir($_POST['idvenda']);
                $ultimo_crediario = $pdao->getUltimo();

                $grava = $pdao->cadastrar($_POST['cliente'], $_POST['idvenda'], $ultimo_pagamento['Auto_increment'], $_POST['total']-$desconto, $_POST['pagamento'] == '96' ? 1 : 0);

                $grava = $dao->cadastrar($_POST['idvenda'], $_POST['pagamento'], $_POST['total']-$desconto);

                $pdao = new Pessoa_crediarioDAO();
                if($_POST['id_crediario'][0] != ''){
                    // echo $_POST['id_crediario'][0];
                    $excluir = $pdao->excluir_parcelas($_POST['id_crediario'][0]);
                }
                // print_r($_POST['parcela']);
                for ($z=0; $z < count($_POST['parcela']); $z++) { 
                    // echo $_POST['parcela'][$z]." ";
                    $valorexp = explode("$ ", $_POST['parcela'][$z]);
                    $valor1 = str_replace('.', '', $valorexp[1]);
                    // echo 1;
                    $valor = 100 * str_replace(',', '.', $valor1);
                    $vencimento = $_POST['vencimento'][$z];
                    $data_pag = $_POST['data_pag'][$z];
                    
                    if (isset($_POST['forma_pag'][$z]) != NULL) {
                        $forma_pag = $_POST['forma_pag'][$z];
                    } else {
                        $forma_pag = 0;
                    }

                    
                    if ($_POST['flag'][$z] != NULL) {
                        $flag = $_POST['flag'][$z];
                    } else {
                        $flag = 0;
                    }
                    
                    if($valor > 0){
                        // echo $ultimo_crediario['Auto_increment']. " ". $forma_pag . " ". $valor. " ". $vencimento. " ". $flag."<br>";
                        $salvou = $pdao->salvarParcelasEditadas($ultimo_crediario['Auto_increment'], $forma_pag, $valor, $data_pag, $vencimento, $flag);
                    }
                    
                }

            }else{
                $grava = $dao->cadastrar($_POST['idvenda'], $_POST['pagamento'], $_POST['total']);
            }

        }

        if($venda->prevenda == 1){
            $venda->forma_pag = '';
        }

        $gravou = $venda->altera();
        
        if ($gravou) {
    
            $dao = new ProdutoDAO();
            for ($x = 0; $x < count($CARRINHO); $x++) {
                $deduz = $dao->deduzir_quantidade($CARRINHO[$x]["id"], $CARRINHO[$x]["tamanho"], $CARRINHO[$x]["quantidade"]);
            }
    
            ?>
            <script>
                 localStorage.setItem('edt_gk_carrinho', '');
            </script>
            <?php
                ?>
                    <meta http-equiv="refresh" content="0;URL=?dtlVenda=<?php echo $id; ?>"> 
                <?php

        }
    }

}
?>

