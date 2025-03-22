<?php

#[AllowDynamicProperties] 
class Photo extends Model{
	
	/** Metodo que retorna los errores de validación de un Socio,
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
			$errores['id']="No se indicó el identificador $this->id . ";
		
		//name: de 1 a 64 caracteres
			if (empty($this->name)||strlen($this->name)<1 || strlen($this->name)>64)
				$errores['titulo']="Error en la longitud del nombre."  ;
		
			//description: de 1 a 128 caracteres
			if (empty($this->description)||strlen($this->description)<1 || strlen($this->description)>128)
				$errores['descripcion']="Error en la longitud de la descripcion."  ;
			
		
			//alt: de 1 a 128 caracteres
			if (empty($this->alt)||strlen($this->alt)<1 || strlen($this->alt)>128)
				$errores['alt']="Error en la longitud del titulo alternativo."  ;
			
			//idplace: de 5 caracteres
			if (empty($this->idplace))
				$errores['idplace']="El identificador del lugar es obligatorio"  ;
			 				
			return $errores;
	}
	
	/**
	 * Recupera Los comentarios de una foto
	 *
	 * @return array lista de comentarios de una foto
	 */
	public function getComentarios():array{
		$photocomments = V_comment::getFiltered('idphoto', $this->id,'created_at','DESC' );
		
		//Retorna una lista de comentarios
		return $photocomments;
	}
	
	
	
	//campos en los que se permite asignación masiva
	protected static $fillable = [
		'name','alt','description','date','time','iduser','idplace'
	];
	
	
	
	
	
	
	
	
}