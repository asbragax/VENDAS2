<?php

ini_set('display_errors', 0);
error_reporting(0);

class DevolucaoDAO
{

    private $dao;
    private $CLASS_NAME = "Devolucao";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($devolucao)
    {       
        $sql = "insert into devolucao( id, tipo, fornecedor, data, obs, user, time)
        values ( :id, :tipo, :fornecedor, :data, :obs, :user, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $devolucao->id);
        $stmt->bindParam(":tipo", $devolucao->tipo);
        $stmt->bindParam(":fornecedor", $devolucao->fornecedor);
        $stmt->bindParam(":data", $devolucao->data);
        $stmt->bindParam(":obs", $devolucao->obs);
        $stmt->bindParam(":user", $devolucao->user);
        $stmt->bindParam(":time", $devolucao->time);
        // print_r($devolucao);
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

        $sql = "select * from devolucao 
					order by id_auto DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarDetails()
    {

        $sql = "select n.*, DATE_FORMAT(n.data,'%d/%m/%Y') as dataf, f.nome as nome_fornecedor, f.cnpj
                    from devolucao n
                    inner join fornecedor f on f.id = n.fornecedor
					order by id_auto DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
    public function alterar($devolucao)
    {       
        $sql = "update devolucao set
        tipo = :tipo, 
        fornecedor = :fornecedor, 
        data = :data, 
        obs = :obs, 
        user_mod = :user, 
        time_mod = :time
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $devolucao->id);
        $stmt->bindParam(":tipo", $devolucao->tipo);
        $stmt->bindParam(":fornecedor", $devolucao->fornecedor);
        $stmt->bindParam(":data", $devolucao->data);
        $stmt->bindParam(":obs", $devolucao->obs);
        $stmt->bindParam(":user", $devolucao->user);
        $stmt->bindParam(":time", $devolucao->time);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }


    public function getPorId($id)
    {

        $sql = "select * from devolucao where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $devolucao = $stmt->fetchObject($this->CLASS_NAME);

        return $devolucao;
    }

    public function getPorIdAssoc($id)
    {

        $sql = "select * from devolucao where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $devolucao = $stmt->fetch(PDO::FETCH_ASSOC);

        return $devolucao;
    }

    public function getPorIdDetails($id)
    {

        $sql = "select n.*, f.nome, f.cnpj, DATE_FORMAT(n.data,'%d/%m/%Y') as dataf
        from devolucao n
        left join fornecedor f on f.id = n.fornecedor 
        where n.id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $devolucao = $stmt->fetch(PDO::FETCH_ASSOC);

        return $devolucao;
    }

    public function getUltimo()
    {

        $sql = "show table status like 'devolucao'";
        $stmt = $this->dao->query($sql);

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from devolucao where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}