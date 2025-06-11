<?php
error_reporting(0);
class SubcategoriaDAO{

	private $dao;
	private $CLASS_NAME = "Subcategoria";

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

	public function cadastrar( $subcategoria ){

		$sql = "insert into subcategoria
		(nome) 

		values 

		(:nome) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":nome", $subcategoria->getNome() );
		$result = $stmt->execute();

		if ( $result ) {
			$this->dao->commit();
			return "true";
		} else {
			$this->dao->rollback();
			return "";
		}
	}
	public function vincular_categoria( $id, $sub ){

		$sql = "insert into categoria_subcategoria
		(id_categoria, id_subcategoria) 
		values 
		(:id, :sub) ";

		$this->dao->beginTransaction();

		$stmt = $this->dao->prepare( $sql );
		$stmt->bindParam( ":id", $id );
		$stmt->bindParam( ":sub", $sub );
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
					from subcategoria
					order by id";

		$stmt = $this->dao->prepare($sql);
		$stmt->execute();

		$linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $linha;
	}


	public function listarPorCategoria( $id ) {

		$sql = "select sc.*, s.id, s.nome 
		from categoria_subcategoria sc
		inner join subcategoria s on s.id = sc.id_subcategoria
		where id_categoria = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$subcategoria = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $subcategoria;
	}

	public function listarPorCategoriaSelect( $id ) {

		$sql = "select sc.id_subcategoria as id, s.nome as text
		from categoria_subcategoria sc
		inner join subcategoria s on s.id = sc.id_subcategoria
		where id_categoria = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$subcategoria = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $subcategoria;
	}

	public function getPorId( $id ) {

		$sql = "select * from subcategoria where id = :id ";
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();


		$subcategoria = $stmt->fetch(PDO::FETCH_ASSOC);

		return $subcategoria;
	}


	public function alterar( $subcategoria ) {

		$sql = "update subcategoria set 
		nome = :nome
		where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam( ":id", $subcategoria->getId() );
		$stmt->bindParam( ":nome", $subcategoria->getNome() );
		$result = $stmt->execute();
		// print_r($subcategoria);
		if ( $result ) {
			$this->dao->commit();
		} else {
			$this->dao->rollback();
		}
		return $result;
	}

	public function excluir( $id ) {

		$sql = "delete from subcategoria where id = :id ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
	}

	public function desvincular_categoria( $id, $sub ) {

		$sql = "delete from categoria_subcategoria where id_categoria = :id && id_subcategoria = :sub ";
		$this->dao->beginTransaction();
		$stmt = $this->dao->prepare($sql);
		$stmt->bindParam(":id", $id );
		$stmt->bindParam(":sub", $sub );

        $stmt->execute();
        $this->dao->commit();

        $res = $stmt->rowCount();

        return $res;
	}

	public function getUltimo()
    {


        $sql = "show table status like 'subcategoria'";
        $stmt = $this->dao->query($sql);

        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        return $info;
    }

}

?>
