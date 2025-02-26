<?php

#[AllowDynamicProperties] 
class Socio extends Model{
	/**
	 * Recupera los prestamos de un socio
	 *
	 * @return array lista de prestamos del socio
	 */
	public function getPrestamos():array{
		$consulta = "SELECT * FROM prestamos WHERE idsocio=$this->id";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'Prestamo');
	}
}