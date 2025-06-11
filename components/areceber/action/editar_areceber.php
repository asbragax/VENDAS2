<?php


if ( isset($_POST['edtReceber'])) {
	$areceber = new Areceber();
	$dao = new AreceberDAO();

	$valorexp = explode("$ ", $_POST['edt_valor']);
	$valor1 = str_replace( '.' ,'', $valorexp[1] );
	$valor =  100 * str_replace (',', '.', $valor1);

	$areceber->setId($_POST['edt_id']);
	$areceber->setNome($_POST['edt_referencia']);
	$areceber->setData($_POST['edt_data']);
	$areceber->setConta_credito($_POST['edt_conta_credito']);
	$areceber->setConta_debito($_POST['edt_conta_debito']);
	$areceber->setValor($valor);
	$areceber->setId_igreja($_POST['edt_ref_igreja']);

	if($_POST['edt_id_pessoa'] != '' || $_POST['edt_nome'] != ''){
		$areceber->setDizimo(1);
		if($_POST['edt_id_pessoa'] != ''){
			$areceber->setId_pessoa($_POST['edt_id_pessoa']);
		}elseif($_POST['edt_nome'] != ''){
			$pessoa = new Pessoa();
			$id = uniqidReal(35);
			$pessoa->setId($id);
			$pessoa->setNome($_POST['edt_nome']);
			$pessoa->setCpf($_POST['edt_cpf']);
			$pessoa->setEmail($_POST['edt_email']);
			$pessoa->setIgreja($_POST['edt_igreja']);
		
			$gravou = $pessoa->grava();

			$areceber->setId_pessoa($id);
		}
	}else{
		$areceber->setDizimo(0);
	}
	$gravou = $dao->alterar($areceber);
	// print_r($areceber);
	if ( $gravou ) {?>
		<div class="alert alert-info" role="alert">
		 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 Editado com <strong>sucesso!</strong> Recebimento: <?php echo $_POST['edt_valor']; ?>
		 </div>
		 <META HTTP-EQUIV="Refresh" Content="0;">
	 <?php
	}

}
?>
