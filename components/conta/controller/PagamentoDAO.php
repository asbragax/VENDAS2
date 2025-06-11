<?php
error_reporting(0);
class PagamentoDAO{

	private $dao;
	private $CLASS_NAME = "Pagamento";

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

	public function cadastrar( $pagamento ){

		$sql = "insert into pagamento
		(nome) 

		values 

		(:nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":nome", $pagamento->nome );
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
					from pagamento
					order by id";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from pagamento where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$pagamento = $stmt->fetch(PDO::FETCH_ASSOC);

		return $pagamento;
	}


	public function alterar( $pagamento ) {

		$sql = "update pagamento set 
		nome = :nome
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":id", $pagamento->id );
		$stmt->bindParam( ":nome", $pagamento->nome );
		$result = $stmt->execute();
		// print_r($pagamento);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from pagamento where id = :id ";
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
