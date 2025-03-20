<?php

#[AllowDynamicProperties] 
class Lugar extends Model{
	protected  static $table = "places";
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
			
		
			//localización: de 1 a 128 caracteres
			if (empty($this->location)||strlen($this->location)<1 || strlen($this->location)>128)
				$errores['poblacion']="Error en la longitud de la localización."  ;
			
			//CodigoPostal: de 5 caracteres
			//if (empty($this->cp)||strlen($this->cp)<5 || strlen($this->cp)>5)
				//$errores['CodigoPostal']="Error en la longitud de la CodigoPostal."  ;
						
			return $errores;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = [
		'name','type','location','description','iduser','mainpicture','latitude','longitude'
	];
	
	
	
	
	
	
	
	
}