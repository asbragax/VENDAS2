<?php

class StatusDAO{

	private $dao;

	public function __Construct(){
		$this->dao = new Conexao();
	}

	public function getPorId( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "select * from status where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$status = $stmt->fetch(PDO::FETCH_ASSOC);

		return $status;
	}

	public function alterar( $status, $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "update status set status = :status  where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );
		$stmt->bindParam(":status", $status);

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;

	}
}

?>
