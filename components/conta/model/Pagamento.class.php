<?php

class Pagamento{
	public int $id;
	public string $nome;
	public $dao = "PagamentoDAO";

	public function __construct(){
		$this->dao = new PagamentoDAO();
	}

	public function grava(){
		return $this->dao->cadastrar($this);
	}
	public function edita(){
		return $this->dao->alterar($this);
	}



}

?>
