<?php

if(isset($_POST['salvar'])){
    
        $dao = new VendaDAO();
        $ultimo = $dao->getUltimo();
        $CARRINHO = json_decode($_POST["gk_carrinho"], true);
        // print_r($CARRINHO);
        if(isset($CARRINHO) && count($CARRINHO) > 0){
            $venda_produto = new Venda_produto();
            $venda_produto->id_venda = ($ultimo['Auto_increment']);
            $valor_compra = 0;

            $daovp = new Venda_produtoDAO();
            $daovp->excluir($ultimo['Auto_increment']);
            
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
                    
                    // print_r($venda_produto);
                    // echo "<br><br><br>";
                    $gravou1 = $venda_produto->grava();
                }
            }
            
        // echo $valor_compra;
        // echo "<br><br><br>";
        $venda = new Venda();
        
        $valorexp = explode("$ ", $_POST['desconto']);
        $valor1 = str_replace('.', '', $valorexp[1]);
        $desconto = 100 * str_replace(',', '.', $valor1);
        
        $venda->valor = ($_POST['total']);
        $venda->valor_compra = $valor_compra > 0 ? $valor_compra : 0;
        $venda->desconto = ($desconto);
        $venda->data = $_POST['data'];
        $venda->user = $_SESSION['username'];
        $venda->forma_pag = ($_POST['pagamento'] == 'diversos' ? '99' : $_POST['pagamento']);
        if($_POST['prevenda'] == 1){
            $pag = 0;
        }else{
            $pag = 1;
        }
        $venda->pag = $pag;
        $venda->cliente = $_POST['cliente'];
        $venda->vendedor = $_POST['vendedor'];
        
        if(isset($_POST['entrega']) && $_POST['entrega'] == 1){
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

       
        
        $venda->endereco = $_POST['endereco'] != '' ? $_POST['endereco'] : '';
        $venda->time = date('Y-m-d H:i:s');

        if($venda->prevenda == 0 ){
            if( $_POST['pagamento'] == ''){$_POST['pagamento'] = '96'; }
 
            $dao = new Venda_pagamentoDAO();
            if($_POST['pagamento'] == 'diversos'){
                $pdao = new PagamentoDAO();
                $listaPagamento = $pdao->listar();
                for ($i=0; $i < count($listaPagamento); $i++) { 
                    $valor =  $_POST['valor_'.$listaPagamento[$i]['id']];
                    
                    if($valor > 0){
                        $grava = $dao->cadastrar($ultimo['Auto_increment'], $listaPagamento[$i]['id'], $valor);
                    } 
                }

                //PARCELADO
                $valor =  $_POST['valor_96'];
                
                if($valor > 0 || (count($_POST['parcela']) > 0 && $_POST['parcela'][0] != '$ 0,00')){
                    $ultimo_pagamento = $dao->getUltimo();
                    
                    $pdao = new Pessoa_crediarioDAO();
                    $ultimo_crediario = $pdao->getUltimo();
                    $grava = $pdao->cadastrar($_POST['cliente'], $ultimo['Auto_increment'], $ultimo_pagamento['Auto_increment'], $valor, 1);
                    
                    $grava = $dao->cadastrar($ultimo['Auto_increment'], 96, $valor);

                    $num = 1;
                    while ($num <= count($_POST['parcela'])) {
                        
                        $valorexp = explode("$ ", $_POST['parcela'][$num - 1]);
                        $valor1 = str_replace('.', '', $valorexp[1]);
                        $valor = 100 * str_replace(',', '.', $valor1);
                        $vencimento = $_POST['vencimento'][$num - 1];
                        
                        if($valor > 0){
                            $salvou = $pdao->cadastrar_pagamento($ultimo_crediario['Auto_increment'],$vencimento, 0, $valor, 0);
                        }

                        $num++;
                    }

                } 
            }elseif($_POST['pagamento'] == '96' || (count($_POST['parcela']) > 0 && $_POST['parcela'][0] != '$ 0,00')){
                $ultimo_pagamento = $dao->getUltimo();
                
                $pdao = new Pessoa_crediarioDAO();
                $ultimo_crediario = $pdao->getUltimo();
                $grava = $pdao->cadastrar($_POST['cliente'], $ultimo['Auto_increment'], $ultimo_pagamento['Auto_increment'], $_POST['total']-$desconto, 1);
               
                $grava = $dao->cadastrar($ultimo['Auto_increment'], $_POST['pagamento'], $_POST['total']-$desconto);


                for ($z=0; $z < count($_POST['parcela']); $z++) { 
                    
                    $valorexp = explode("$ ", $_POST['parcela'][$z]);
                    $valor1 = str_replace('.', '', $valorexp[1]);
                    $valor = 100 * str_replace(',', '.', $valor1);
                    $vencimento = $_POST['vencimento'][$z];
                    
                    if($valor > 0){
                        $salvou = $pdao->cadastrar_pagamento($ultimo_crediario['Auto_increment'],$vencimento, 0, $valor, 0);
                    }
                }
                

            }else{
                $grava = $dao->cadastrar($ultimo['Auto_increment'], $_POST['pagamento'], $_POST['total']-$desconto);
            }
        }

        if($venda->prevenda == 1){
            $venda->forma_pag = '';
        }
        
        // print_r($venda);
        $gravou = $venda->grava();
        // $gravou = 1;
        
        if ($gravou) {
    
            $dao = new ProdutoDAO();
            for ($x = 0; $x < count($CARRINHO); $x++) {
                $deduz = $dao->deduzir_quantidade($CARRINHO[$x]["id"], $CARRINHO[$x]["tamanho"], $CARRINHO[$x]["quantidade"]);
            }
             ?>
             <script>
                localStorage.setItem('gk_carrinho', '');
             </script>
             <?php
                ?>
                   <meta http-equiv="refresh" content="0;URL=?dtlVenda=<?php echo $ultimo['Auto_increment']; ?>">
             <?php

          }
    }

}
?>

