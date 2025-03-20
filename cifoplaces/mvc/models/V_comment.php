<?php
//carga la vista de lugar y usuarios creadores


#[AllowDynamicProperties] 
class V_comment extends Model{
    /**
	 * Recupera los comentarios de un lugar
	 * 
	 *@param int idplace id del lugar
	 * @return array lista de comentarios del un lugar
	 */
	public function getComentariosLugar($idplace=0):array{
		$consulta = "SELECT * FROM V_comments WHERE idplace=$idplace";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_comments');
	}
	
    /**
	 * Recupera las fotos del lugar 
	 *@param int idplace id del lugar
	 * @return array lista de fotos del lugar 
	 */
	public function getPhotosLugar(int $idplace=0):array{
		$consulta = "SELECT * FROM V_pictures WHERE idplace=$idplace";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_pictures');
	}
	

	
}