<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class V_socio extends Model{
	/**
	 * Recupera los prestamos de un socio
	 *
	 * @return array lista de prestamos del socio
	 */
	public function getPrestamos():array{
		$consulta = "SELECT * FROM V_socios WHERE id=$this->id";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_socio');
	}
	

	
}