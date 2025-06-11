<?php

if(isset($_POST['gk_site_carrinho'])){
    
        $dao = new PrevendaDAO();
        $id_venda = uniqidReal(60);
        $CARRINHO = json_decode($_POST["gk_site_carrinho"], true);
        // print_r($CARRINHO);
        if(isset($CARRINHO) && count($CARRINHO) > 0){

            $venda = new Prevenda();
            $dao = new PessoaDAO();
            
            $pessoa = $dao->getPorCpf($_POST['cpf']);
            if($pessoa['cpf'] == $_POST['cpf']){
                $venda->cliente = $pessoa['id'];
                // echo 1;
            }else{
                $pessoa = new Pessoa();
                $pessoa->setId(uniqidReal(35));
                $pessoa->setNome($_POST['nome']);
                $pessoa->setApelido('');
                $pessoa->setSexo('f');
                $pessoa->setData_nascimento('0000-00-00');
                $pessoa->setCpf($_POST['cpf']);
                $pessoa->setEmail($_POST['email']);
                $pessoa->setCelular($_POST['celular']);
                $pessoa->setCEP($_POST['cep']);
                $pessoa->setRua($_POST['rua']);
                $pessoa->setNumero($_POST['numero']);
                $pessoa->setComplemento($_POST['complemento']);
                $pessoa->setBairro($_POST['bairro']);
                $pessoa->setCidade($_POST['cidade']);
                $pessoa->setEstado('MG');
                $pessoa->setUser($OWNER_ID);
                
                $gravou = $pessoa->grava();
                
                $venda->cliente = $pessoa->getId();
            }
            
            
            
            


            $venda_produto = new Prevenda_produto();
            $venda_produto->id_venda = $id_venda;
            $valor_compra = 0;
            
            for ($x = 0; $x < count($CARRINHO); $x++) {
                if($CARRINHO[$x]["id"] != '' && $CARRINHO[$x]["ref"] != '' && $CARRINHO[$x]["valor"] != ''){

                    // $valor_compra += $CARRINHO[$x]["valor_compra"]*$CARRINHO[$x]["quantidade"];
                    
                    $venda_produto->id_produto = ($CARRINHO[$x]["id"]);
                    $venda_produto->quantidade = ($CARRINHO[$x]["quantidade"]);
                    $venda_produto->nome = ($CARRINHO[$x]["nome"]);
                    $venda_produto->tamanho = ($CARRINHO[$x]["tamanho"]);
                    $venda_produto->valor_unit = ($CARRINHO[$x]["valor"]);
                    $venda_produto->valor_total = ($CARRINHO[$x]["valor"] * $CARRINHO[$x]["quantidade"]);
                    $venda_produto->cor = $CARRINHO[$x]["cor"];
                    
                    // print_r($venda_produto);
                    // echo "<br><br><br>";
                    $gravou1 = $venda_produto->grava();
                }
            }
            
        // echo $valor_compra;
        // echo "<br><br><br>";
        
        // $valorexp = explode("$ ", $_POST['desconto']);
        // $valor1 = str_replace('.', '', $valorexp[1]);
        // $desconto = 100 * str_replace(',', '.', $valor1);
        
        // echo 1;
        $venda->id = $id_venda;
        $venda->valor = ($_POST['total']);
        $venda->valor_compra = $valor_compra > 0 ? $valor_compra : 0;
        $venda->desconto = 0;
        $venda->data = date('Y-m-d');
        $venda->user = $OWNER_ID;
        // $venda->forma_pag = ($_POST['pagamento'] == 'diversos' ? '99' : $_POST['pagamento']);
        // if($_POST['prevenda'] == 1){
        //     $pag = 0;
        // }else{
        //     $pag = 1;
        // }
        // $venda->pag = $pag;
        $venda->vendedor = $_POST['vendedor'];
        // echo 2;
        
        // if(isset($_POST['entrega']) && $_POST['entrega'] == 1){
        //     $venda->entrega = (1);
        //     $venda->status = (0);
        // }else{
        //     $venda->entrega = (0);
        //     $venda->status = (0);
        // }
        
        // if(isset($_POST['prevenda']) && $_POST['prevenda'] == 1){
        //     $venda->prevenda = (1);
        // }else{
        //     $venda->prevenda = (0);
        // }

        if($_POST['vendedor'] != $OWNER_ID){
            $venda->comissao = 1;
        }else{
            $venda->comissao = 0;
        }
        $venda->valor_comissao = ($_POST['total'] - $desconto) * $COMISSAO_PERCENT;
        
        $venda->endereco = $_POST['obs'] != '' ? $_POST['obs'] : '';
        $venda->time = date('Y-m-d H:i:s');
        
        
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
                localStorage.setItem('gk_site_carrinho', '');
             </script>
             <?php
                ?>
                   <meta http-equiv="refresh" content="0;URL=index.php">
             <?php

          }
    }

}
?>

