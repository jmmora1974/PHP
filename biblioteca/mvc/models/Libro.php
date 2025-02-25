<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Libro extends Model{
	/**
	 * Recupera los ejemplares de un libro 
	 * 
	 * @return array lista de ejemplares del libro
	 */
	public function getEjemplares():array{
		$consulta = "SELECT * FROM ejemplares WHERE idlibro=$this->id";
		
		//Retorna una lista de Ejemplar
		return DBMysqli::selectAll($consulta,'Ejemplar');
	}
	
}