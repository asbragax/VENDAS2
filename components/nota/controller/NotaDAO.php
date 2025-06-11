<?php

ini_set('display_errors', 0);
error_reporting(0);

class NotaDAO
{

    private $dao;
    private $CLASS_NAME = "Nota";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function cadastrar($nota)
    {       
        $sql = "insert into nota( id, valor, fornecedor, data, numero, obs, arquivo, user, time)
        values ( :id, :valor, :fornecedor, :data, :numero, :obs, :arquivo, :user, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $nota->id);
        $stmt->bindParam(":valor", $nota->valor);
        $stmt->bindParam(":fornecedor", $nota->fornecedor);
        $stmt->bindParam(":data", $nota->data);
        $stmt->bindParam(":numero", $nota->numero);
        $stmt->bindParam(":arquivo", $nota->arquivo);
        $stmt->bindParam(":obs", $nota->obs);
        $stmt->bindParam(":user", $nota->user);
        $stmt->bindParam(":time", $nota->time);
        // print_r($nota);
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

        $sql = "select * from nota 
					order by id_auto DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }

    public function listarDetails()
    {

        $sql = "select n.*, DATE_FORMAT(n.data,'%d/%m/%Y') as dataf, f.nome as nome_fornecedor 
                    from nota n
                    inner join fornecedor f on f.id = n.fornecedor
					order by id_auto DESC";

        $stmt = $this->dao->prepare($sql);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
    public function alterar($nota)
    {       
        $sql = "update nota set
        valor = :valor, 
        fornecedor = :fornecedor, 
        data = :data, 
        numero = :numero, 
        obs = :obs, 
        arquivo = :arquivo, 
        user_mod = :user, 
        time_mod = :time
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $nota->id);
        $stmt->bindParam(":valor", $nota->valor);
        $stmt->bindParam(":fornecedor", $nota->fornecedor);
        $stmt->bindParam(":data", $nota->data);
        $stmt->bindParam(":numero", $nota->numero);
        $stmt->bindParam(":arquivo", $nota->arquivo);
        $stmt->bindParam(":obs", $nota->obs);
        $stmt->bindParam(":user", $nota->user);
        $stmt->bindParam(":time", $nota->time);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }

    }

    public function alterar_flag($id, $flag)
    {       
        $sql = "update nota set
        flag = :flag
        where id = :id
        ";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":flag", $flag);

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

        $sql = "select * from nota where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $nota = $stmt->fetchObject($this->CLASS_NAME);

        return $nota;
    }

    public function getPorIdAssoc($id)
    {

        $sql = "select * from nota where id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $nota = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nota;
    }

    public function getPorIdDetails($id)
    {

        $sql = "select n.*, f.nome, f.cnpj, DATE_FORMAT(n.data,'%d/%m/%Y') as dataf
        from nota n
        left join fornecedor f on f.id = n.fornecedor 
        where n.id = :id ";
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $nota = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nota;
    }

    public function getUltimo()
    {

        $sql = "show table status like 'nota'";
        $stmt = $this->dao->query($sql);

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }

    public function excluir($id)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "delete from nota where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

}