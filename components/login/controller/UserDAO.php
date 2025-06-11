<?php
error_reporting(0);
class UserDAO
{

    private $dao;
    private $CLASS_NAME = "User";

    public function __Construct()
    {
        $this->dao = new Conexao();
    }

    public function pegaTimeStamp()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d H:i:s');
    }

    public function cadastrar($newuser, $newid, $newpw, $nivel, $nome, $img, $email)
    {

        $sql = "insert into members (id, username, password, nivel, nome, img, email)
				values (:id, :username, :password, :nivel, :nome, :img, :email)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $newid);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":nivel", $nivel);
        $stmt->bindParam(":password", $newpw);
        $stmt->bindParam(":username", $newuser);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":email", $email);

        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function cadastrar_login($id)
    {

        $sql = "insert into member_login (id_member, time)
				values (:id_member, :time)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_member", $id);
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

    public function listar()
    {


        $sql = "select
					* from members && verified = 1";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }


    public function listar_byNivel($nivel, $nivel2 = null)
    {

        if ($nivel2 == null) {
            $sql = "SELECT * FROM members where nivel = $nivel && verified = 1";
        } else {
            $sql = "SELECT * FROM members where (nivel = $nivel || nivel = $nivel2) && verified = 1";
        }


        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }



    public function listar_under_3()
    {

        $sql = "SELECT m.*, n.nome as level
        FROM members m
        left join nivel n on n.id = m.nivel
        where nivel <= 3
        && m.verified = 1";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }

    public function listar_funcionarios()
    {

 
        $sql = "SELECT * from members where verified = 1 && nivel <= 3";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }

    public function listar_funcionariosDesc()
    {

 
        $sql = "SELECT * from members where verified = 1 && nivel <= 3
        order by nivel desc";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }


    public function listar_all_level()
    {


        $sql = "SELECT m.*, n.nome as level
        FROM members m
        inner join nivel n on n.id = m.nivel";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }

    public function listar_all_levelDesc()
    {


        $sql = "SELECT m.*, n.nome as level
        FROM members m
        inner join nivel n on n.id = m.nivel
        where m.verified = 1
        order by nivel desc
        ";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }

    public function listar_gerentes()
    {


        $sql = "SELECT *
        FROM members 
        WHERE nivel >= 3";
        $stmt = $this->dao->query($sql);

        $listaUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $listaUser;
    }


    public function getPorId($id)
    {

          $sql = "select * from members where id = :id";
         $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }


    public function getPorNome($username)
    {


        $sql = "select * from members where username = :username ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function alterar($id, $nome, $nick)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };


        $sql = "update members set
            nome = :nome,
            username = :username,
            mod_timestamp = :time
        where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":username", $nick);
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

    public function alteraSenha($id, $password)
    {
        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "update members set password = :password where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":password", $password);

        $result = $stmt->execute();
        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function alteraNivel($id, $nivel)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "update members set nivel = :nivel where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nivel", $nivel);

        $result = $stmt->execute();
        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

    public function alteraAvatar($id, $img)
    {

        if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

        $sql = "update members set img = :img where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":img", $img);

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

        $sql = "delete from members where id = :id ";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
    }

    public function desativar($id)
    {

        $sql = "update members set
					verified = 0 where id = :id ";

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

    public function ativar($id)
    {

        $sql = "update members set
					verified = 1 where id = :id ";

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



}