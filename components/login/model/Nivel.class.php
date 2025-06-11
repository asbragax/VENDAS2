<?php

class Nivel{
	private $id;
	private $nome;

	private $dao = "NivelDAO";

	public function __construct(){
		$this->dao = new NivelDAO();
	}

	public function getId(){
		return $this->id;
	}

	public function setId( $id ){
		$this->id = $id;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function grava(){
		return $this->dao->cadastrar($this);
	}
}

?>
