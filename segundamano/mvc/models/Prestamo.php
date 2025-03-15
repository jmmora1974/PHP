<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Prestamo extends Model{
	
	/** Metodo que retorna los errores de validación de un Libro,
	 *
	 * Si no hay errores, retorna un array vacío.
	 *
	 * @param bool $checkId Indica si se debe hacer la comprobación dobre el campo id (no se hace en un store pero si en un update)
	 *
	 * @return array El listado de errores de validación
	 */
	public function validate(bool $checkId =false, bool $checkInc =false):array{
		$errores =[];
		
		//el campo id solamente se comprube en el udate()
		if($checkId && empty(intval($this->id)))
			$errores['id']="No se indicó el identificador";
			
			//el campo idsocio
			if(!intval($this->idsocio)|| strlen(intval($this->idsocio)<0))
				$errores['idsocio']="No se indicó el identificador de socio";
				
			//el campo idejemplar 
				if(!intval($this->idejemplar)|| strlen(intval($this->idejemplar)<0))
				$errores['idejemplar']="No se indicó el identificador de ejemplar. ";
				
			//Limite: La fecha limite ha de ser superior al dia actual
				$diaactual=Date("Y-m-d");
			if (empty($this->limite)|| $this->limite<$diaactual)
				$errores['limite']="Error en la fecha limite $this->limite ha de ser posterior a $diaactual";
			
			//Incidencia: de 1 a 256 caracteres
				if ($checkInc && (empty($this->incidencia)||strlen($this->incidencia)<1 || strlen($this->incidencia)>256))
				$errores['titulo']="Error en la longitud de la incidencia."  ;
				//Otras comprobaciones que queramos filtrar
				return $errores;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = ['idsocio','idejemplar','limite'];
}