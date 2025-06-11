<?php
class Nota {

  public string $id;
  public string $id_auto;
  public string $valor;
  public string $fornecedor;
  public string $numero;
  public string $data;
  public string $obs;
  public string $arquivo;
  public string $flag;

  public string $user;
  public string $time;
  public string $user_mod;
  public string $time_mod;
  
  private $dao = "NotaDAO";

   function __construct() {
   }


  public function grava(){
		$this->dao = new NotaDAO();
		$gravou = $this->dao->cadastrar($this);
		return $gravou;

	}

  public function altera(){
		$this->dao = new NotaDAO();
		$gravou = $this->dao->alterar($this);
		return $gravou;

	}
}
?>
