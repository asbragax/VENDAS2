<?php

class Conta_receita{
	private $id;
	private $id_reduzido;
	private $nome;
	private $dao = "Conta_receitaDAO";

	public function __construct(){
		$this->dao = new Conta_receitaDAO();
	}

	public function getId(){
		return $this->id;
	}

	public function setId( $id ){
		$this->id = $id;
	}

	public function getId_reduzido(){
		return $this->id_reduzido;
	}

	public function setId_reduzido($id_reduzido){
		$this->id_reduzido = $id_reduzido;
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
