<?php
error_reporting(0);
class Conta_caixaDAO{

	private $dao;
	private $CLASS_NAME = "Conta_caixa";

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

	public function cadastrar( $conta_caixa ){

		$sql = "insert into conta_caixa
		( id, id_reduzido, nome) 

		values 

		( :id, :id_reduzido, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $conta_caixa->getId() );
		$stmt->bindParam( ":id_reduzido", $conta_caixa->getId_reduzido() );
		$stmt->bindParam( ":nome", $conta_caixa->getNome() );
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
					from conta_caixa
					order by id";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from conta_caixa where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$conta_caixa = $stmt->fetch(PDO::FETCH_ASSOC);

		return $conta_caixa;
	}


	public function alterar( $conta_caixa ) {

		$sql = "update conta_caixa set 
		id_reduzido = :id_reduzido,
		nome = :nome
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":id", $conta_caixa->getId() );
		$stmt->bindParam( ":id_reduzido", $conta_caixa->getId_reduzido() );
		$stmt->bindParam( ":nome", $conta_caixa->getNome() );
		$result = $stmt->execute();
		// print_r($conta_caixa);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from conta_caixa where id = :id ";
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
