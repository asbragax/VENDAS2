<?php


if ( isset($_POST['cadReceber'])) {
	$areceber = new Areceber();


	$valorexp = explode("$ ", $_POST['valor']);
	$valor1 = str_replace( '.' ,'', $valorexp[1] );
	$valor =  100 * str_replace (',', '.', $valor1);

	$areceber->setNome($_POST['referencia']);
	$areceber->setData($_POST['data']);
	$areceber->setConta_credito($_POST['conta_credito']);
	$areceber->setConta_debito($_POST['conta_debito']);
	$areceber->setValor($valor);
	$areceber->setId_igreja($_POST['ref_igreja']);

	if($_POST['id_pessoa'] != '' || $_POST['nome'] != ''){
		$areceber->setDizimo(1);
		if($_POST['id_pessoa'] != ''){
			$areceber->setId_pessoa($_POST['id_pessoa']);
		}elseif($_POST['nome'] != ''){
			$pessoa = new Pessoa();
			$id = uniqidReal(35);
			$pessoa->setId($id);
			$pessoa->setNome($_POST['nome']);
			$pessoa->setCpf($_POST['cpf']);
			$pessoa->setEmail($_POST['email']);
			$pessoa->setIgreja($_POST['igreja']);
		
			$gravou = $pessoa->grava();

			$areceber->setId_pessoa($id);
		}
	}else{
		$areceber->setDizimo(0);
	}
	$gravou = $areceber->grava();
	// print_r($areceber);
	if ( $gravou ) {?>
		<div class="alert alert-info" role="alert">
		 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 Cadastrado com <strong>sucesso!</strong> Recebimento: <?php echo $_POST['valor']; ?>
		 </div>
		 <META HTTP-EQUIV="Refresh" Content="0;">
	 <?php
	}

}
?>
