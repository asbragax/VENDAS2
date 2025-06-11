<?php
class Produto
{

    public string $id;
    public string $referencia;
    public string $nome;
    public string $estoque;
    public string $valor_compra;
    public string $valor_venda;
    public string $valor_atacado;
    public string $gender;
    public string $categoria;
    public int $grade;
    public int $sociedade;
    public string $user;
    public string $time;
    public string $usermod;
    public string $timemod;

    private $dao = "ProdutoDAO";

    public function __construct()
    {
    }

    public function grava()
    {
        $dao = new ProdutoDAO();
        $gravou = $dao->cadastrar($this);
        return $gravou;

    }
}