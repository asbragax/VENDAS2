<?php


if (isset($_POST['edtPagar'])) {
	// echo 1;
	$dao = new ApagarDAO();
	$oldapagar = $dao->getPorId($_POST['edt_id_apagar']);
	$edt_data = $_POST['edt_data'];
	
	
	$valorexp = explode("$ ", $_POST['edt_valor']);
	$valor1 = str_replace( '.' ,'', $valorexp[1] );
	$valor =  100 * str_replace (',', '.', $valor1);
	
	
	$apagar = new Apagar();
	$apagar->setId($_POST['edt_id_apagar']);
	$apagar->setValor($valor);
	$apagar->setForma_pag($_POST['edt_forma_pag']);
	$apagar->setFornecedor($_POST['edt_fornecedor']);


	$apagar->setNome($_POST['edt_referencia_apagar']);

	$apagar->setData($edt_data);
	$apagar->setPrestacao($_POST['edt_prestacao']);
	$apagar->setValorPrestacao($valor/$_POST['edt_prestacao']);
	
	if (isset($_FILES['edt_arquivo_nota']['tmp_name']) && $_FILES["edt_arquivo_nota"]["error"] == 0) {
		$arquivo_tmp = $_FILES['edt_arquivo_nota']['tmp_name'];
		$nome = $_FILES['edt_arquivo_nota']['name'];
		
		// Pega a extensao
		$extensao = strrchr($nome, '.');
		// Converte a extensao para mimusculo
		$extensao = strtolower($extensao);
		// Somente imagens, .jpg;.jpeg;.gif;.png
		if (strstr('.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx', strtolower($extensao))) {
			// Cria um nome único para esta imagem
			$novoNome = md5(microtime()) . $extensao;
			
			// Concatena a pasta com o nome
			$destino = 'arquivos/notas/' . $novoNome;
			
			// tenta mover o arquivo para o destino
			if (@move_uploaded_file($arquivo_tmp, $destino)) {
				$_FILES['edt_arquivo_nota']['name'] = null;
			} else {
				echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
			}
		} else {
			echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		unlink('arquivos/notas/'.$oldapagar['arquivo_nota']);
		$apagar->setArquivo_nota($novoNome);
	}else{
		$apagar->setArquivo_nota($oldapagar['arquivo_nota']);
	}
	
	if (isset($_FILES['edt_arquivo_boleto']['tmp_name']) && $_FILES["edt_arquivo_boleto"]["error"] == 0) {
		$arquivo_tmp = $_FILES['edt_arquivo_boleto']['tmp_name'];
		$nome = $_FILES['edt_arquivo_boleto']['name'];
		
		// Pega a extensao
		$extensao = strrchr($nome, '.');
		// Converte a extensao para mimusculo
		$extensao = strtolower($extensao);
		// Somente imagens, .jpg;.jpeg;.gif;.png
		if (strstr('.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx', strtolower($extensao))) {
			// Cria um nome único para esta imagem
			$novoNome = md5(microtime()) . $extensao;
			
			// Concatena a pasta com o nome
			$destino = 'arquivos/boletos/' . $novoNome;
			
			// tenta mover o arquivo para o destino
			if (@move_uploaded_file($arquivo_tmp, $destino)) {
				$_FILES['edt_arquivo_boleto']['name'] = null;
			} else {
				echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
			}
		} else {
			echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		unlink('arquivos/boletos/'.$oldapagar['arquivo_boleto']);
		$apagar->setArquivo_boleto($novoNome);
	}else{
		$apagar->setArquivo_boleto($oldapagar['arquivo_boleto']);
	}
	
	if (isset($_FILES['edt_arquivo_recibo']['tmp_name']) && $_FILES["edt_arquivo_recibo"]["error"] == 0) {
		$arquivo_tmp = $_FILES['edt_arquivo_recibo']['tmp_name'];
		$nome = $_FILES['edt_arquivo_recibo']['name'];
		
		// Pega a extensao
		$extensao = strrchr($nome, '.');
		// Converte a extensao para mimusculo
		$extensao = strtolower($extensao);
		// Somente imagens, .jpg;.jpeg;.gif;.png
		if (strstr('.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx', strtolower($extensao))) {
			// Cria um nome único para esta imagem
			$novoNome = md5(microtime()) . $extensao;
			
			// Concatena a pasta com o nome
			$destino = 'arquivos/recibos/' . $novoNome;
			
			// tenta mover o arquivo para o destino
			if (@move_uploaded_file($arquivo_tmp, $destino)) {
				$_FILES['edt_arquivo_recibo']['name'] = null;
			} else {
				echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
			}
		} else {
			echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		unlink('arquivos/recibos/'.$oldapagar['arquivo_recibo']);
		$apagar->setArquivo_recibo($novoNome);
	}else{
		$apagar->setArquivo_recibo($oldapagar['arquivo_recibo']);
	}
	
	$apagar->setVencimento($edt_data);
	if($_POST['edt_paga'] == 1){
		$apagar->setData_pag($edt_data);
		$apagar->setStatus(1);
		
		$gravou = $dao->alterar($apagar);
	}else{
		$apagar->setData_pag($edt_data);
		$apagar->setStatus(0);
		$gravou = $dao->alterar($apagar);
	}
	
	if($_POST['edt_forma_pag'] == 2){
		for($x = 0; $x < $_POST['edt_prestacao']; $x++)
		{
			$valorexp = explode("$ ", $_POST['valor'.$x]);
			$valor1 = str_replace( '.' ,'', $valorexp[1] );
			$valor =  100 * str_replace (',', '.', $valor1);

			
			$gravou = $dao->alterar_prestacao(
				$_POST['edt_id_apagar_prestacao'.$x], 
				$_POST['edt_id_apagar'], 
				$x, $valor, 
				$_POST['vencimento'.$x], 
				$_POST['edt_status_apagar_prestacao'.$x]
			);
		}
	}
	
	

	if ( $gravou ) {?>
		<div class="alert alert-info" role="alert">
		 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 Editado com <strong>sucesso!</strong> Conta a pagar: <?php echo $_POST['valor']; ?>
		 </div>
		 <META HTTP-EQUIV="Refresh" Content="0;">
	 <?php
	}

}
?>
