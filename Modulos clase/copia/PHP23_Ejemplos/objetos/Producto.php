<?php
class Producto {
	public $nombre, $precio;
	
	public function __construct(string $nombre='', float $precio=0){
		$this->nombre = $nombre;
		$this->precio = $precio;
	}
	
	public function __toString(){
		return "PRODUCTO: $this->nombre a $this->precio &euro;";
	}
}
