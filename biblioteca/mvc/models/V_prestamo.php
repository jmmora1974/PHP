<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class V_prestamo extends Model{
	/**
	 * Recupera los prestamos de un socio
	 *
	 * @return array lista de prestamos del socio
	 */
	public function getPrestamos():array{
		$consulta = "SELECT * FROM V_prestamos WHERE idsocio=$this->id ORDER BY prestamo DESC ";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_prestamo');
	}
	
	
}