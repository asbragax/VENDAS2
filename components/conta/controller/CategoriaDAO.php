<?php
error_reporting(0);
class CategoriaDAO{

	private $dao;
	private $CLASS_NAME = "Categoria";

	public function __Construct(){
		$this->dao = new Conexao();
	}

	 public function pegaTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }
    public function pegaDate()
    {
        return date('Y-m-d');
    }

	public function cadastrar( $categoria ){

		$sql = "insert into categoria
		( id, cc, cc_reduzido, nome, grupo) 

		values 

		( :id, :cc, :cc_reduzido, :nome, :grupo) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $categoria->getId() );
		$stmt->bindParam( ":cc", $categoria->getCc() );
		$stmt->bindParam( ":cc_reduzido", $categoria->getCc_reduzido() );
		$stmt->bindParam( ":nome", $categoria->getNome() );
		$stmt->bindParam( ":grupo", $categoria->getGrupo() );
		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}

	public function listar() {

		$sql = "select *
					from categoria
					order by nome";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listarPorGrupo($id) {

		$sql = "select c.*, g.nome as grupo
					from categoria c 
					left join grupo g on g.id = c.grupo
					where grupo = :id
					order by nome";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listarDetails() {

		$sql = "select c.*, g.nome as grupo
					from categoria c 
					left join grupo g on g.id = c.grupo
					order by nome";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from categoria where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

		return $categoria;
	}

	public function getPorNome( $nome ) {

		$sql = "select * from categoria where nome = :nome ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->execute();


		$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

		return $categoria;
	}

	public function getPorCc( $nome ) {

		$sql = "select * from categoria where cc = :nome ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->execute();


		$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

		return $categoria;
	}

	public function alterar( $categoria ) {

		$sql = "update categoria set 
		cc = :cc,
		cc_reduzido = :cc_reduzido,
		nome = :nome,
		grupo = :grupo
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":id", $categoria->getId() );
		$stmt->bindParam( ":cc", $categoria->getCc() );
		$stmt->bindParam( ":cc_reduzido", $categoria->getCc_reduzido() );
		$stmt->bindParam( ":nome", $categoria->getNome() );
		$stmt->bindParam( ":grupo", $categoria->getGrupo() );
		$result = $stmt->execute();
		// print_r($categoria);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from categoria where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
	}


}

?>
