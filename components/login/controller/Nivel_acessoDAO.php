<?php

class Nivel_acessoDAO{

	private $dao;
	private $CLASS_NAME = "Nivel_acesso";

	public function __Construct(){
		$this->dao = new Conexao();
	}

	public function cadastrar( $nivel_acesso ){

		$sql = "insert into nivel_acesso ( id_nivel, financeiro, usuario, aula, calendario, relatorios, membro) values ( :id_nivel, :financeiro, :usuario, :aula, :calendario, :relatorios, :membro) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id_nivel", $nivel_acesso->getId_nivel() );
		$stmt->bindParam( ":financeiro", $nivel_acesso->getFinanceiro() );
		$stmt->bindParam( ":usuario", $nivel_acesso->getUsuario() );
		$stmt->bindParam( ":aula", $nivel_acesso->getAula() );
		$stmt->bindParam( ":calendario", $nivel_acesso->getCalendario() );
		$stmt->bindParam( ":relatorios", $nivel_acesso->getRelatorios() );
		$stmt->bindParam( ":membro", $nivel_acesso->getMembro() );
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
					from nivel_acesso
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

		$sql = "select * from nivel_acesso where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$nivel_acesso = $stmt->fetch(PDO::FETCH_ASSOC);

		return $nivel_acesso;
	}

	public function getPorNome( $nome ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "select * from nivel_acesso where nome = :nome ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":nome", $nome);
		$stmt->execute();

		$nivel_acesso = $stmt->fetch(PDO::FETCH_ASSOC);

		return $nivel_acesso;
	}

	public function alterar( $nivel_acesso ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "update nivel_acesso set nome = :nome where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $nivel_acesso->getId() );
		$stmt->bindParam(":nome", $nivel_acesso->getNome());

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;

	}

	public function excluir( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from nivel_acesso where id_nivel = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

}

?>
