<?php

class Post{
	private $id;
	private $img;
	private $texto;
	private $dao = "PostDAO";

	public function __Construct(){
		$this->dao = new PostDAO();
	}

	public function getId(){
		return $this->id;
	}

	public function setId( $id ){
		$this->id = $id;
	}

	public function getImg(){
		return $this->img;
	}

	public function setImg($img){
		$this->img = $img;
	}


	public function getTexto(){
		return $this->texto;
	}

	public function setTexto($texto){
		$this->texto = $texto;
	}


	public function grava(){
		return $this->dao->cadastrar($this);
	}
}

?>
