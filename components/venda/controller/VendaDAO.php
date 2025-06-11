<?php

ini_set('display_errors', 0);
error_reporting(0);

class VendaDAO
{

    private $dao;
    private $CLASS_NAME = "Venda";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($venda)
    {       
        $sql = "insert into venda( valor, desconto, data, forma_pag, pag, status, entrega, endereco, prevenda, sociedade, comissao, valor_comissao, valor_compra, cliente, vendedor, user, time)
        values ( :valor, :desconto, :data, :forma_pag, :pag, :status, :entrega, :endereco, :prevenda, :sociedade, :comissao, :valor_comissao, :valor_compra, :cliente, :vendedor, :user, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":valor", $venda->valor);
        $stmt->bindParam(":desconto", $venda->desconto);
        $stmt->bindParam(":data", $venda->data);
        $stmt->bindParam(":forma_pag", $venda->forma_pag);
        $stmt->bindParam(":pag", $venda->pag);
        $stmt->bindParam(":entrega", $venda->entrega);
        $stmt->bindParam(":endereco", $venda->endereco);
        $stmt->bindParam(":prevenda", $venda->prevenda);
        $stmt->bindParam(":sociedade", $venda->sociedade);
        $stmt->bindParam(":comissao", $venda->comissao);
        $stmt->bindParam(":valor_comissao", $venda->valor_comissao);
        $stmt->bindParam(":status", $venda->status);
        $stmt->bindParam(":valor_compra", $venda->valor_compra);
        $stmt->bindParam(":cliente", $venda->cliente);
        $stmt->bindParam(":vendedor", $venda->vendedor);
        $stmt->bindParam(":user", $venda->user);
        $stmt->bindParam(":time", $venda->time);
        // print_r($venda);
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

        $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, p.nome as nome_cliente, m.nome as nome_vendedor 
                    from venda v
                    inner join pessoa p on p.id = v.cliente
                    inner join members m on m.id = v.vendedor
					order by data DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_entregas_abertas()
    {

        $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
        p.nome as nome_cliente, m.nome as nome_vendedor 
                    from venda v
                    inner join pessoa p on p.id = v.cliente
                    inner join members m on m.id = v.vendedor
                    where v.entrega = 1 && v.status = 0
					order by data DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_prevenda()
    {

        $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
        p.nome as nome_cliente, m.nome as nome_vendedor 
                    from venda v
                    inner join pessoa p on p.id = v.cliente
                    inner join members m on m.id = v.vendedor
                    where v.prevenda = 1 
					order by data DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_concluidas()
    {

        $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
        p.nome as nome_cliente, m.nome as nome_vendedor 
                    from venda v
                    inner join pessoa p on p.id = v.cliente
                    inner join members m on m.id = v.vendedor
                    where v.prevenda = 0 
					order by data DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_por_vendedor($id, $status)
    {
        if($status != '*'){

            $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
            p.nome as nome_cliente, m.nome as nome_vendedor 
            from venda v
            inner join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.vendedor = :id && prevenda = :status
            order by data DESC";
            
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
            p.nome as nome_cliente, m.nome as nome_vendedor 
            from venda v
            inner join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.vendedor = :id 
            order by data DESC";
            
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        return $lista;
    }

    public function listar_por_vendedor_periodo($id, $status, $dtini, $dtfim)
    {
        if($status != '*'){
            $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
            p.nome as nome_cliente
            from venda v
            inner join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.vendedor = :id && prevenda = :status &&
            v.data between :dtini and :dtfim
            order by data DESC";
            
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            // echo $id;
            $stmt->execute();
            
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $sql = "select v.*, DATE_FORMAT(v.data,'%d/%m') as dataf, 
            p.nome as nome_cliente 
            from venda v
            inner join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.vendedor = :id  &&
            v.data between :dtini and :dtfim
            order by data DESC";
            
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->execute();
            
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        return $lista;
    }


    
    public function alterar($venda)
    {       
        $sql = "update venda set
        valor = :valor, 
        desconto = :desconto, 
        data = :data, 
        forma_pag = :forma_pag, 
        pag = :pag, 
        status = :status, 
        entrega = :entrega, 
        endereco = :endereco, 
        prevenda = :prevenda, 
        sociedade = :sociedade, 
        comissao = :comissao, 
        valor_comissao = :valor_comissao, 
        valor_compra = :valor_compra, 
        cliente = :cliente, 
        vendedor = :vendedor, 
        user_mod = :user, 
        time_mod = :time
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $venda->id);
        $stmt->bindParam(":valor", $venda->valor);
        $stmt->bindParam(":desconto", $venda->desconto);
        $stmt->bindParam(":data", $venda->data);
        $stmt->bindParam(":forma_pag", $venda->forma_pag);
        $stmt->bindParam(":pag", $venda->pag);
        $stmt->bindParam(":entrega", $venda->entrega);
        $stmt->bindParam(":endereco", $venda->endereco);
        $stmt->bindParam(":prevenda", $venda->prevenda);
        $stmt->bindParam(":sociedade", $venda->sociedade);
        $stmt->bindParam(":comissao", $venda->comissao);
        $stmt->bindParam(":valor_comissao", $venda->valor_comissao);
        $stmt->bindParam(":status", $venda->status);
        $stmt->bindParam(":valor_compra", $venda->valor_compra);
        $stmt->bindParam(":cliente", $venda->cliente);
        $stmt->bindParam(":vendedor", $venda->vendedor);
        $stmt->bindParam(":user", $venda->user);
        $stmt->bindParam(":time", $venda->time);
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


        $sql = "select * from venda where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $venda = $stmt->fetchObject($this->CLASS_NAME);

        return $venda;
    }

    public function getPorIdAssoc($id)
    {


        $sql = "select * from venda where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $venda = $stmt->fetch(PDO::FETCH_ASSOC);

        return $venda;
    }
    public function getPorIdDetails($id)
    {

        $sql = "select v.*, p.nome, p.cpf, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, m.nome as nome_vendedor 
        from venda v
        left join pessoa p on p.id = v.cliente 
                    inner join members m on m.id = v.vendedor
        where v.id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $venda = $stmt->fetch(PDO::FETCH_ASSOC);

        return $venda;
    }

    public function getUltimo()
    {


        $sql = "show table status like 'venda'";
        $stmt = $this->dao->query($sql);

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }

    public function qtdeProduto_semana($dataini, $datafim)
    {

        $sql = "select COALESCE(sum(vp.quantidade),0) as qtde, COALESCE(count(v.id),0) as qtde_venda
        from venda v 
        inner join venda_produto vp on vp.id_venda = v.id
            where
                    v.data between :dataini and :datafim";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":dataini", $dataini);
        $stmt->bindParam(":datafim", $datafim);
        $stmt->execute();

        $lista = $stmt->fetch(PDO::FETCH_ASSOC);

        return $lista;
    }


    public function relatorio_semana($dtini, $dtfim, $vendedor)
    {
        if($vendedor != '*'){
            $sql = "select v.*, p.nome, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, m.nome as nome_vendedor 
            from venda v
            left join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.prevenda = 0 &&
            v.data between :dtini and :dtfim 
            && v.vendedor = :vendedor";
        
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->bindParam(":vendedor", $vendedor);
            $stmt->execute();
        }else{
            $sql = "select v.*, p.nome, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, m.nome as nome_vendedor 
            from venda v
            left join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where v.prevenda = 0 &&
            v.data between :dtini and :dtfim ";
        
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->execute();
        }
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $lista;
    }

    public function caixa_semana($dtini, $dtfim)
    {
            $sql = "select v.*, p.nome, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, m.nome as nome_vendedor 
            from venda v
            left join pessoa p on p.id = v.cliente
            inner join members m on m.id = v.vendedor
            where 
            v.data between :dtini and :dtfim 
            && v.pag = 1
            && v.prevenda = 0
            && v.forma_pag != 96 && v.forma_pag != 98";
        
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->execute();
        
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $lista;
    }
    

    public function crediario_semana($dtini, $dtfim)
    {
            $sql = "select v.*, p.nome, DATE_FORMAT(v.data,'%d/%m/%Y') as dataf, m.nome as nome_vendedor 
            from venda v
            left join pessoa p on p.id = v.cliente
                    inner join members m on m.id = v.vendedor
            inner join venda_pagamento vp on vp.id_venda = v.id
            where vp.id_pagamento = 98  &&
            v.data between :dtini and :dtfim 
            && v.pag = 1
            && v.prevenda = 0";
        
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->execute();
        
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $lista;
    }

    public function concluir_entrega($id)
    {

            $sql = "update venda set
            status = 1
            where id = :id ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare( $sql );
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

    public function efetivar_venda($id)
    {

            $sql = "update venda set
            prevenda = 0
            where id = :id ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare( $sql );
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

        $sql = "delete from venda where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}