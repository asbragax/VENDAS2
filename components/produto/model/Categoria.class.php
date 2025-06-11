<?php
class Categoria
{

    public string $id;
    public string $nome;
    public string $foto;


    private $dao = "CategoriaDAO";

    public function __construct()
    {
    }

    public function grava()
    {
        $dao = new CategoriaDAO();
        $gravou = $dao->cadastrar($this);
        return $gravou;

    }
}