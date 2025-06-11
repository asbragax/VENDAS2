<?php

ini_set('display_errors', 0);
error_reporting(0);

class ProdutoDAO
{

    private $dao;
    private $CLASS_NAME = "Produto";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function pegaTimeStamp()
	{
		return date('Y-m-d H:i:s');
    }

    public function cadastrar($produto)
    {

        $sql = "insert into produto( id, referencia, nome, estoque, valor_compra, valor_venda, valor_atacado, gender, categoria, sociedade, grade, user, time)
        values ( :id, :referencia, :nome, :estoque, :valor_compra, :valor_venda, 0, :gender, :categoria, :sociedade, :grade, :user, :time)";
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $produto->id);
        $stmt->bindParam(":referencia", $produto->referencia);
        $stmt->bindParam(":nome", $produto->nome);
        $stmt->bindParam(":estoque", $produto->estoque);
        $stmt->bindParam(":valor_compra", $produto->valor_compra);
        $stmt->bindParam(":valor_venda", $produto->valor_venda);
        // $stmt->bindParam(":valor_atacado", $produto->valor_atacado);
        $stmt->bindParam(":gender", $produto->gender);
        $stmt->bindParam(":categoria", $produto->categoria);
        $stmt->bindParam(":sociedade", $produto->sociedade);
        $stmt->bindParam(":grade", $produto->grade);
        $stmt->bindParam(":user", $produto->user);
        $stmt->bindParam(":time", $this->pegaTimeStamp());
        // print_r($produto);


        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function cadastrar_grade($id, $tipo, $quantidade)
    {

        $sql = "insert into produto_grade( id, tipo, quantidade)
        values ( :id, :tipo, :quantidade)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
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

    public function cadastrar_cor($id, $cor)
    {

        $sql = "insert into produto_cor( id, cor, nome)
        values ( :id, :cor, :nome)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":cor", $cor);

        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function cadastrar_foto($id, $foto)
    {
        $sql = "insert into produto_foto( id_produto, foto)
        values ( :id, :foto)";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":foto", $foto);
        
        // echo $id." ".$foto;
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function cadastrar_foto_principal($id, $foto)
    {
        $sql = "insert into produto_foto( id_produto, foto, main)
        values ( :id, :foto, 1)";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":foto", $foto);
        
        // echo $id." ".$foto;
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

        $sql = "select p.*, pf.*, c.nome as nome_categoria
					from produto p
                    left join produto_foto pf on pf.id_produto = p.id
                    left join categoria c on c.id = p.categoria
                    group by p.id
					order by nome";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarSociedade($sociedade)
    {

        $sql = "select p.*, c.nome as nome_categoria
					from produto p
                    left join categoria c on c.id = p.categoria
                    where p.sociedade = :sociedade
					order by nome";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":sociedade", $sociedade);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarComCategoria()
    {

        $sql = "select p.*, pf.*, c.nome as nome_categoria
					from produto p
                    left join produto_foto pf on pf.id_produto = p.id
                    inner join categoria c on c.id = p.categoria
                    group by p.id
					order by RAND()";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarComCategoriaEFoto()
    {

        $sql = "select p.*, pf.*, c.nome as nome_categoria
					from produto p
                    inner join produto_foto pf on pf.id_produto = p.id
                    inner join categoria c on c.id = p.categoria
                    group by p.id
					order by RAND()";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarPorCategoriaRandom($id)
    {

        $sql = "select p.*, pf.*
        from produto p
        left join produto_foto pf on pf.id_produto = p.id
        where p.categoria = :id 
        order by RAND()";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarPorCategoria($id)
    {

        $sql = "select *
                    from produto 
                    where categoria = :id 
                    order by id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $produto;
    }

    public function listar_grade($id)
    {

        $sql = "select *
					from produto_grade
                    where id = :id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_grade_tamanho($id, $tipo)
    {

        $sql = "select *
					from produto_grade
                    where id = :id && tipo = :tipo";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->execute();

        $lista = $stmt->fetch(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listar_cor($id)
    {

        $sql = "select *
					from produto_cor
                    where id = :id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    public function listar_fotos($id)
    {

        $sql = "select *
					from produto_foto
                    where id_produto = :id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function getPorId($id)
    {

        $sql = "select * from produto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $produto = $stmt->fetchObject($this->CLASS_NAME);

        return $produto;
    }

    public function getPorIdAssoc($id)
    {

        $sql = "select * from produto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $produto;
    }

    public function listar_produtos_site($cat, $order, $asc, $name, $gender, $minprice, $maxprice, $offset, $per_page)
    {
        $sql = "select p.*, pf.*, c.nome as nome_categoria
        from produto p
        inner join produto_foto pf on pf.id_produto = p.id
        inner join categoria c on c.id = p.categoria
        where p.valor_venda >= :minprice 
        &&  p.valor_venda <= :maxprice 
        && (select sum(pg.quantidade) from produto_grade pg where pg.id = p.id)  > 0 ";

        if($cat != '0'){
            $sql .= " && p.categoria = ".$cat." ";
        }
        if($name != ''){
            $sql .= " && p.nome like '%".$name."%' ";
        }
        if($gender == 'f' || $gender == 'm'){
            $sql .= " && p.gender = '".$gender."' ";
        }

        $sql .= " group by p.id 
        order by ".$order." ".$asc."
        LIMIT ".$offset.",".$per_page;

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":minprice", $minprice);
        $stmt->bindParam(":maxprice", $maxprice);

        $stmt->execute();
        $produto[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $sql = "select p.*, pf.*, c.nome as nome_categoria
        from produto p
        inner join produto_foto pf on pf.id_produto = p.id
        inner join categoria c on c.id = p.categoria
        where p.valor_venda >= :minprice 
        &&  p.valor_venda <= :maxprice 
        && (select sum(pg.quantidade) from produto_grade pg where pg.id = p.id) > 0 ";

        if($cat != '0'){
            $sql .= " && p.categoria = ".$cat." ";
        }
        if($name != ''){
            $sql .= " && p.nome like '%".$name."%' ";
        }

        $sql .= " group by p.id";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":minprice", $minprice);
        $stmt->bindParam(":maxprice", $maxprice);

        $stmt->execute();
        $produto2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produto[2] = count($produto2);

        return $produto;
    }

    public function alterar($produto)
    {
        $sql = "update produto set 
        referencia = :referencia,
        nome = :nome,
        estoque = :estoque,
        sociedade = :sociedade,
        grade = :grade,
        valor_compra = :valor_compra,
        valor_venda = :valor_venda,
        gender = :gender,
        categoria = :categoria,
        valor_atacado = 0,
        usermod = :user,
        timemod = :time
        where id = :id ";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $produto->id);
        $stmt->bindParam(":referencia", $produto->referencia);
        $stmt->bindParam(":nome", $produto->nome);
        $stmt->bindParam(":estoque", $produto->estoque);
        $stmt->bindParam(":valor_compra", $produto->valor_compra);
        $stmt->bindParam(":valor_venda", $produto->valor_venda);
        // $stmt->bindParam(":valor_atacado", $produto->valor_atacado);
        $stmt->bindParam(":sociedade", $produto->sociedade);
        $stmt->bindParam(":gender", $produto->gender);
        $stmt->bindParam(":categoria", $produto->categoria);
        $stmt->bindParam(":grade", $produto->grade);
        $stmt->bindParam(":user", $produto->user);
        $stmt->bindParam(":time", $this->pegaTimeStamp());
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function editar_categoria($id, $categoria)
    {
        $sql = "update produto set 
        categoria = :categoria
        where id = :id ";
        
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":categoria", $categoria);
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }


    public function deduzir_quantidade($id, $tipo, $quantidade)
    {

            $sql = "update produto_grade set
            quantidade = (quantidade - :quantidade)
            where id = :id && tipo = :tipo";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare( $sql );
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

    public function aumentar_quantidade($id, $tipo, $quantidade)
    {

                $sql = "update produto_grade set
                quantidade = (quantidade + :quantidade)
            where id = :id && tipo = :tipo";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare( $sql );
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

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        
        $sql = "delete from produto where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_grade($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        
        $sql = "delete from produto_grade where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function excluir_cor($id, $cor)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        
        $sql = "delete from produto_cor where id = :id && cor = :cor";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":cor", $cor);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function alterar_foto_principal($id, $foto)
    {
        $sql = "update produto_foto set 
        main = 0
        where id_produto = :id ";
        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        // echo 1;
        $result = $stmt->execute();

        $sql = "update produto_foto set 
        main = 1
        where id_foto = :foto ";
        
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":foto", $foto);
        
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function excluir_foto($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };
        
        $sql = "delete from produto_foto where id_foto = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}