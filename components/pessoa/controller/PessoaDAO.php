<?php

ini_set('display_errors', 0);
error_reporting(0);

class PessoaDAO
{

    private $dao;
    private $CLASS_NAME = "Pessoa";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function pegaTimeStamp()
	{
		return date('Y-m-d H:i:s');
    }
    
    public function cadastrar($pessoa)
    {

        $sql = "insert into pessoa( id, nome, sexo, apelido, data_nascimento, cpf, email, celular, 
        cep, rua, bairro, cidade, estado,
		numero, complemento, user, time)
        values ( :id, :nome, :sexo, :apelido, :data_nascimento, :cpf, :email, :celular, 
        :cep, :rua, :bairro, :cidade, :estado,
		:numero, :complemento, :user, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $pessoa->getId());
        $stmt->bindParam(":nome", $pessoa->getNome());
        $stmt->bindParam(":apelido", $pessoa->getApelido());
        $stmt->bindParam(":sexo", $pessoa->getSexo());
        $stmt->bindParam(":data_nascimento", $pessoa->getData_nascimento());
        $stmt->bindParam(":cpf", $pessoa->getCpf());
        $stmt->bindParam(":email", $pessoa->getEmail());
        $stmt->bindParam(":celular", $pessoa->getCelular());
        $stmt->bindParam(":cep", $pessoa->getCEP());
		$stmt->bindParam(":rua", $pessoa->getRua());
		$stmt->bindParam(":bairro", $pessoa->getBairro());
		$stmt->bindParam(":cidade", $pessoa->getCidade());
		$stmt->bindParam(":estado", $pessoa->getEstado());
		$stmt->bindParam(":numero", $pessoa->getNumero());
		$stmt->bindParam(":complemento", $pessoa->getComplemento());
		$stmt->bindParam(":user", $pessoa->getUser());
        $stmt->bindParam(":time", $this->pegaTimeStamp());
        // print_r($pessoa);
        $result = $stmt->execute();
        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function listar()
    {

        $sql = "select *, DATE_FORMAT(data_nascimento,'%d/%m/%Y') as dataf
					from pessoa
					order by nome";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    // public function listarDetails()
    // {

    //     $sql = "select p.*, i.nome as nome_igreja
    //                 from pessoa p
    //                 inner join igreja i on i.id = p.igreja
	// 				order by p.nome";

    //     $stmt = $this->dao->prepare($sql);
    //     $stmt->execute();

    //     $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     return $lista;
    // }

    public function getPorId($id)
    {

        $sql = "select * from pessoa where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetchObject($this->CLASS_NAME);

        return $pessoa;
    }

    public function getPorIdAssoc($id)
    {
        $sql = "select * from pessoa where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function getPorCpf($id)
    {
        $sql = "select * from pessoa where cpf = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function getPorIdDetails($id)
    {
        $sql = "select *, DATE_FORMAT(time,'%d/%m/%Y') as timef, DATE_FORMAT(data_nascimento,'%d/%m/%Y') as dataf
         from pessoa where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        
        $sql = "delete from pessoa where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function alterar($pessoa)
    {

        $sql = "update pessoa set 
        nome = :nome,
        sexo = :sexo,
        apelido = :apelido,
        data_nascimento = :data_nascimento,
        cpf = :cpf,
        email = :email,
        celular = :celular,
        cep = :cep,
        rua = :rua,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado,
        numero = :numero,
        complemento = :complemento,
        user_mod = :user_mod,
        time_mod = :time_mod
        where id = :id ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $pessoa->getId());
        $stmt->bindParam(":nome", $pessoa->getNome());
        $stmt->bindParam(":sexo", $pessoa->getSexo());
        $stmt->bindParam(":apelido", $pessoa->getApelido());
        $stmt->bindParam(":data_nascimento", $pessoa->getData_nascimento());
        $stmt->bindParam(":cpf", $pessoa->getCpf());
        $stmt->bindParam(":email", $pessoa->getEmail());
        $stmt->bindParam(":celular", $pessoa->getCelular());
        $stmt->bindParam(":cep", $pessoa->getCEP());
		$stmt->bindParam(":rua", $pessoa->getRua());
		$stmt->bindParam(":bairro", $pessoa->getBairro());
		$stmt->bindParam(":cidade", $pessoa->getCidade());
		$stmt->bindParam(":estado", $pessoa->getEstado());
		$stmt->bindParam(":numero", $pessoa->getNumero());
		$stmt->bindParam(":complemento", $pessoa->getComplemento());
		$stmt->bindParam(":user_mod", $pessoa->getUser_mod());
        $stmt->bindParam(":time_mod", $this->pegaTimeStamp());
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    
    public function aniversariantes_mes($mes)
    {
        $sql = "select
					p.*, c.nome as nome_cargo
				from
					pessoa p
				inner join
					cargo c on p.cargo = c.id
					where MONTH(p.data_nascimento) = :mes
				order by p.nome";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":mes", $mes);
        $result = $stmt->execute();

        $listaPessoa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaPessoa;
    }

    public function aniversariantes()
    {
        $sql = "select *
					from pessoa
						where MONTH(data_nascimento) = MONTH(NOW()) && DAY(data_nascimento) = DAY(NOW())";
        $stmt = $this->dao->query($sql);

        $listaPessoa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaPessoa;
    }

    public function aniversariantes_domingo($dataontem, $datahoje)
    {
        $sql = "select *
					from pessoa
                        where 
                        (MONTH(data_nascimento) = MONTH(:dataontem) && DAY(data_nascimento) = DAY(:dataontem))
                        || (MONTH(data_nascimento) = MONTH(:datahoje) && DAY(data_nascimento) = DAY(:datahoje))";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":dataontem", $dataontem);
        $stmt->bindParam(":datahoje", $datahoje);
        $result = $stmt->execute();

        $listaPessoa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaPessoa;
    }

}