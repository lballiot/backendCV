<?php

require_once('class.Type.php');
require_once('class.Competence.php');
require_once('class.Notion.php');

class Projet implements JsonSerializable{

	private $id = 0; 
	private $nom = null;
	private $date = null; 
	private $image = null;

	private $leTypeDuProjet = null;
	private $lesCompetencesUtilises = array();
	private $lesNotionsTraitees = array();

	public function __construct($id, $nom, $date, $image){
		$this->id = $id;
		$this->nom = $nom;
		$this->date = $date;
		$this->image = $image;
	}

	// Getters
	public function getId() {return $this->id;}
	public function getNom() {return $this->nom;}
	public function getDate() {return $this->date;}
	public function getImage() {return $this->image;}

	public function getLeTypeDuProjet() {return $this->leTypeDuProjet;}
	public function getLesCompetencesUtilises() {return $this->lesCompetencesUtilises;}
	public function getLesNotionsTraitees() {return $this->lesNotionsTraitees;}

	// Setters
	public function setId($id) {$this->id = $id;}
	public function setNom($nom) {$this->nom = $nom;}
	public function setDate($date) {$this->date = $date;}
	public function setImage($image) {$this->image = $image;}

	public function setLeTypeDuProjet($leTypeDuProjet) {$this->leTypeDuProjet = $leTypeDuProjet;}
	public function setLesCompetencesUtilises($lesCompetencesUtilises) {$this->lesCompetencesUtilises = $lesCompetencesUtilises;}
	public function setLesNotionsTraitees($lesNotionsTraitees) {$this->lesNotionsTraitees = $lesNotionsTraitees;}

	
	public function jsonSerialize(){ return get_object_vars($this); }

}

?>