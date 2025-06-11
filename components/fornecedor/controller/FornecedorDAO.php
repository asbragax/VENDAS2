<?php

ini_set('display_errors', 0);
error_reporting(0);

class FornecedorDAO
{

    private $dao;
    private $CLASS_NAME = "Fornecedor";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($fornecedor)
    {

        $sql = "insert into fornecedor( nome, cnpj, cep, rua, numero, complemento, bairro, cidade, estado)
        values ( :nome, :cnpj, :cep, :rua, :numero, :complemento, :bairro, :cidade, :estado)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":nome", $fornecedor->getNome());
        $stmt->bindParam(":cnpj", $fornecedor->getCnpj());
        $stmt->bindParam(":cep", $fornecedor->getCep());
        $stmt->bindParam(":rua", $fornecedor->getRua());
        $stmt->bindParam(":numero", $fornecedor->getNumero());
        $stmt->bindParam(":complemento", $fornecedor->getComplemento());
        $stmt->bindParam(":bairro", $fornecedor->getBairro());
        $stmt->bindParam(":cidade", $fornecedor->getCidade());
        $stmt->bindParam(":estado", $fornecedor->getEstado());

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

        $sql = "select *
					from fornecedor
					order by nome";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function getPorId($id)
    {

        $sql = "select * from fornecedor where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetchObject($this->CLASS_NAME);

        return $pessoa;
    }

    public function getPorIdAssoc($id)
    {
        $sql = "select * from fornecedor where id = :id ";

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
        
        $sql = "delete from fornecedor where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function alterar($fornecedor)
    {

        $sql = "update fornecedor set 
        nome = :nome,
        cnpj = :cnpj,
        cep = :cep,
        rua = :rua,
        numero = :numero,
        complemento = :complemento,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado
        where id = :id ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $fornecedor->getId());
        $stmt->bindParam(":nome", $fornecedor->getNome());
        $stmt->bindParam(":cnpj", $fornecedor->getCnpj());
        $stmt->bindParam(":cep", $fornecedor->getCep());
        $stmt->bindParam(":rua", $fornecedor->getRua());
        $stmt->bindParam(":numero", $fornecedor->getNumero());
        $stmt->bindParam(":complemento", $fornecedor->getComplemento());
        $stmt->bindParam(":bairro", $fornecedor->getBairro());
        $stmt->bindParam(":cidade", $fornecedor->getCidade());
        $stmt->bindParam(":estado", $fornecedor->getEstado());
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

}