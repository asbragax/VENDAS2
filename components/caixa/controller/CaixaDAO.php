<?php
error_reporting(0);
class CaixaDAO{

	private $dao;
	private $CLASS_NAME = "Caixa";

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

	public function cadastrar( $caixa ){

		$sql = "insert into caixa
		( valor, mes, ano) 

		values 

		( :valor, :mes, :ano) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":valor", $caixa-> getValor() );
		$stmt->bindParam( ":mes", $caixa->getMes() );
		$stmt->bindParam( ":ano", $caixa->getAno() );
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
					from caixa
					order by mes ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function getPorId( $id ) {

		$sql = "select * from caixa where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$caixa = $stmt->fetch(PDO::FETCH_ASSOC);

		return $caixa;
	}

	public function getPorMes( $mes, $ano ) {

		$sql = "select * from caixa where mes = :mes && ano = :ano ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();


		$caixa = $stmt->fetch(PDO::FETCH_ASSOC);

		return $caixa;
	}

	public function alterar( $caixa ) {

		$sql = "update caixa set 
		valor = :valor,
		mes = :mes,
		ano = :ano
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $caixa->getId());
		$stmt->bindParam( ":valor", $caixa-> getValor() );
		$stmt->bindParam( ":mes", $caixa->getMes() );
		$stmt->bindParam( ":ano", $caixa->getAno() );
		$result = $stmt->execute();
		// print_r($caixa);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from caixa where id = :id ";
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
