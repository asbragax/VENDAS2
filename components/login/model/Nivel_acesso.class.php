<?php

class Nivel_acesso{
	private $id_nivel;
	private $financeiro;
	private $usuario;
	private $aula;
	private $calendario;
	private $relatorios;
	private $membro;

	private $dao = "Nivel_acessoDAO";

	public function __construct(){
		$this->dao = new Nivel_acessoDAO();
	}

	public function getId_nivel(){
		return $this->id_nivel;
	}

	public function setId_nivel( $id_nivel ){
		$this->id_nivel = $id_nivel;
	}

	public function getFinanceiro(){
		return $this->financeiro;
	}

	public function setFinanceiro($financeiro){
		$this->financeiro = $financeiro;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	public function getAula(){
		return $this->aula;
	}

	public function setAula($aula){
		$this->aula = $aula;
	}

	public function getCalendario(){
		return $this->calendario;
	}

	public function setCalendario($calendario){
		$this->calendario = $calendario;
	}

	public function getRelatorios(){
		return $this->relatorios;
	}

	public function setRelatorios($relatorios){
		$this->relatorios = $relatorios;
	}

	public function getMembro(){
		return $this->membro;
	}

	public function setMembro($membro){
		$this->membro = $membro;
	}

	public function grava(){

		return $this->dao->cadastrar($this);
	}
}

?>
