<?php
//carga la vista de lugar y usuarios creadores


#[AllowDynamicProperties] 
class V_picture extends Model{
    /**
	 * Recupera los lugares de
	 *
	 * @return array lista de lugares del un usuario
	 */
	public function getLugaresCreador():array{
		$consulta = "SELECT * FROM V_places WHERE id=$this->username";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_places');
	}
	
    /**
	 * Recupera las fotos del lugar 
	 *
	 * @return array lista de fotos del lugar 
	 */
	public function getPhotos():array{
		$consulta = "SELECT * FROM V_pictures WHERE id=$this->id";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_socio');
	}
	

	
}