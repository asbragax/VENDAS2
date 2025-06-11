<?php
error_reporting(0);
class GrupoDAO{

	private $dao;
	private $CLASS_NAME = "Grupo";

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

	public function cadastrar( $grupo ){

		$sql = "insert into grupo
		( id, nome) 

		values 

		( :id, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $grupo->getId() );
		$stmt->bindParam( ":nome", $grupo->getNome() );
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
					from grupo
					order by id";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from grupo where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$grupo = $stmt->fetch(PDO::FETCH_ASSOC);

		return $grupo;
	}


	public function alterar( $grupo, $oldid ) {

		$sql = "update grupo set 
		id = :id,
		nome = :nome
		where id = :oldid ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":oldid", $oldid );
		$stmt->bindParam( ":id", $grupo->getId() );
		$stmt->bindParam( ":nome", $grupo->getNome() );
		$result = $stmt->execute();
		// print_r($grupo);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from grupo where id = :id ";
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
