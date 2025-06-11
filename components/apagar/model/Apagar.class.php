<?php

class Apagar{
	private $id;
	private $valor;
	private $data;
	private $vencimento;
	private $data_pag;
	private $forma_pag;
	private $tipo_pag;
	private $conta_pag;
	private $status;
	private $nome;
	private $prestacao;
	private $fornecedor;
	private $valorPrestacao;
	private $arquivo_nota;
	private $arquivo_boleto;
	private $arquivo_recibo;


	private $dao = "ApagarDAO";

	public function __construct(){
		$this->dao = new ApagarDAO();
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

	public function getFornecedor(){
		return $this->fornecedor;
	}

	public function setFornecedor($fornecedor){
		$this->fornecedor = $fornecedor;
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

	public function getPrestacao(){
		return $this->prestacao;
	}

	public function setPrestacao($prestacao){
		$this->prestacao = $prestacao;
	}

	public function getVencimento(){
		return $this->vencimento;
	}

	public function setVencimento($vencimento){
		$this->vencimento = $vencimento;
	}

	// public function getNumPrestacao(){
	// 	return $this->numPrestacao;
	// }

	// public function setNumPrestacao($numPrestacao){
	// 	$this->numPrestacao = $numPrestacao;
	// }

	public function getValorPrestacao(){
		return $this->valorPrestacao;
	}

	public function setValorPrestacao($valorPrestacao){
		$this->valorPrestacao = $valorPrestacao;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getData_pag(){
		return $this->data_pag;
	}

	public function setData_pag($data_pag){
		$this->data_pag = $data_pag;
	}

	public function getForma_pag(){
		return $this->forma_pag;
	}

	public function setForma_pag($forma_pag){
		$this->forma_pag = $forma_pag;
	}
	
	public function getConta_pag(){
		return $this->conta_pag;
	}

	public function setConta_pag($conta_pag){
		$this->conta_pag = $conta_pag;
	}

	public function getTipo_pag(){
		return $this->tipo_pag;
	}

	public function setTipo_pag($tipo_pag){
		$this->tipo_pag = $tipo_pag;
	}

	public function getArquivo_nota(){
		return $this->arquivo_nota;
	}

	public function setArquivo_nota($arquivo_nota){
		$this->arquivo_nota = $arquivo_nota;
	}

	public function getArquivo_boleto(){
		return $this->arquivo_boleto;
	}

	public function setArquivo_boleto($arquivo_boleto){
		$this->arquivo_boleto = $arquivo_boleto;
	}

	public function getArquivo_recibo(){
		return $this->arquivo_recibo;
	}

	public function setArquivo_recibo($arquivo_recibo){
		$this->arquivo_recibo = $arquivo_recibo;
	}

	public function grava(){
		return $this->dao->cadastrar($this);
	}
	public function grava_paga(){
		return $this->dao->cadastrar_paga($this);
	}


}

?>
