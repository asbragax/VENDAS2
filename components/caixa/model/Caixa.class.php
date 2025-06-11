<?php

class Caixa{
	private $id;
	private $valor;
	private $mes;
	private $ano;

	private $dao = "CaixaDAO";

	public function __construct(){
		$this->dao = new CaixaDAO();
	}

	public function getId(){
		return $this->id;
	}

	public function setId( $id ){
		$this->id = $id;
	}

	public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}

	public function getMes(){
		return $this->mes;
	}

	public function setMes($mes){
		$this->mes = $mes;
	}

	public function getAno(){
		return $this->ano;
	}

	public function setAno($ano){
		$this->ano = $ano;
	}

	public function grava(){
		return $this->dao->cadastrar($this);
	}



}

?>
