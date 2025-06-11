<?php

ini_set('display_errors', 0);
error_reporting(0);

class Prevenda_produtoDAO
{

    private $dao;
    private $CLASS_NAME = "Prevenda_produto";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($prevenda_produto)
    {

        $sql = "insert into prevenda_produto( id_venda, id_produto, quantidade, nome, tamanho, valor_unit, valor_total, cor  )
        values (:id_venda, :id_produto, :quantidade, :nome, :tamanho, :valor_unit, :valor_total, :cor )";
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_venda", $prevenda_produto->id_venda);
        $stmt->bindParam(":id_produto", $prevenda_produto->id_produto);
        $stmt->bindParam(":quantidade", $prevenda_produto->quantidade);
        $stmt->bindParam(":nome", $prevenda_produto->nome);
        $stmt->bindParam(":tamanho", $prevenda_produto->tamanho);
        $stmt->bindParam(":valor_unit", $prevenda_produto->valor_unit);
        $stmt->bindParam(":valor_total", $prevenda_produto->valor_total);
        $stmt->bindParam(":cor", $prevenda_produto->cor);
        // print_r($prevenda_produto);

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
                    from prevenda_produto 
					where id_venda = :id_venda";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_venda", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }


    public function excluir($id)
    {
        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        $sql = "delete from prevenda_produto where id_venda = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluirUm($id, $idprod)
    {
        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        $sql = "delete from prevenda_produto where id_venda = :id && id_produto = :idprod";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":idprod", $idprod);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}