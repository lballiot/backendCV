<?php

	require_once('class.Projet.php');

class Competence implements JsonSerializable{

	private $id = 0;
	private $nom_competence = null;

	private $lesProjets = array();
	
	public function __construct($id, $nom_competence){
		$this->id = $id;
		$this->nom_competence = $nom_competence;
	}

	// Getters
	public function getId() {return $this->id;}
	public function getNomCompetence() {return $this->nom_competence;}

	public function getLesProjets() {return $this->lesProjets;}

	// Setters
	public function setId($id) {$this->id = $id;}
	public function setNomCompetence($nom_competence) {$this->nom_competence = $nom_competence;}

	public function setLesProjets($lesProjets) {$this->lesProjets = $lesProjets;}

	public function jsonSerialize(){ return get_object_vars($this); }

}
?>