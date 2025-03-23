<?php
//carga la configuracion y el autoload


#[AllowDynamicProperties] 
class Comentario extends Model{
	protected  static $table = "comments";

	/** Metodo que retorna los errores de validación de un comentario,
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
	
			//text: de 1 a 256 caracteres
		if (empty($this->text)||strlen($this->text)<1 || strlen($this->text)>256)
				$errores['text']="Error en la longitud del comentario"  ;
			
		
						
			return $errores;
	}
	
	//campos en los que se permite asignación masiva
	protected static $fillable = [
		'text','iduser','idphoto','idplace'
	];
	
}