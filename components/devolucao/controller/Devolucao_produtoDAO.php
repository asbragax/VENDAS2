<?php

ini_set('display_errors', 0);
error_reporting(0);

class Devolucao_produtoDAO
{

    private $dao;
    private $CLASS_NAME = "Devolucao_produto";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($devolucao_produto)
    {       
        $sql = "insert into devolucao_produto( id_devolucao, id_produto, nome, quantidade, grade)
        values ( :id_devolucao, :id_produto, :nome, :quantidade, :grade)";
// echo 1;
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $devolucao_produto->id_devolucao);
        // $stmt->bindParam(":valor", $devolucao_produto->valor);
        $stmt->bindParam(":id_produto", $devolucao_produto->id_produto);
        $stmt->bindParam(":nome", $devolucao_produto->nome);
        $stmt->bindParam(":quantidade", $devolucao_produto->quantidade);
        $stmt->bindParam(":grade", $devolucao_produto->grade);
        // print_r($devolucao_produto);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function cadastrar_grade($devolucao, $id, $tipo, $quantidade)
    {

        $sql = "insert into devolucao_produto_grade( devolucao, id, tipo, quantidade)
        values ( :devolucao, :id, :tipo, :quantidade)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":devolucao", $devolucao);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":quantidade", $quantidade);

        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function listar($id)
    {

        $sql = "select *
                    from devolucao_produto 
                    where id_devolucao = :id
					order by id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_grade($id, $prod)
    {

        $sql = "select *
                    from devolucao_produto_grade 
                    where devolucao = :id && id = :prod
					order by devolucao";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":prod", $prod);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
    public function alterar($devolucao_produto)
    {       
        $sql = "update devolucao_produto set
        valor = :valor, 
        id_produto = :id_produto, 
        quantidade = :quantidade, 
        grade = :grade, 
        id_devolucao = :id_devolucao
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $devolucao_produto->id);
        $stmt->bindParam(":id_devolucao", $devolucao_produto->id_devolucao);
        $stmt->bindParam(":valor", $devolucao_produto->valor);
        $stmt->bindParam(":id_produto", $devolucao_produto->id_produto);
        $stmt->bindParam(":quantidade", $devolucao_produto->quantidade);
        $stmt->bindParam(":grade", $devolucao_produto->grade);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }


    public function getPorId($id_devolucao)
    {


        $sql = "select * from devolucao_produto where id_devolucao = :id_devolucao ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);
        $stmt->execute();

        $devolucao_produto = $stmt->fetchObject($this->CLASS_NAME);

        return $devolucao_produto;
    }

    public function getPorIdAssoc($id_devolucao)
    {


        $sql = "select * from devolucao_produto where id_devolucao = :id_devolucao ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);
        $stmt->execute();

        $devolucao_produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $devolucao_produto;
    }
    public function getPorIdDetails($id_devolucao)
    {

        $sql = "select v.*, p.nome, p.cpf, DATE_FORMAT(v.quantidade,'%d/%m/%Y') as quantidadef, m.nome as nome_vendedor 
        from devolucao_produto v
        left join pessoa p on p.id_devolucao = v.cliente 
                    inner join members m on m.id_devolucao = v.vendedor
        where v.id_devolucao = :id_devolucao ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);
        $stmt->execute();

        $devolucao_produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $devolucao_produto;
    }

    public function getUltimo()
    {


        $sql = "show table status like 'devolucao_produto'";
        $stmt = $this->dao->query($sql);

        $id_devolucao = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id_devolucao;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from devolucao_produto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_todos($id_devolucao)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from devolucao_produto where id_devolucao = :id_devolucao ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_grade($id_devolucao, $produto)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from devolucao_produto_grade where devolucao = :id_devolucao && id = :produto ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);
        $stmt->bindParam(":produto", $produto);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_grade_todos($id_devolucao)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from devolucao_produto_grade where devolucao = :id_devolucao ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_devolucao", $id_devolucao);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}