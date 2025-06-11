<?php

class Categoria{
	private $id;
	private $cc;
	private $cc_reduzido;
	private $nome;
	private $grupo;

	private $dao = "CategoriaDAO";

	public function __construct(){
		$this->dao = new CategoriaDAO();
	}

	public function getId(){
		return $this->id;
	}

	public function setId( $id ){
		$this->id = $id;
	}

	public function getCc(){
		return $this->cc;
	}

	public function setCc($cc){
		$this->cc = $cc;
	}

	public function getCc_reduzido(){
		return $this->cc_reduzido;
	}

	public function setCc_reduzido($cc_reduzido){
		$this->cc_reduzido = $cc_reduzido;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getGrupo(){
		return $this->grupo;
	}

	public function setGrupo($grupo){
		$this->grupo = $grupo;
	}


	public function grava(){
		return $this->dao->cadastrar($this);
	}



}

?>
