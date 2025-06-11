<?php
class Devolucao {

  public string $id;
  public string $id_auto;
  public string $fornecedor;
  public string $data;
  public string $tipo;
  public string $obs;
  public string $user;
  public string $time;
  public string $user_mod;
  public string $time_mod;
  
  private $dao = "DevolucaoDAO";

   function __construct() {
   }


  public function grava(){
		$this->dao = new DevolucaoDAO();
		$gravou = $this->dao->cadastrar($this);
		return $gravou;

	}

  public function altera(){
		$this->dao = new DevolucaoDAO();
		$gravou = $this->dao->alterar($this);
		return $gravou;

	}
}
?>
