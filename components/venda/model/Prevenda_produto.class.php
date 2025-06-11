<?php
class Prevenda_produto {

  public string $id;
  public string $id_venda;
  public string $id_produto;
  public string $quantidade;
  public string $nome;
  public string $tamanho;
  public string $valor_unit;
  public string $valor_total;
  public string $cor;


  private $dao = "Prevenda_produtoDAO";

   function __construct() {
   }


  public function grava(){
		$this->dao = new Prevenda_produtoDAO();
		$gravou = $this->dao->cadastrar($this);
		return $gravou;

	}
}
?>
