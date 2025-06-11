<?php

if ( isset($_POST['nome']) ) {

	$nivel = new Nivel();

	$nivel->setNome($_POST['nome']);
	$nivel->setId($_POST['id']);

	$dao = new NivelDAO();
	$gravar = $dao->alterar($nivel, $_POST['oldid']);

if($gravar){
	?>
	<meta http-equiv="refresh" content="0; url=?consNivel"><?php


}

}
?>
