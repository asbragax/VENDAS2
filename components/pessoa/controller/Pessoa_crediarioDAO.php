<?php

ini_set('display_errors', 0 );
error_reporting(0);

class Pessoa_crediarioDAO{

	private $dao;
	private $CLASS_NAME = "Pessoa_crediario";

	public function __construct(){
              $this->dao = new Conexao();
	}

	public function pegaTimeStamp()
	{
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d H:i:s');
	}
	public function pegaDate()
	{
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d');
	}

  	public function cadastrar( $id_pessoa, $id_venda, $id_pag, $valor, $parcelado){

		  
		$sql = "insert into pessoa_crediario( id_pessoa, id_venda, id_pag, valor, parcelado)
		values ( :id_pessoa, :id_venda, :id_pag, :valor, :parcelado)";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id_pessoa", $id_pessoa);
		$stmt->bindParam(":id_venda", $id_venda);
		$stmt->bindParam(":id_pag", $id_pag);
		$stmt->bindParam(":valor", $valor);
		$stmt->bindParam(":parcelado", $parcelado);

		// echo $id_pessoa." ".$id_venda." ".$id_pag." ".$valor." ".$parcelado;
		
		$result = $stmt->execute();
		
		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
			
  	}

  	public function cadastrar_pagamento( $id, $data_pag, $forma_pag, $valor_pag, $flag ){

		$sql = "insert into crediario_pagamento( id_crediario, data_pag, forma_pag, valor_pag, flag, vencimento)
			values ( :id, :data_pag, :forma_pag, :valor_pag, :flag, :vencimento)";

		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":data_pag", $data_pag);
		$stmt->bindParam(":vencimento", $data_pag);
		$stmt->bindParam(":forma_pag", $forma_pag);
		$stmt->bindParam(":valor_pag", $valor_pag);
		$stmt->bindParam(":flag", $flag);

		// echo $id." ".$data_pag." ".$forma_pag." ".$valor_pag." ".$flag;
		
		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}

  	}

	public function relParcelas_dia($vendedor, $dtini, $dtfim) {
		$sql = "select cp.*, p.nome as nome_cliente,
		DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as data_pagf,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof
		from crediario_pagamento cp
		inner join pessoa_crediario pc on pc.id = cp.id_crediario
		inner join venda v on v.id = pc.id_venda
		left join pessoa p on p.id = v.cliente
		where v.vendedor = :vendedor
		&& cp.data_pag between :dtini and :dtfim 
		&& v.comissao = 1
		&& cp.flag = 1
		order by cp.data_pag";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":vendedor", $vendedor);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_parcelas($id) {
		$sql = "select cp.*, pp.nome as pagamento, p.nome,
		DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as data_pagf,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof
		from crediario_pagamento cp
		inner join pessoa_crediario pc on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		left join pagamento pp on pp.id = cp.forma_pag
		where cp.id_crediario = :id 
		order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_parcelas_abertas($crediario) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		where cp.flag = 0 && pc.id = :crediario
		order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":crediario", $crediario);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_parcelas_abertas_todas() {
		$sql = "select cp.*, p.nome, p.cpf, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof, m.nome as nome_vendedor
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		inner join venda v on v.id = pc.id_venda
		inner join members m on m.id = v.vendedor
		where cp.flag = 0 
		order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_emaberto_porcliente($cliente, $vendedor) {
		$sql = "select DISTINCT pc.*
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join venda v on v.id = pc.id_venda
		where cp.flag = 0 ";
		if($cliente != '*'){
			$sql .= " && pc.id_pessoa = :cliente ";
		}
		if($vendedor != '*'){
			$sql .= " && v.vendedor = :vendedor ";
		}

		$sql .= " order by pc.id";
		// echo $sql;
		$stmt = $this->dao->prepare($sql);
		if($cliente != '*'){
			$stmt->bindParam(":cliente", $cliente);
		}
		if($vendedor != '*'){
			$stmt->bindParam(":vendedor", $vendedor);
		}
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_vencidas($data) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof, m.nome as nome_vendedor
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		inner join venda v on v.id = pc.id_venda
		left join members m on m.id = v.vendedor
		where cp.flag = 0 && cp.vencimento < :data
		order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_vencendo_hoje($data) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof, m.nome as nome_vendedor
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		inner join venda v on v.id = pc.id_venda
		left join members m on m.id = v.vendedor
		where cp.flag = 0 && cp.vencimento = :data
		order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_vencidas_vendedor_cliente($data, $vendedor, $cliente) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof, m.nome as nome_vendedor
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		inner join venda v on v.id = pc.id_venda
		left join members m on m.id = v.vendedor
		where cp.flag = 0 && cp.vencimento < :data ";

		if($vendedor != '*'){
			$sql .= " && v.vendedor = '".$vendedor."' ";
		}
		if($cliente != '*'){
			$sql .= " && v.cliente = '".$cliente."' ";
		}

		$sql .= " order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_emaberto_vendedor_cliente($dtini, $dtfim, $vendedor, $cliente) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as vencimentof, pc.id_venda,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof, m.nome as nome_vendedor
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		inner join venda v on v.id = pc.id_venda
		left join members m on m.id = v.vendedor
		where cp.flag = 0 && cp.vencimento between :dtini and :dtfim ";

		if($vendedor != '*'){
			$sql .= " && v.vendedor = '".$vendedor."' ";
		}
		if($cliente != '*'){
			$sql .= " && v.cliente = '".$cliente."' ";
		}

		$sql .= " order by cp.vencimento";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar($id) {
		$sql = "select 
		cp.id_pessoa, cp.id_venda,
				cp.pag as pag_crediario, 
                cp.valor_pag, vp.valor, 
				DATE_FORMAT(v.data, '%d/%m/%Y') as dataf
					from pessoa_crediario cp 
					inner join venda v on v.id = cp.id_venda
					inner join venda_pagamento vp on vp.id_venda = v.id
					where id_pessoa = :id && vp.id_pagamento = 98
					order by v.data ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listar_30dias() {
		$sql = "SELECT DISTINCT p.nome as cliente, p.id as id_cliente, pc.valor_pag, v.valor, v.id
		from venda v 
		inner join pessoa_crediario pc on pc.id_venda = v.id
		inner join pessoa p on p.id = v.cliente
		left join crediario_pagamento cp on cp.id_crediario = pc.id
		where 
		(DATEDIFF(:hoje, cp.data_pag ) >= 30
		&&
		pc.pag < 2 ) ||
		(DATEDIFF(:hoje, v.data ) >= 30
		&&
		pc.pag = 0)";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":hoje", $this->pegaDate());
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function listarPorDia($data) {

		$sql = "select COALESCE(sum(cp.valor_pag), 0) as valor
		from crediario_pagamento cp
		where cp.data_pag = :data
		group by cp.data_pag";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetch(PDO::FETCH_ASSOC);

		return $lista;
	}


	public function getPorId($id_pessoa, $id_venda) {
		$sql = "select cp.id, cp.pag as pag_crediario, cp.valor_pag,
		 cp.valor, cp.valor as crediario, v.data,
		DATE_FORMAT(v.data, '%d/%m/%Y') as dataf, p.nome
		from pessoa_crediario cp 
		inner join venda v on v.id = cp.id_venda
		inner join pessoa p on p.id = cp.id_pessoa
			where id_pessoa = :id_pessoa && id_venda = :id_venda";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id_pessoa", $id_pessoa);
		$stmt->bindParam(":id_venda", $id_venda);
		$stmt->execute();

		$lista = $stmt->fetch(PDO::FETCH_ASSOC);

		return $lista;
	}

	
	public function getUmaParcela($id) {
		$sql = "select cp.*, p.nome, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as data_pagf, pc.id_venda, pc.id_pessoa, pc.valor as valor_total, pc.valor_pag as valor_pago, pp.nome as pagamento,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof
		from pessoa_crediario pc
		inner join crediario_pagamento cp on cp.id_crediario = pc.id
		inner join pessoa p on p.id = pc.id_pessoa
		left join pagamento pp on pp.id = cp.forma_pag
		where cp.id = :id";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetch(PDO::FETCH_ASSOC);
	
		return $lista;
	}


	public function getPagamentos($id) {
		$sql = "select cp.*,
		DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as data_pagf,
		pp.nome,
		DATE_FORMAT(cp.vencimento, '%d/%m/%Y') as vencimentof
		from crediario_pagamento cp
		inner join pagamento pp on pp.id = cp.forma_pag
		where cp.id_crediario = :id";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function caixa_semana($dtini, $dtfim)
    {
            $sql = "select v.id as id_venda, v.vendedor, v.comissao, 
			p.nome, cp.*, pc.id_pessoa, DATE_FORMAT(cp.data_pag, '%d/%m/%Y') as data_pagf, 
			pp.nome as nome_pagamento
            from venda v
			inner join pessoa p on p.id = v.cliente
			inner join pessoa_crediario pc on pc.id_venda = v.id
			inner join crediario_pagamento cp on cp.id_crediario = pc.id
			inner join pagamento pp on pp.id = cp.forma_pag
            where 
            cp.data_pag between :dtini and :dtfim 
            && cp.flag = 1";
        
            $stmt = $this->dao->prepare($sql);
            $stmt->bindParam(":dtini", $dtini);
            $stmt->bindParam(":dtfim", $dtfim);
            $stmt->execute();
        
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $lista;
    }

	public function alterar( $id, $pag, $valor_pag){

		$sql = "update pessoa_crediario set
					pag = :pag, 
					valor_pag = :valor_pag
					where id = :id  ";

		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":valor_pag", $valor_pag);
		$stmt->bindParam(":pag", $pag);

		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}

	public function alterar_pagamento( $id, $valor_pag, $data_pag, $forma_pag, $flag, $obs, $juros){

		$sql = "update crediario_pagamento set
					valor_pag = :valor_pag, 
					forma_pag = :forma_pag, 
					data_pag = :data_pag,
					juros = :juros,
					observacao = :obs,
					flag = :flag
					where id = :id";

		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":valor_pag", $valor_pag);
		$stmt->bindParam(":forma_pag", $forma_pag);
		$stmt->bindParam(":data_pag", $data_pag);
		$stmt->bindParam(":juros", $juros);
		$stmt->bindParam(":obs", $obs);
		$stmt->bindParam(":flag", $flag);

		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}

	public function alterar_pagamento2( $id, $valor_pag, $vencimento, $data_pag, $forma_pag, $flag, $obs, $juros){

		$sql = "update crediario_pagamento set
					valor_pag = :valor_pag, 
					forma_pag = :forma_pag, 
					data_pag = :data_pag,
					vencimento = :vencimento,
					juros = :juros,
					observacao = :obs,
					flag = :flag
					where id = :id";

		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":valor_pag", $valor_pag);
		$stmt->bindParam(":forma_pag", $forma_pag);
		$stmt->bindParam(":data_pag", $data_pag);
		$stmt->bindParam(":vencimento", $vencimento);
		$stmt->bindParam(":juros", $juros);
		$stmt->bindParam(":obs", $obs);
		$stmt->bindParam(":flag", $flag);

		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}


	public function excluir( $id_venda ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from pessoa_crediario where id_venda = :id_venda";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id_venda", $id_venda);

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

	public function excluir_todos( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from pessoa_crediario where id_pessoa = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

	public function salvarParcelasEditadas($id_crediario, $forma_pag, $valor_pag, $data_pag, $vencimento, $flag = 1)
    {

		// echo $id_crediario." ".$num." ".$valor." ".$vencimento." ".$pag." ".$data_pag." ".$user_pag;
        $sql = "insert into crediario_pagamento
		( id_crediario, valor_pag, forma_pag, data_pag, flag, vencimento)
				values
		( :id_crediario, :valor_pag, :forma_pag, :data_pag, :flag, :vencimento)";

        $this->dao->beginTransaction();
        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":id_crediario", $id_crediario);
        $stmt->bindParam(":valor_pag", $valor_pag);
        $stmt->bindParam(":forma_pag", $forma_pag);
		if($data_pag != ''){
			$stmt->bindParam(":data_pag", $data_pag);
		}else{
			$stmt->bindParam(":data_pag", $vencimento);
		}
        $stmt->bindParam(":vencimento", $vencimento);
        $stmt->bindParam(":flag", $flag);
        $result = $stmt->execute();

        if ($result) {
            $this->dao->commit();
            return "true";
        } else {
            $this->dao->rollback();
            return "";
        }
    }

	public function excluir_parcelas( $id ) {

		if ( !$this->dao->inTransaction() ) {
			$this->dao->beginTransaction();
		};

		$sql = "delete from crediario_pagamento where id_crediario = :id ";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

		$stmt->execute();
		$this->dao->commit();

		$res = $stmt->rowCount();

		return $res;
	}

	public function getUltimo()
    {

        $sql = "show table status like 'pessoa_crediario'";
        $stmt = $this->dao->query($sql);

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        return $id;
    }
}
