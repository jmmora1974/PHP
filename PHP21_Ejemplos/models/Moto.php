<?php
class Moto extends Vehiculo{
	public function arrancar(){
		echo "BRAAAAM BRAAAM";
	}
	
	public function __toString() {
		return "MOTO: ".parent::__toString();
	}
}