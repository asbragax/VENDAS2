<?php
error_reporting(0);
class ApagarDAO{

	private $dao;
	private $CLASS_NAME = "Apagar";

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

	public function cadastrar( $apagar ){

		$sql = "insert into apagar
		(valor, data, vencimento, prestacao, valorprestacao, fornecedor, forma_pag, arquivo_nota, arquivo_boleto, nome) 
		values 
		( :valor, :data, :vencimento, :prestacao, :valorprestacao, :fornecedor, :forma_pag, :arquivo_nota, :arquivo_boleto, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":valor", $apagar->getValor() );
		$stmt->bindParam( ":data", $apagar->getData() );
		$stmt->bindParam( ":vencimento", $apagar->getVencimento() );
		$stmt->bindParam( ":prestacao", $apagar->getPrestacao() );
		$stmt->bindParam( ":valorprestacao", $apagar->getValorPrestacao() );
		$stmt->bindParam( ":fornecedor", $apagar->getFornecedor() );
		$stmt->bindParam( ":forma_pag", $apagar->getForma_pag() );
		$stmt->bindParam( ":arquivo_nota", $apagar->getArquivo_nota() );
		$stmt->bindParam( ":arquivo_boleto", $apagar->getArquivo_boleto() );
		$stmt->bindParam( ":nome", $apagar->getNome() );
		// print_r($apagar);
		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}

	public function cadastrar_paga( $apagar ){

		$sql = "insert into apagar
		( valor, data, vencimento, status, data_pag, forma_pag, conta_pag, prestacao, valorprestacao, fornecedor, arquivo_nota, arquivo_boleto, arquivo_recibo, nome) 
		values 
		( :valor, :data, :vencimento, 1, :data_pag, :forma_pag, :conta_pag, :prestacao, :valorprestacao, :fornecedor, :arquivo_nota, :arquivo_boleto, :arquivo_recibo, :nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":valor", $apagar->getValor() );
		$stmt->bindParam( ":data", $apagar->getData() );
		$stmt->bindParam( ":vencimento", $apagar->getVencimento() );
		$stmt->bindParam( ":prestacao", $apagar->getPrestacao() );
		$stmt->bindParam( ":valorprestacao", $apagar->getValorPrestacao() );
		$stmt->bindParam( ":fornecedor", $apagar->getFornecedor() );
		$stmt->bindParam( ":forma_pag", $apagar->getForma_pag() );
		$stmt->bindParam( ":conta_pag", $apagar->getConta_pag() );
		$stmt->bindParam( ":data_pag", $apagar->getData_pag() );
		$stmt->bindParam( ":arquivo_nota", $apagar->getArquivo_nota() );
		$stmt->bindParam( ":arquivo_boleto", $apagar->getArquivo_boleto() );
		$stmt->bindParam( ":arquivo_recibo", $apagar->getArquivo_recibo() );
		$stmt->bindParam( ":nome", $apagar->getNome() );
		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}

	public function cadastrar_parcela( $id, $num, $valor, $vencimento ){

		$sql = "insert into apagar_parcela
		(id_apagar, num, valor, vencimento) 
		values 
		( :id, :num, :valor, :vencimento) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $id );
		$stmt->bindParam( ":num", $num );
		$stmt->bindParam( ":valor", $valor );
		$stmt->bindParam( ":vencimento", $vencimento );

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

