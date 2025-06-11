<?php
error_reporting(0);
class PostDAO
{

    private $dao;
    private $CLASS_NAME = "Post";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($post)
    {

        $sql = "insert into post (img, texto) values ( :img, :texto) ";

        $this->dao->beginTransaction();

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":img", $post->getImg());
        $stmt->bindParam(":texto", $post->getTexto());

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
					from post
					order by id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $linha;
    }

    public function getPorId($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "select * from post where id = $id ";
        $stmt = $this->dao->query($sql);

        $post = $stmt->fetchObject($this->CLASS_NAME);

        return $post;
    }


    public function alterar($post)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "update post set img = :img, texto = :texto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $post->getId());
        $stmt->bindParam(":img", $post->getImg());
        $stmt->bindParam(":texto", $post->getTexto());
        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from post where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}