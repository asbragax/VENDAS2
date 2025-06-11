<?php
class Devolucao_produto {

  public string $id;
  public string $id_nota;
  public string $id_produto;
  public string $nome;
  public string $valor;
  public string $quantidade;
  public string $grade;


  
  private $dao = "Devolucao_produtoDAO";

   function __construct() {
   }


  public function grava(){
		$this->dao = new Devolucao_produtoDAO();
		$gravou = $this->dao->cadastrar($this);
		return $gravou;

	}
}
?>
