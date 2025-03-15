<?php

#[AllowDynamicProperties] 
class Anuncio extends Model{
	
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
			
		//nombre: de 1 a 64 caracteres
			if (empty($this->titulo)||strlen($this->titulo)<1 || strlen($this->titulo)>64)
				$errores['titulo']="Error en la longitud del titulo."  ;
		
			//Apellidos: de 1 a 128 caracteres
			if (empty($this->descripcion)||strlen($this->descripcion)<1 || strlen($this->descripcion)>128)
				$errores['descripcion']="Error en la longitud de la descripcion."  ;
			
			//Otras comprobaciones que queramos filtrar
			return $errores;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['titulo','descripcion','precio','fecha','iduser','poblacion'
	];
	
}