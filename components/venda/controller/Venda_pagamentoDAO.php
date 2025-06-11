<?php

//ini_set('display_errors', 0 );
//error_reporting(0);

class Venda_pagamentoDAO{

	private $dao;

	public function __construct(){
              $this->dao = new Conexao();
	}

	public function pegaTimeStamp()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d H:i:s');
	}
	
	public function pegaData()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d');
    }

  	public function cadastrar($id_venda, $id_pagamento, $valor){
		$sql = "insert into venda_pagamento 
		( id_venda, id_pagamento, valor, time)
			values 
		( :id_venda, :id_pagamento, :valor, :time)";

		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id_venda", $id_venda);
		$stmt->bindParam(":id_pagamento", $id_pagamento);
		$stmt->bindParam(":valor", $valor);
		$stmt->bindParam(":time", $this->pegaTimeStamp());
		$result = $stmt->execute();

		if ( $result ) {
		$this->dao->commit();
		return "true";
		} else {
		$this->dao->rollback();
		return "";
		}

	}

	public function listar_migration($id) {

		$sql = "select pp.*, p.nome, DATE_FORMAT(pp.time,'%d/%m/%Y às %H:%i') as timef
					from venda_pagamento pp
					left join pagamento p on p.id = pp.id_pagamento
					where id_venda = :id && pp.id_pagamento = 98
					order by time DESC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetch(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function relParcelas_dia($vendedor, $dtini, $dtfim) {
		$sql = "select vp.*, p.nome as nome_cliente,
		DATE_FORMAT(v.data, '%d/%m/%Y') as dataf
		from venda_pagamento vp
		inner join venda v on v.id = vp.id_venda
		left join pessoa p on p.id = v.cliente
		where v.vendedor = :vendedor
		&& v.data between :dtini and :dtfim 
		&& v.comissao = 1
		&& v.prevenda = 0
		&& vp.id_pagamento < 90
		order by v.data";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":vendedor", $vendedor);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar($id) {

		$sql = "select pp.*, p.nome, DATE_FORMAT(pp.time,'%d/%m/%Y às %H:%i') as timef
					from venda_pagamento pp
					left join pagamento p on p.id = pp.id_pagamento
					where id_venda = :id
					order by time DESC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listarSemCrediario($id) {

		$sql = "select pp.*, p.nome, DATE_FORMAT(pp.time,'%d/%m/%Y às %H:%i') as timef
					from venda_pagamento pp
					left join pagamento p on p.id = pp.id_pagamento
					where id_venda = :id && pp.id_pagamento < 90
					order by time DESC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listarPorDia($data) {

		$sql = "select COALESCE(sum(pp.valor), 0) as valor
		from venda_pagamento pp
		inner join venda v on v.id = pp.id_venda
		where v.data = :data && pp.id_pagamento != 98
		group by v.data";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetch(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function excluir( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from venda_pagamento where id = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

	public function excluir_todos( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from venda_pagamento where id_venda = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

	
    public function getUltimo()
    {

        $sql = "show table status like 'venda_pagamento'";
        $stmt = $this->dao->query($sql);

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }

}
