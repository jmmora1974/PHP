<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Tema extends Model{
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['tema','descripcion'];
	
	/**
	 * Recupera los libro del tema
	 *
	 * @return array lista de temas del libro
	 */
	public function getLibrosTema():array{
		
		//$temas = $this->belongsToMany('Tema','temas_libros');
		$libros = $this->belongsToMany('Libro', 'temas_libros');
		//Retorna una lista de temas
		return $libros;
	}
	
	
	
}