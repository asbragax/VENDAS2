<?php

ini_set('display_errors', 0);
error_reporting(0);

class Nota_produtoDAO
{

    private $dao;
    private $CLASS_NAME = "Nota_produto";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($nota_produto)
    {       
        $sql = "insert into nota_produto( id_nota, valor, id_produto, nome, quantidade, grade)
        values ( :id_nota, :valor, :id_produto, :nome, :quantidade, :grade)";
// echo 1;
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $nota_produto->id_nota);
        $stmt->bindParam(":valor", $nota_produto->valor);
        $stmt->bindParam(":id_produto", $nota_produto->id_produto);
        $stmt->bindParam(":nome", $nota_produto->nome);
        $stmt->bindParam(":quantidade", $nota_produto->quantidade);
        $stmt->bindParam(":grade", $nota_produto->grade);
        // print_r($nota_produto);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function cadastrar_grade($nota, $id, $tipo, $quantidade)
    {

        $sql = "insert into nota_produto_grade( nota, id, tipo, quantidade)
        values ( :nota, :id, :tipo, :quantidade)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":nota", $nota);
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
                    from nota_produto 
                    where id_nota = :id
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
                    from nota_produto_grade 
                    where nota = :id && id = :prod
					order by nota";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":prod", $prod);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
    public function alterar($nota_produto)
    {       
        $sql = "update nota_produto set
        valor = :valor, 
        id_produto = :id_produto, 
        quantidade = :quantidade, 
        grade = :grade, 
        id_nota = :id_nota
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $nota_produto->id);
        $stmt->bindParam(":id_nota", $nota_produto->id_nota);
        $stmt->bindParam(":valor", $nota_produto->valor);
        $stmt->bindParam(":id_produto", $nota_produto->id_produto);
        $stmt->bindParam(":quantidade", $nota_produto->quantidade);
        $stmt->bindParam(":grade", $nota_produto->grade);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }


    public function getPorId($id_nota)
    {


        $sql = "select * from nota_produto where id_nota = :id_nota ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);
        $stmt->execute();

        $nota_produto = $stmt->fetchObject($this->CLASS_NAME);

        return $nota_produto;
    }

    public function getPorIdAssoc($id_nota)
    {


        $sql = "select * from nota_produto where id_nota = :id_nota ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);
        $stmt->execute();

        $nota_produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nota_produto;
    }
    public function getPorIdDetails($id_nota)
    {

        $sql = "select v.*, p.nome, p.cpf, DATE_FORMAT(v.quantidade,'%d/%m/%Y') as quantidadef, m.nome as nome_vendedor 
        from nota_produto v
        left join pessoa p on p.id_nota = v.cliente 
                    inner join members m on m.id_nota = v.vendedor
        where v.id_nota = :id_nota ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);
        $stmt->execute();

        $nota_produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nota_produto;
    }

    public function getUltimo()
    {


        $sql = "show table status like 'nota_produto'";
        $stmt = $this->dao->query($sql);

        $id_nota = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id_nota;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from nota_produto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_todos($id_nota)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from nota_produto where id_nota = :id_nota ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_grade($id_nota, $produto)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from nota_produto_grade where nota = :id_nota && id = :produto ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);
        $stmt->bindParam(":produto", $produto);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_grade_todos($id_nota)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from nota_produto_grade where nota = :id_nota ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_nota", $id_nota);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}