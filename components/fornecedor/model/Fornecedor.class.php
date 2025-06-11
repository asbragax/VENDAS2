<?php
class Fornecedor
{

    private $id;
    private $nome;
    private $cnpj;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;

    private $dao = "FornecedorDAO";

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getCep()
	{
		return $this->cep;
	}

	public function setCep($cep)
	{
		$this->cep = $cep;
	}
	public function getRua()
	{
		return $this->rua;
	}

	public function setRua($rua)
	{
		$this->rua = $rua;
	}
	public function getNumero()
	{
		return $this->numero;
	}

	public function setNumero($numero)
	{
		$this->numero = $numero;
	}


	public function getComplemento()
	{
		return $this->complemento;
	}
	public function setComplemento($complemento)
	{
		$this->complemento = $complemento;
	}

	public function getBairro()
	{
		return $this->bairro;
	}

	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}

	public function getCidade()
	{
		return $this->cidade;
	}

	public function setCidade($cidade)
	{
		$this->cidade = $cidade;
	}

	public function getEstado()
	{
		return $this->estado;
	}

	public function setEstado($estado)
	{
		$this->estado = $estado;
    }
    
    public function grava()
    {
        $this->dao = new FornecedorDAO();
        $gravou = $this->dao->cadastrar($this);
        return $gravou;

    }
}