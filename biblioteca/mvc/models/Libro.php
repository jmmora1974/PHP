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
	
	/**
	 *  Añade un tema a un libro
	 *
	 *  @param int $idtema identificador del tema a añadir
	 *  @return int
	 */
	public function addTema(int $idtema):int{
		
		//prepara la consulta
		$consulta = "INSERT INTO temas_libros(idlibro,idtema)
					VALUES ($this->id,$idtema)";
		
		// Ejecuta el comando SQL
		return (DB_CLASS)::insert($consulta);
		
	}
	/**
	 *  Añade un tema a un libro
	 *
	 *  @param int $idtema identificador del tema a añadir
	 *  @return int
	 */
	public function removeTema(int $idtema):int{
		
		//prepara la consulta
		$consulta = "DELETE FROM temas_libros
					WHERE idlibro= $this->id AND idtema=$idtema";
		
		// Ejecuta el comando SQL
		return (DB_CLASS)::delete($consulta);
		
	}
	
	/** Metodo que retorna los errores de validación de un Libro,
	 * 
	 * Si no hay errores, retorna un array vacío.
	 * 
	 * @param bool $checkId Indica si se debe hacer la comprobación dobre el campo id (no se hace en un store pero si en un update)
	 * 
	 * @return array El listado de errores de validación
	 */
	public function validate(bool $checkId =false):array{
		$errores =[];
		
		//el campo id solamente se comprube en el udate()
		if($checkId && empty(intval($this->id)))
			$errores['id']="No se indicó el identificador";
		
			//ISBN: de 10 a 17 digitos o guiones medio
			if (empty($this->isbn)||!preg_match("/^\d[\d\-]{9,16}\d$/",$this->isbn))
				$errores['isbn']="Error en el formato de ISBN";
				
			//Titulo: de 1 a 64 caracteres
			if (empty($this->titulo)||strlen($this->titulo)<1 || strlen($this->titulo)>64)
				$errores['titulo']="Error en la longitud del titulo."  ;
				
			//edicio: numero positivo
			if (empty($this->edicion)|| strlen($this->edicion)<0)
				$errores['edicion']="Error en el numero de edición";
			
			//edad recomendada: de 0 a 120
				if (empty($this->edadrecomendada)
						|| intval($this->edadrecomendada) < 0 
						|| intval($this->edadrecomendada) > 120)
				$errores['edadrecomendada']="Error en la edad recomendada.";
				
			//Año: de 1900 al año actual
				$anyoactual=Date("Y");
				if (empty($this->anyo)|| intval($this->anyo) < 1900 || intval($this->anyo)>$anyoactual)
				$errores['anyo']="Error en el año del libro.";
			
			//Otras comprobaciones que queramos filtrar
			return $errores;	
	}
	
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['isbn','titulo','editorial','idioma',
			'autor', 'edicion', 'anyo', 'edadrecomendada',
			'portada', 'caracteristicas', 'sinopsis','paginas'
	];
	
	
}

