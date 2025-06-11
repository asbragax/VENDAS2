<?php
error_reporting(0);
class Conta_receitaDAO{

	private $dao;
	private $CLASS_NAME = "Conta_receita";

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

	public function cadastrar( $conta_receita ){

		$sql = "insert into conta_receita
		( id, id_reduzido, nome) 

		values 

		( :id, :id_reduzido, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $conta_receita->getId() );
		$stmt->bindParam( ":id_reduzido", $conta_receita->getId_reduzido() );
		$stmt->bindParam( ":nome", $conta_receita->getNome() );
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
					from conta_receita
					order by id_auto";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from conta_receita where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$conta_receita = $stmt->fetch(PDO::FETCH_ASSOC);

		return $conta_receita;
	}



	public function alterar( $conta_receita ) {

		$sql = "update conta_receita set 
		id_reduzido = :id_reduzido,
		nome = :nome
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":id", $conta_receita->getId() );
		$stmt->bindParam( ":id_reduzido", $conta_receita->getId_reduzido() );
		$stmt->bindParam( ":nome", $conta_receita->getNome() );
		$result = $stmt->execute();
		// print_r($conta_receita);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from conta_receita where id = :id ";
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
