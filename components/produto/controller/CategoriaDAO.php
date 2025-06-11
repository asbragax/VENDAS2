<?php

ini_set('display_errors', 0);
error_reporting(0);

class CategoriaDAO
{

    private $dao;
    private $CLASS_NAME = "Categoria";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($categoria)
    {

        $sql = "insert into categoria( nome, foto)
        values ( :nome, :foto)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":nome", $categoria->nome);
        $stmt->bindParam(":foto", $categoria->foto);


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
					from categoria
					order by nome";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    

    public function getPorId($id)
    {

        $sql = "select * from categoria where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetchObject($this->CLASS_NAME);

        return $pessoa;
    }

    public function getPorIdAssoc($id)
    {
        $sql = "select * from categoria where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pessoa;
    }



    public function alterar($categoria)
    {
        $sql = "update categoria set 
        nome = :nome,
        foto = :foto
        where id = :id ";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $categoria->id);
        $stmt->bindParam(":nome", $categoria->nome);
        $stmt->bindParam(":foto", $categoria->foto);
        
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
        
        $sql = "delete from categoria where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}