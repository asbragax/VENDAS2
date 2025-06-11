<?php

ini_set('display_errors', 0);
error_reporting(0);

class Venda_produtoDAO
{

    private $dao;
    private $CLASS_NAME = "Venda_produto";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($venda_produto)
    {

        $sql = "insert into venda_produto( id_venda, id_produto, quantidade, nome, tamanho, valor_unit, valor_total, valor_compra  )
        values (:id_venda, :id_produto, :quantidade, :nome, :tamanho, :valor_unit, :valor_total, :valor_compra )";
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_venda", $venda_produto->id_venda);
        $stmt->bindParam(":id_produto", $venda_produto->id_produto);
        $stmt->bindParam(":quantidade", $venda_produto->quantidade);
        $stmt->bindParam(":nome", $venda_produto->nome);
        $stmt->bindParam(":tamanho", $venda_produto->tamanho);
        $stmt->bindParam(":valor_unit", $venda_produto->valor_unit);
        $stmt->bindParam(":valor_total", $venda_produto->valor_total);
        $stmt->bindParam(":valor_compra", $venda_produto->valor_compra);
        // print_r($venda_produto);

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

        $sql = "select id_produto as id, quantidade, nome, tamanho, valor_compra, valor_unit, valor_total, id_venda as venda
                    from venda_produto 
					where id_venda = :id_venda";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_venda", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    public function listarComEstoque($id)
    {

        $sql = "select vp.id_produto as id, vp.quantidade, vp.nome, 
        vp.tamanho, vp.valor_compra, vp.valor_unit, 
        vp.valor_total, vp.id_venda as venda,
        pg.quantidade as estoque
                    from venda_produto vp
                    inner join produto_grade pg on pg.id = vp.id_produto
					where vp.id_venda = :id_venda && pg.tipo = vp.tamanho";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_venda", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function relatorio_estoque($dataini, $datafim)
    {

        $sql = "select p.id as id_prod, p.quantidade as estoque, vp.`quantidade`, p.nome, v.id, DATE_FORMAT(v.data, '%d/%m/%Y') as data
            from venda_produto vp 
            inner join produto p on p.id = vp.id_produto
            inner join venda v on v.id = vp.id_venda
                where v.data BETWEEN :dataini and :datafim";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":dataini", $dataini);
        $stmt->bindParam(":datafim", $datafim);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function relatorio_produtos($periodo, $dataini, $datafim, $produto, $sociedade, $status)
    {
        if($periodo == 1){
            
            if($produto == '*'){
                $sql = "select p.id as id_prod, p.estoque, vp.quantidade,vp.tamanho, p.nome, 
                v.id, DATE_FORMAT(v.data, '%d/%m/%Y') as dataf,
                v.prevenda, cli.nome as nome_cliente, m.nome as nome_vendedor, vp.valor_total
                from venda_produto vp 
                inner join produto p on p.id = vp.id_produto
                inner join venda v on v.id = vp.id_venda
                left join pessoa cli on cli.id = v.cliente
                left join members m on m.id = v.vendedor 
                where v.prevenda = :status ";

                if($sociedade == 1){
                    $sql .=" && p.sociedade = 1 ";
                }

                $sql .=" order by v.data asc";
                
                $stmt = $this->dao->prepare($sql);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

            }else{

                $sql = "select p.id as id_prod, p.estoque, vp.quantidade,vp.tamanho, p.nome, 
                v.id, DATE_FORMAT(v.data, '%d/%m/%Y') as dataf,
                v.prevenda, cli.nome as nome_cliente, m.nome as nome_vendedor, vp.valor_total
                from venda_produto vp 
                inner join produto p on p.id = vp.id_produto
                inner join venda v on v.id = vp.id_venda
                left join pessoa cli on cli.id = v.cliente
                left join members m on m.id = v.vendedor
                where vp.id_produto = :produto 
                && v.prevenda = :status ";

                if($sociedade == 1){
                    $sql .=" && p.sociedade = 1 ";
                }

                $sql .=" order by v.data asc";
                
                $stmt = $this->dao->prepare($sql);
                $stmt->bindParam(":produto", $produto);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

        }else{
            if($produto == '*'){
                $sql = "select p.id as id_prod, p.estoque, vp.quantidade, p.nome, 
                v.id, DATE_FORMAT(v.data, '%d/%m/%Y') as dataf,
                v.prevenda, cli.nome as nome_cliente, m.nome as nome_vendedor, vp.valor_total
                from venda_produto vp 
                inner join produto p on p.id = vp.id_produto
                inner join venda v on v.id = vp.id_venda
                left join pessoa cli on cli.id = v.cliente
                left join members m on m.id = v.vendedor
                where v.data BETWEEN :dataini and :datafim 
                && v.prevenda = :status ";

                if($sociedade == 1){
                    $sql .=" && p.sociedade = 1 ";
                }

                $sql .=" order by v.data asc";
                
                $stmt = $this->dao->prepare($sql);
                $stmt->bindParam(":dataini", $dataini);
                $stmt->bindParam(":datafim", $datafim);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql = "select p.id as id_prod, p.estoque, vp.quantidade, p.nome, 
                v.id, DATE_FORMAT(v.data, '%d/%m/%Y') as dataf,
                v.prevenda, cli.nome as nome_cliente, m.nome as nome_vendedor, vp.valor_total
                from venda_produto vp 
                inner join produto p on p.id = vp.id_produto
                inner join venda v on v.id = vp.id_venda
                left join pessoa cli on cli.id = v.cliente
                left join members m on m.id = v.vendedor
                where vp.id_produto = :produto 
                && v.data BETWEEN :dataini and :datafim 
                && v.prevenda = :status ";

                if($sociedade == 1){
                    $sql .=" && p.sociedade = 1 ";
                }

                $sql .=" order by v.data asc";
                
                $stmt = $this->dao->prepare($sql);
                $stmt->bindParam(":dataini", $dataini);
                $stmt->bindParam(":datafim", $datafim);
                $stmt->bindParam(":produto", $produto);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

        }

        return $lista;
    }

    public function listarPorCliente($id)
    {
        $sql = "select vp.quantidade, p.nome, DATE_FORMAT(v.data,'%d/%m/%Y') as data
                    from venda_produto vp
                    inner join venda v on v.id = vp.id_venda
                    inner join produto p on p.id = vp.id_produto
                    where v.cliente = :id
                    order by v.data desc";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function getPorId($id)
    {
        $sql = "select * from venda_produto
        where id = :id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pessoa = $stmt->fetchObject($this->CLASS_NAME);

        return $pessoa;
    }

    public function excluir($id)
    {
        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        $sql = "delete from venda_produto where id_venda = :id ";

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
        $sql = "delete from venda_produto where id_venda = :id && id_produto = :idprod";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":idprod", $idprod);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}