<?php
class Pessoa
{

    private $id;
    private $nome;
    private $sexo;
    private $apelido;
    private $data_nascimento;
    private $cpf;
    private $email;
    private $celular;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $user;
    private $time;
    private $user_mod;
    private $time_mod;
    private $id_auto;

    private $dao = "PessoaDAO";

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

    public function getData_nascimento(){
        return $this->data_nascimento;
    }

    public function setData_nascimento($data_nascimento){
        $this->data_nascimento = $data_nascimento;
	}
	
    public function getApelido()
    {
        return $this->apelido;
    }

    public function setApelido($apelido)
    {
        $this->apelido = $apelido;
    }
	
    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCelular()
	{
		return $this->celular;
	}

	public function setCelular($celular)
	{
		$this->celular = $celular;
	}
	
    public function getCEP()
	{
		return $this->cep;
	}

	public function setCEP($cep)
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
    
    public function getUser()
	{
		return $this->user;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function getUser_mod()
	{
		return $this->user_mod;
	}

	public function setUser_mod($user_mod)
	{
		$this->user_mod = $user_mod;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function setTime($time)
	{
		$this->time = $time;
    }
    
	public function getTime_mod()
	{
		return $this->time_mod;
	}

	public function setTime_mod($time_mod)
	{
		$this->time_mod = $time_mod;
    }
    
	public function getId_auto()
	{
		return $this->id_auto;
	}

	public function setId_auto($id_auto)
	{
		$this->id_auto = $id_auto;
    }
    
    public function grava()
    {
        $this->dao = new PessoaDAO();
        $gravou = $this->dao->cadastrar($this);
        return $gravou;

    }
}