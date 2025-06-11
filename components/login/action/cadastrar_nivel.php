<?php

if ( isset($_POST['nome']) ) {

	$nivel = new Nivel();

	$nivel->setNome($_POST['nome']);
	$nivel->setId($_POST['id']);

	$gravou = $nivel->grava();

	?>
	<meta http-equiv="refresh" content="0; url=?consNivel"><?php


}

?>
