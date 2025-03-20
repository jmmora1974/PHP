<?php
class Coche extends Vehiculo{
	public function arrancar(){
		echo "BRUM BRUM";
	}
	
	public function __toString() {
		return "COCHE: ".parent::__toString();
	}
}