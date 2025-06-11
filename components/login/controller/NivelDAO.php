<?php

class NivelDAO{

	private $dao;
	private $CLASS_NAME = "Nivel";

	public function __Construct(){
		$this->dao = new Conexao();
	}

	public function cadastrar( $nivel ){

		$sql = "insert into nivel( id, nome) values ( :id, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":nome", $nivel->getNome() );
		$stmt->bindParam( ":id", $nivel->getId() );

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
					from nivel
					order by nome ";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function getPorId( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "select * from nivel where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$nivel = $stmt->fetch(PDO::FETCH_ASSOC);

		return $nivel;
	}

	public function getPorNome( $nome ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "select * from nivel where nome = :nome ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->execute();

		$nivel = $stmt->fetch(PDO::FETCH_ASSOC);

		return $nivel;
	}

	public function alterar( $nivel, $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "update nivel set id = :id, nome = :nome where id = :oldid ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $nivel->getId() );
		$stmt->bindParam(":oldid", $id);
		$stmt->bindParam(":nome", $nivel->getNome());

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;

	}

	public function excluir( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from nivel where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

}

?>
