<?php

#[AllowDynamicProperties] 
class Socio extends Model{
	/**
	 * Recupera los prestamos de un socio
	 *
	 * @return array lista de prestamos del socio
	 */
	public function getPrestamos():array{
		$consulta = "SELECT * FROM V_prestamos WHERE idsocio=$this->id";
		
		//Retorna una lista de Prestamo
		return DBMysqli::selectAll($consulta,'V_prestasmo');
	}
	
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
			$errores['id']="No se indicó el identificador";
			
			//DNI: de  9 digitos acabadao en letra y puede comenzar por XYZ para el NIF||strlen($this->dni<9 || strlen($this->dni)>9)
			if (empty($this->dni)||!preg_match('/^[XYZ0-9]{1}[0-9]{7}[A-Z]{1}$/i',$this->dni) )
				$errores['dni']="Error en el formato de DNI/NIE ";
				
			//nombre: de 1 a 64 caracteres
			if (empty($this->nombre)||strlen($this->nombre)<1 || strlen($this->nombre)>64)
				$errores['nombre']="Error en la longitud del nombre."  ;
		
			//Apellidos: de 1 a 128 caracteres
			if (empty($this->apellidos)||strlen($this->apellidos)<1 || strlen($this->apellidos)>128)
				$errores['apellidos']="Error en la longitud de los apellidos."  ;
			
			//Población: de 1 a 128 caracteres
			//if (empty($this->poblacion)||strlen($this->poblacion)<1 || strlen($this->poblacion)>128)
				//$errores['poblacion']="Error en la longitud de la población."  ;
			
			//CodigoPostal: de 5 caracteres
			//if (empty($this->cp)||strlen($this->cp)<5 || strlen($this->cp)>5)
				//$errores['CodigoPostal']="Error en la longitud de la CodigoPostal."  ;
			
			//telefono: numero de 9 digitos y que comienzen por 6,7,8 o 9
			if (empty($this->telefono)|| strlen($this->telefono)<9 || strlen($this->telefono)>9
						||!preg_match('/^[6-9]{1}[0-9]{8}$/i',$this->telefono))
				$errores['telefono']="Error en el numero de telefono $this->telefono ";
					
					
			//Provincia: de 1 a 128 caracteres
			//	if (empty($this->procincia)||strlen($this->procincia)<1 || strlen($this->procincia)>128)
			//	$errores['procincia']="Error en la longitud de la procincia."  ;
			
			//Otras comprobaciones que queramos filtrar
			return $errores;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['dni','nombre','apellidos','poblacion',
			'telefono','email'
	];
	
}