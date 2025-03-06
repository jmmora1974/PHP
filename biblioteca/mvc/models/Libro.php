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
	/**
	 * Recupera los temas de un libro
	 *
	 * @return array lista de temas del libro
	 */
	public function getTemas():array{
		
		$temas = $this->belongsToMany('Tema','temas_libros');
		//$libros = $tema->belongsToMany(‘Libro’, ‘temas_libros’);
		//Retorna una lista de temas
		return $temas;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['isbn','titulo','editorial','idioma',
			'autor', 'edicion', 'anyo', 'edadrecomendada',
			'portada', 'caracteristicas', 'sinopsis','paginas'
	];
	
	
}