<?php
abstract class Vehiculo{
	//PROIPIEDADES
	public $marca, $modelo;
	
//CONSTRUCTOR
	public function __Constructor (String $marca, String $modelo){
	 	$this-> marca = $marca;
	 	$this-> modelo = $modelo;
	}
	
	public abstract function arrancar ();
	
	public function __toString(){
		return "$this->marca $this->modelo";
	}
}