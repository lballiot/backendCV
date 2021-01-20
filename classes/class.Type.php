<?php

require_once('class.Projet.php');

class Type implements JsonSerializable{

	private $id = 0;
	private $nom_type = null;

	private $lesProjets = array();
	
	public function __construct($id, $nom_type){
		$this->id = $id;
		$this->nom_type = $nom_type;
	}

	// Getters
	public function getId() {return $this->id;}
	public function getNomType() {return $this->nom_type;}

	public function getLesProjets() {return $this->lesProjets;}

	// Setters
	public function setId($id) {$this->id = $id;}
	public function setNomType($nom_type) {$this->nom_type = $nom_type;}

	public function setLesProjets($lesProjets) {$this->lesProjets = $lesProjets;}

	public function jsonSerialize(){ return get_object_vars($this); }

}

?>