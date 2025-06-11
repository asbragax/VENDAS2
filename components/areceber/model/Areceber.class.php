<?php

class Areceber{
	private $id;
	private $nome;
	private $valor;
	private $data;
	private $conta_credito;
	private $conta_debito;
	private $id_igreja;
	private $dizimo;
	private $id_pessoa;

	private $dao = "AreceberDAO";

	public function __construct(){
		$this->dao = new AreceberDAO();
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

	public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}

	public function getData(){
		return $this->data;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function getConta_credito(){
		return $this->conta_credito;
	}

	public function setConta_credito($conta_credito){
		$this->conta_credito = $conta_credito;
	}

	public function getConta_debito(){
		return $this->conta_debito;
	}

	public function setConta_debito($conta_debito){
		$this->conta_debito = $conta_debito;
	}

	public function getDizimo(){
		return $this->dizimo;
	}

	public function setDizimo($dizimo){
		$this->dizimo = $dizimo;
	}

	public function getId_pessoa(){
		return $this->id_pessoa;
	}

	public function setId_pessoa($id_pessoa){
		$this->id_pessoa = $id_pessoa;
	}

	public function getId_igreja(){
		return $this->id_igreja;
	}

	public function setId_igreja($id_igreja){
		$this->id_igreja = $id_igreja;
	}

	public function grava(){
		return $this->dao->cadastrar($this);
	}



}

?>
