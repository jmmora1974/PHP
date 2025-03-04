<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Ejemplar extends Model{
	/** @var string $table nombre de la tabla en la bdd */
	protected  static $table = "ejemplares";
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['idlibro','anyo','precio','estado'];
	
	
	/**
	 * Recupera LOS prestamo de un ejemplar
	 *
	 * @return array lista de prestamos de un ejemplar
	 */
	public function getPrestamos():array{
		$consulta = "SELECT * FROM prestamos WHERE idejemplar=$this->id";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'Prestamo');
	}
	
	/**
	 * Recupera el prestamo de un ejemplar
	 *
	 * @return array lista de prestamos de un ejemplar
	 */
	public function getPrestamoActual():array{
		$consulta = "SELECT * FROM prestamos WHERE idejemplar=$this->id AND devolucion=null";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'Prestamo');
	}
	
}