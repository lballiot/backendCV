<?php

	require_once('class.Projet.php');

class Notion implements JsonSerializable{

	private $id = 0;
	private $nom_notion = null;

	private $lesProjets = array();
	
	public function __construct($id, $nom_notion){
		$this->id = $id;
		$this->nom_notion = $nom_notion;
	}

	// Getters
	public function getId() {return $this->id;}
	public function getNomCompetence() {return $this->nom_notion;}

	public function getLesProjets() {return $this->lesProjets;}

	// Setters
	public function setId($id) {$this->id = $id;}
	public function setNomCompetence($nom_notion) {$this->nom_notion = $nom_notion;}

	public function setLesProjets($lesProjets) {$this->lesProjets = $lesProjets;}

	public function jsonSerialize(){ return get_object_vars($this); }

}
?>