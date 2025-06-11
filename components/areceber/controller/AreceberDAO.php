<?php
error_reporting(0);
class AreceberDAO{

	private $dao;
	private $CLASS_NAME = "Areceber";

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

	public function cadastrar( $areceber ){

		$sql = "insert into areceber
		( nome, valor, data, conta_credito, conta_debito, dizimo, id_pessoa, id_igreja) 

		values 

		( :nome, :valor, :data, :conta_credito, :conta_debito, :dizimo, :id_pessoa, :id_igreja) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":nome", $areceber->getNome() );
		$stmt->bindParam( ":valor", $areceber-> getValor() );
		$stmt->bindParam( ":data", $areceber->getData() );
		$stmt->bindParam( ":conta_credito", $areceber->getConta_credito() );
		$stmt->bindParam( ":conta_debito", $areceber->getConta_debito() );
		$stmt->bindParam( ":dizimo", $areceber->getDizimo() );
		$stmt->bindParam( ":id_pessoa", $areceber->getId_pessoa() );
		$stmt->bindParam( ":id_igreja", $areceber->getId_igreja() );
		// print_r($areceber);
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

		$sql = "select *,  DATE_FORMAT(data,'%d/%m/%Y') as dataf
					from areceber
					order by data ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function caixa_mes($mes, $ano) {

		$sql = "select a.*, DATE_FORMAT(a.data,'%d/%m/%Y') as dataf, a.data as vencimento,
		p.nome as nome_pessoa, p.cpf,
		cr.id as contacredito, cr.id_reduzido as contacredito_reduzido, cr.nome as nome_contacredito, 
		cc.id as contadebito, cc.id_reduzido as contadebito_reduzido, cc.nome as nome_contadebito
					from areceber a
					left join pessoa p on p.id = a.id_pessoa
					inner join conta_receita cr on cr.id = a.conta_credito
					inner join conta_caixa cc on cc.id = a.conta_debito
					where  MONTH(a.data) = :mes && YEAR(a.data) = :ano
					order by data ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function getPorId( $id ) {

		$sql = "select *, DATE_FORMAT(data,'%d/%m/%Y') as dataf from areceber where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$areceber = $stmt->fetch(PDO::FETCH_ASSOC);

		return $areceber;
	}

	public function alterar( $areceber ) {

		$sql = "update areceber set 
		nome = :nome, 
		valor = :valor,
		data = :data,
		conta_credito = :conta_credito,
		conta_debito = :conta_debito,
		dizimo = :dizimo,
		id_pessoa = :id_pessoa,
		id_igreja = :id_igreja
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $areceber->getId());
		$stmt->bindParam( ":nome", $areceber->getNome() );
		$stmt->bindParam( ":valor", $areceber-> getValor() );
		$stmt->bindParam( ":data", $areceber->getData() );
		$stmt->bindParam( ":conta_credito", $areceber->getConta_credito() );
		$stmt->bindParam( ":conta_debito", $areceber->getConta_debito() );
		$stmt->bindParam( ":dizimo", $areceber->getDizimo() );
		$stmt->bindParam( ":id_pessoa", $areceber->getId_pessoa() );
		$stmt->bindParam( ":id_igreja", $areceber->getId_igreja() );

		$result = $stmt->execute();
		// print_r($areceber);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from areceber where id = :id ";
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
