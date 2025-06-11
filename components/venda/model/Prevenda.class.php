<?php
class Prevenda {

  public string $id;
  public string $valor;
  public string $valor_compra;
  public string $data;
  public string $forma_pag;
  public string $pag;
  public string $desconto;
  public string $cliente;
  public string $vendedor;
  public string $entrega;
  public string $comissao;
  public string $valor_comissao;
  public string $endereco;
  public string $prevenda;
  public string $status;
  public string $filial;
  public string $user;
  public string $time;
  public string $user_mod;
  public string $time_mod;

  
  private $dao = "PrevendaDAO";

  function __construct() {
  }


  public function grava(){
		$this->dao = new PrevendaDAO();
		$gravou = $this->dao->cadastrar($this);
		return $gravou;

	}
}
?>