		$sql = "select *,  DATE_FORMAT(vencimento,'%d/%m/%Y') as vencimentof
					from apagar
					where status = 0
					order by vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_abertas() {

		$sql = "select a.*,  DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof
					from apagar a 
					where a.status = 0 && a.forma_pag = 1
					order by a.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_parcelas_abertas_mes($mes, $ano) {

		$sql = "select a.*,  DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, ap.num, ap.valor, ap.id as id_parcela, f.nome as nome_fornecedor
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					left join fornecedor f on f.id = a.fornecedor
					where ap.status = 0 && MONTH(ap.vencimento) = :mes && YEAR(ap.vencimento) = :ano
					order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_parcelas_abertas() {

		$sql = "select a.*,  DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, ap.num, ap.valor, ap.id as id_parcela, f.nome as nome_fornecedor
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					left join fornecedor f on f.id = a.fornecedor
					where ap.status = 0
					order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_parcelas_abertas_recentes($data) {

		$sql = "select a.*,  DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, ap.num, ap.valor, ap.id as id_parcela,
		f.nome as nome_fornecedor
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					left join fornecedor f on f.id = a.fornecedor
					where ap.status = 0 && DATEDIFF(:data, ap.vencimento ) >= -1 && DATEDIFF(:data, ap.vencimento ) <= 0
					order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_pagas_periodo($dtini, $dtfim, $fp, $fn) {

		$sql = "select a.*, a.forma_pag as tipo,
		DATE_FORMAT(a.data_pag,'%d/%m/%Y') as vencimentof,
		m.nome as nome_fornecedor, pp.nome as nome_pagamento
					from apagar a
					left join fornecedor m on m.id = a.fornecedor
					left join pagamento pp on pp.id = a.conta_pag
					where a.forma_pag = 1 
					&& a.data_pag between :dtini and :dtfim";

		if($fp != '*'){
			$sql .= " && a.conta_pag = '".$fp."'";
		}
		if($fn != '*'){
			$sql .= " && a.fornecedor = '".$fn."'";
		}
		$sql .= " order by a.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_pagas() {

		$sql = "select a.*, 
		DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof, 
		DATE_FORMAT(a.data_pag,'%d/%m/%Y') as pagamentof
					from apagar a 
					where a.status = 1 && a.forma_pag = 1
					order by a.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}
	
	public function listar_pagas_mes($mes, $ano) {

		$sql = "select a.*, 
		DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof, 
		DATE_FORMAT(a.data_pag,'%d/%m/%Y') as pagamentof
					from apagar a 
					where a.status = 1 && a.forma_pag = 1
					&& MONTH(a.data_pag) = :mes && YEAR(a.data_pag) = :ano 
					order by a.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}
	
	public function listar_parcelas_abertas_periodo($dtini, $dtfim, $fn) {

		$sql = "select a.*,  DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, ap.num, ap.valor, ap.id as id_parcela,
					f.nome as nome_fornecedor
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					inner join fornecedor f on f.id = a.fornecedor
					where ap.status = 0
					&& ap.vencimento between :dtini and :dtfim ";
		if($fn != '*'){
			$sql .= " && a.fornecedor = '".$fn."'"; 
		}

		$sql .= " order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_parcelas_pagas_periodo($dtini, $dtfim, $fp, $fn) {

		$sql = "select a.*, a.forma_pag as tipo,
		DATE_FORMAT(ap.data_pag,'%d/%m/%Y') as vencimentof, 
		ap.num, ap.valor, m.nome as nome_fornecedor, pp.nome as nome_pagamento
		from apagar a 
		inner join apagar_parcela ap on ap.id_apagar = a.id
		inner join fornecedor m on m.id = a.fornecedor
		inner join pagamento pp on pp.id = ap.conta_pag
		where ap.status = 1 
		&& ap.data_pag between :dtini and :dtfim";
		if($fp != '*'){
			$sql.= " && ap.conta_pag = '".$fp."'";		
		}
		if($fn != '*'){
			$sql.= " && a.fornecedor = '".$fn."'";		
		}
		$sql .= " order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function listar_parcelas($id) {

		$sql = "select *
					from apagar_parcela
					where id_apagar = :id
					order by num ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}



	public function listar_parcelas_pagas() {

		$sql = "select a.*,  
		DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, 
		DATE_FORMAT(ap.data_pag,'%d/%m/%Y') as pagamentof, 
		ap.num, ap.valor, 
		i.nome as nome_igreja,
		cc.nome as nome_conta
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					inner join igreja i on i.id = a.igreja
					inner join conta_caixa cc on cc.id = ap.conta_pag
					where a.status = 1
					order by ap.vencimento ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}
	public function listar_parcelas_pagas_mes($mes, $ano) {

		$sql = "select a.*,  
		DATE_FORMAT(ap.vencimento,'%d/%m/%Y') as vencimentof, 
		DATE_FORMAT(ap.data_pag,'%d/%m/%Y') as pagamentof, 
		ap.num, ap.valor
					from apagar a 
					inner join apagar_parcela ap on ap.id_apagar = a.id
					where ap.status = 1 && MONTH(ap.data_pag) = :mes && YEAR(ap.data_pag) = :ano 
					order by ap.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}

	public function caixa_dia_avista($data) {

		$sql = "select a.*, DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(a.data_pag,'%d/%m/%Y') as data_pagf,
				f.nome as nome_fornecedor, f.cnpj, pp.nome as nome_forma_pagamento
					from apagar a
					left join fornecedor f on f.id = a.fornecedor
					inner join pagamento pp on pp.id = a.conta_pag
					where  a.data_pag = :data 
					&& forma_pag = 1
					order by data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}
	public function caixa_mes_avista($mes, $ano) {
        $sql = "select a.*, DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(a.data_pag,'%d/%m/%Y') as data_pagf,
		f.nome as nome_fornecedor, f.cnpj, pp.nome as nome_forma_pagamento
			from apagar a
			left join fornecedor f on f.id = a.fornecedor
			inner join pagamento pp on pp.id = a.conta_pag
					where  MONTH(data_pag) = :mes 
					&& YEAR(data_pag) = :ano
					&& forma_pag = 1
					order by data_pag ASC";

        $stmt = $this->dao->prepare($sql);
        $stmt->bindParam(":mes", $mes);
        $stmt->bindParam(":ano", $ano);
        $stmt->execute();

        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
	}
	
	public function caixa_semana_avista($dtini, $dtfim) {

		$sql = "select a.*, DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(a.data_pag,'%d/%m/%Y') as data_pagf,
		f.nome as nome_fornecedor, f.cnpj, pp.nome as nome_forma_pagamento
			from apagar a
			left join fornecedor f on f.id = a.fornecedor
			inner join pagamento pp on pp.id = a.conta_pag
					where data_pag between :dtini and :dtfim 
					&& forma_pag = 1
					order by data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function caixa_semana_aprazo($dtini, $dtfim) {

		$sql = "select a.*, DATE_FORMAT(p.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(p.data_pag,'%d/%m/%Y') as data_pagf, p.valor, 
				p.id as id_parcela, p.status, p.conta_pag,
				f.nome as nome_fornecedor, pp.nome as nome_forma_pagamento
					from apagar a
					left join fornecedor f on f.id = a.fornecedor
					inner join apagar_parcela p on p.id_apagar = a.id
					inner join pagamento pp on pp.id = p.conta_pag
					where p.data_pag between :dtini and :dtfim
					&& a.forma_pag = 2
					order by p.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":dtini", $dtini);
		$stmt->bindParam(":dtfim", $dtfim);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function caixa_mes_aprazo($mes, $ano) {

		$sql = "select a.*, DATE_FORMAT(p.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(p.data_pag,'%d/%m/%Y') as data_pagf, p.valor, 
				p.id as id_parcela, p.status, p.conta_pag,
				f.nome as nome_fornecedor, f.cnpj, pp.nome as nome_forma_pagamento
					from apagar a
					left join fornecedor f on f.id = a.fornecedor
					inner join apagar_parcela p on p.id_apagar = a.id
					inner join pagamento pp on pp.id = p.conta_pag
					where  MONTH(p.data_pag) = :mes 
					&& YEAR(p.data_pag) = :ano
					&& a.forma_pag = 2
					order by p.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":mes", $mes);
		$stmt->bindParam(":ano", $ano);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}
	public function caixa_dia_aprazo($data) {

		$sql = "select a.*, DATE_FORMAT(p.vencimento,'%d/%m/%Y') as vencimentof, DATE_FORMAT(p.data_pag,'%d/%m/%Y') as data_pagf, p.valor, 
				p.id as id_parcela, p.status, p.conta_pag,
				f.nome as nome_fornecedor, f.cnpj, pp.nome as nome_forma_pagamento
					from apagar a
					left join fornecedor f on f.id = a.fornecedor
					inner join apagar_parcela p on p.id_apagar = a.id
					inner join pagamento pp on pp.id = p.conta_pag
					where p.data_pag  = :data
					&& a.forma_pag = 2
					order by p.data_pag ASC";

		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":data", $data);
		$stmt->execute();

		$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $lista;
	}

	public function getPorId( $id ) {

		$sql = "select * from apagar where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();

		$apagar = $stmt->fetch(PDO::FETCH_ASSOC);

		return $apagar;
	}

	public function getPorIdDetails($id)
	{

		$sql = "select a.id, a.nome, a.valor,
		a.data as dataf, a.prestacao, a.vencimento as vencimentof,
		a.numprestacao, a.valorprestacao,
		DATE_FORMAT(a.vencimento,'%d/%m/%Y') as vencimento,
		DATE_FORMAT(a.data,'%d/%m/%Y') as data,
		DATE_FORMAT(a.data_pag,'%d/%m/%Y às %H:%i:%s') as data_pag,
		a.status, a.data_pag as data_pagf, a.forma_pag, m.nome as barbeiro
		FROM apagar a
		inner join members m on m.id = a.barbeiro
		where a.id = :id";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$apagar = $stmt->fetch(PDO::FETCH_ASSOC);

		return $apagar;
	}

	public function getPorIdDetailsParcela($id)
	{

		$sql = "select a.*, DATE_FORMAT(p.vencimento,'%d/%m/%Y') as vencimentof, p.data_pag, 
		p.valor, p.id as id_parcela, p.num,
		DATE_FORMAT(p.data_pag,'%d/%m/%Y') as data_pagf, p.status, p.arquivo_recibo, p.forma_pag, p.conta_pag,
		f.nome as nome_fornecedor
			from apagar a
			left join fornecedor f on f.id = a.fornecedor
			inner join apagar_parcela p on p.id_apagar = a.id
			where  p.id = :id";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

		$apagar = $stmt->fetch(PDO::FETCH_ASSOC);

		return $apagar;
	}

	public function alterar( $apagar ) {

		$sql = "update apagar set 
		valor = :valor,
		data_pag = :data_pag,
		vencimento = :vencimento,
		data = :data,
		status = :status,
		forma_pag = :forma_pag, 
		prestacao = :prestacao, 
		valorprestacao = :valorprestacao, 
		arquivo_nota = :arquivo_nota,
		arquivo_boleto = :arquivo_boleto,
		arquivo_recibo = :arquivo_recibo,
		fornecedor = :fornecedor, 
		nome = :nome
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $apagar->getId());
		$stmt->bindParam(":valor", $apagar->getValor());
		$stmt->bindParam(":data", $apagar->getData());
		$stmt->bindParam(":vencimento", $apagar->getVencimento());
		$stmt->bindParam( ":prestacao", $apagar->getPrestacao() );
		$stmt->bindParam( ":valorprestacao", $apagar->getValorPrestacao() );
		$stmt->bindParam( ":fornecedor", $apagar->getFornecedor() );
		$stmt->bindParam(":forma_pag", $apagar->getForma_pag() );
		$stmt->bindParam(":data_pag", $apagar->getData_pag() );
		$stmt->bindParam( ":arquivo_nota", $apagar->getArquivo_nota() );
		$stmt->bindParam( ":arquivo_boleto", $apagar->getArquivo_boleto() );
		$stmt->bindParam( ":arquivo_recibo", $apagar->getArquivo_recibo() );
		$stmt->bindParam( ":nome", $apagar->getNome() );
		$stmt->bindParam(":status", $apagar->getStatus() );
		$result = $stmt->execute();
		// print_r($apagar);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}
	public function alterar_prestacao( $id, $id_apagar, $num, $valor, $vencimento, $status ) {

		$sql = "update apagar_parcela set 
		id_apagar = :id_apagar,
		num = :num,
		valor = :valor,
		vencimento = :vencimento,
		status = :status
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":id_apagar", $id_apagar);
		$stmt->bindParam(":num", $num);
		$stmt->bindParam(":valor", $valor);
		$stmt->bindParam(":vencimento", $vencimento);
		$stmt->bindParam(":status", $status);
		$result = $stmt->execute();
		// print_r($apagar);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function pagar_prestacao( $id, $forma_pag, $conta_pag, $data_pag, $arquivo_recibo, $status ) {

		$sql = "update apagar_parcela set 
		forma_pag = :forma_pag,
		conta_pag = :conta_pag,
		data_pag = :data_pag,
		status = :status,
		arquivo_recibo = :arquivo_recibo
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":forma_pag", $forma_pag);
		$stmt->bindParam(":conta_pag", $conta_pag);
		$stmt->bindParam(":data_pag", $data_pag);
		$stmt->bindParam(":arquivo_recibo", $arquivo_recibo);
		$stmt->bindParam(":status", $status);
		$result = $stmt->execute();
		// print_r($apagar);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function diminuir_prestacao( $id ) {

		if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

		$sql = "update apagar set 
		prestacao = (prestacao-1 )
		where id = :id ";
		
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);

		$result = $stmt->execute();
		// print_r($apagar);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}


		return $result;
	}

	public function reorganizar_parcela( $id_apagar, $num) {

		if (!$this->dao->inTransaction()) {
            $this->dao->beginTransaction();
        };

		$sql = "update apagar_parcela set 
		num = (num-1)
		where id_apagar = :id_apagar && num > :num";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id_apagar", $id_apagar);
		$stmt->bindParam(":num", $num);
		

		$result = $stmt->execute();
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}

		return $result;
	}

	public function excluir_parcela( $id ) {

		$sql = "delete from apagar_parcela where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();
		$this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
	}

	public function excluir( $id ) {

		$sql = "delete from apagar_parcela where id_apagar = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();
		$this->dao->commit();
		
		$sql = "delete from apagar where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
	}

	public function getUltimo()
    {


        $sql = "show table status like 'apagar'";
        $stmt = $this->dao->query($sql);

        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        return $info;
    }

}

?>
