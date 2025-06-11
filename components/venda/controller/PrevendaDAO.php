<?php

ini_set('display_errors', 0);
error_reporting(0);

class PrevendaDAO
{

    private $dao;
    private $CLASS_NAME = "Prevenda";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($prevenda)
    {       
        $sql = "insert into prevenda( id, valor, desconto, data, endereco, valor_compra, cliente, vendedor, comissao, valor_comissao, user, time)
        values ( :id, :valor, :desconto, :data, :endereco, :valor_compra, :cliente, :vendedor, :comissao, :valor_comissao, :user, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $prevenda->id);
        $stmt->bindParam(":valor", $prevenda->valor);
        $stmt->bindParam(":desconto", $prevenda->desconto);
        $stmt->bindParam(":data", $prevenda->data);
        // $stmt->bindParam(":forma_pag", $prevenda->forma_pag);
        // $stmt->bindParam(":pag", $prevenda->pag);
        // $stmt->bindParam(":entrega", $prevenda->entrega);
        // $stmt->bindParam(":status", $prevenda->status);
        $stmt->bindParam(":endereco", $prevenda->endereco);
        $stmt->bindParam(":comissao", $prevenda->comissao);
        $stmt->bindParam(":valor_comissao", $prevenda->valor_comissao);
        $stmt->bindParam(":valor_compra", $prevenda->valor_compra);
        $stmt->bindParam(":cliente", $prevenda->cliente);
        $stmt->bindParam(":vendedor", $prevenda->vendedor);
        $stmt->bindParam(":user", $prevenda->user);
        $stmt->bindParam(":time", $prevenda->time);
        // print_r($prevenda);
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


        $sql = "select * from prevenda where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function getPorIdDetails($id)
    {


        $sql = " select v.*, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, p.nome as nome_cliente
                    from prevenda v
                    inner join pessoa p on p.id = v.cliente
                    where v.id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function listar()
    {


        $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, p.nome as nome_cliente
                    from prevenda v
                    inner join pessoa p on p.id = v.cliente
                    where v.status = 0
					order by data DESC";
        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $pessoa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pessoa;
    }

    public function alterar_status($id)
    {
        $sql = "update prevenda set 
        status = 0
        where id = :id ";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from prevenda where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}