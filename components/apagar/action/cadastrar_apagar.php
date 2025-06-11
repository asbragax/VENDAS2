<?php


if (isset($_POST['cadPagar'])) {
	
	if(isset($_POST['data']) && $_POST['data'] != '0000-00-00'){
		$data = $_POST['data'];
	}else{
		$data = date('Y-m-d');
	}
	
	$valorexp = explode("$ ", $_POST['valor']);
	$valor1 = str_replace( '.' ,'', $valorexp[1] );
	$valor =  100 * str_replace (',', '.', $valor1);
	
	
	$apagar = new Apagar();
	$apagar->setValor($valor);
	$apagar->setForma_pag($_POST['forma_pag']);
	$apagar->setFornecedor($_POST['fornecedor']);
	$apagar->setNome($_POST['referencia_apagar']);
	$apagar->setData($data);
	$apagar->setPrestacao($_POST['prestacao']);
	$apagar->setValorPrestacao($valor/$_POST['prestacao']);

	if (isset($_FILES['arquivo_nota']['tmp_name']) && $_FILES["arquivo_nota"]["error"] == 0) {
		$arquivo_tmp = $_FILES['arquivo_nota']['tmp_name'];
		$nome = $_FILES['arquivo_nota']['name'];
	
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
			$_FILES['arquivo_nota']['name'] = null;
		  } else {
			echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
		  }
		} else {
		  echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		$apagar->setArquivo_nota($novoNome);
	}

	if (isset($_FILES['arquivo_boleto']['tmp_name']) && $_FILES["arquivo_boleto"]["error"] == 0) {
		$arquivo_tmp = $_FILES['arquivo_boleto']['tmp_name'];
		$nome = $_FILES['arquivo_boleto']['name'];
	
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
			$_FILES['arquivo_boleto']['name'] = null;
		  } else {
			echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
		  }
		} else {
		  echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		$apagar->setArquivo_boleto($novoNome);
	}

	if (isset($_FILES['arquivo_recibo']['tmp_name']) && $_FILES["arquivo_recibo"]["error"] == 0) {
		$arquivo_tmp = $_FILES['arquivo_recibo']['tmp_name'];
		$nome = $_FILES['arquivo_recibo']['name'];
	
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
			$_FILES['arquivo_recibo']['name'] = null;
		  } else {
			echo "<script type='text/javascript'>alert('Não foi possível gravar o arquivo enviado, verifique se o arquivo esta no padrão esperado!');</script>";
		  }
		} else {
		  echo "<script type='text/javascript'>alert('Arquivo com extensão inválida. Extensão permitida: .jpg, .jpeg e .png ');</script>";
		}
		$apagar->setArquivo_recibo($novoNome);
	}

	$apagar->setVencimento($data);
	if($_POST['paga'] == 1 || $_POST['forma_pag'] == 1){
		$apagar->setData_pag($data);
		
		$apagar->setConta_pag($_POST['conta_pag']);
		$gravou = $apagar->grava_paga();
	}else{
		$gravou = $apagar->grava();
	}

	if($_POST['forma_pag'] == 2){
		$dao = new ApagarDAO();
		$ultimo = $dao->getUltimo();

		for($x = 0; $x < $_POST['prestacao']; $x++)
		{
			$valorexp = explode("$ ", $_POST['valor'.$x]);
			$valor1 = str_replace( '.' ,'', $valorexp[1] );
			$valor =  100 * str_replace (',', '.', $valor1);

			$gravou = $dao->cadastrar_parcela(($ultimo['Auto_increment']-1), $x, $valor, $_POST['vencimento'.$x]);
		}
	}

	

	if ( $gravou ) {?>
		<div class="alert alert-info" role="alert">
		 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 Cadastrado com <strong>sucesso!</strong> Conta a pagar: <?php echo $_POST['valor']; ?>
		 </div>
		 <META HTTP-EQUIV="Refresh" Content="0;">
	 <?php
	}

}
?>
