<?php

/** JsonSocioController
 *
 * Clase que nos provee del ENDPOINT para trabajar con Socios en JSON
 *
 * Última revisión: 16/03/2025
 *
 * @author Jose M Mora Perez<jmmora1974@gmail.com>
 */

class JsonSocioController extends Controller{
	
	/**
	 * Metodo para respoder a las peticiones GET (cRud)
	 * 
	 * @param1 mixed $param1 primer parámetro, en /json/socio/titulo/css es 'titulo'
	 * @param2 mixed $param1 segundo parámetro, en /json/socio/titulo/css es 'css'
	 *
	 * @return JsonResponse
	 */
	public function get(
			mixed $param1 = NULL, //primer parámetro, en /json/socio/nombre/jose es 'nombre'
			mixed $param2= NULL //segundo parámetro, en /json/socio/nobre/jose es 'jose'
			):JsonResponse{
			//	Auth::guest();   // solo para usuarios no identificados
			
				//si no se reciben parámetros, recupera todos loss socios
				if(!$param1 && !$param2)
					$socios = Socio::all();
				
				//si  recibimos dos parametros se trata de un a busqueda filtrada
				if($param1&&$param2)
					$socios = Socio::getFiltered($param1,$param2);
					
				//si recibimos un parametroo es una busqueda por id
				if($param1&&!$param2)
					$socios =[
							Socio::findoOrFail(intval($param1),"No se encontró el socio")
							];
				//preparar la respuesta y retornar el resultado pasado a JSON
				return new JsonResponse(
						$socios, // data
						"Se han recuperado ".sizeof($socios)." resultados. "  //Mensaje
						);
			}
			
	/** 
	 *  Metodo para respoder a las peticiones DELETE (cRud)
	 *  
	 *  @id int|string identidifador del socio a borrar
	 *  
	 *  @return JsonResponse
	 */
			public function delete(int|string $id=0):JsonResponse{
				
				$socio = Socio::findOrFail(intval($id), "No se encontró el socio. ");
				
				//si el socio tiene prestamos, no permitiremos su borrado
				if($socio->hasAny('Prestamo'))
					throw new ApiException("No se puede borrar el socio mientras tenga prestamos.");
					
					try{
							$socio->deleteObject(); //intenta borrar el socio
							//si hay imagen de la perfil, hay que borrarla
							if($socio->foto)
								File::remove('../public/'.PROFILE_IMAGE_FOLDER.'/'.$socio->foto,true);
								
					} catch (Thorwable $t){  //si hay errores al guardar..
						$response =new JsonResponse ([],'Error al borrar el socio'.$socio->nombre.' '.$socio->apellidos);
						$response->setMessage("Se han producido errores al borrar");
						$response->setStatus("WITH ERRORS");
						$response->addData(
								'Error al borrar el socio'.$socio->nombre.' '.$socio->apellidos
								);
						return $response;
					}
					
					//prepara la respuesta y retornar el resultado pasado a JSON
					return new JsonResponse (
							[$socio],   //data
							"Borrado del socio $socio->nombre.' '.$socio->apellidos correcto.", //mensaje
						);
			}
			
	/**
	 *  Metodo para respoder a las peticiones POST (cRud)
	 *
	 *  @return JsonResponse
	 */
	public function post():JsonResponse{
		
		//recupera los datos que llega en JSON en el body de la Request
		$socios = request()->fromJSON('Socio');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Guardado correcto.",  201, "CREATED");
		
		//para cada socio recuperado desde el cuerpo de la petción en JSON..
		foreach ($socios as $socio){
			
			$socio->saneate();
			
			//comprueba los errores de validación
			if ($errores = $socio->validate()){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$socio->nombre.' '.$socio->apellidos tiene errores de validación: "
						.arraToString($errores,false,false)
				);
			} else {  // si no hay errores de validación...
				
				try {
					$socio->save();
					$response->addData("$socio->nombre.' '.$socio->apellidos guardado correctamente.");
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");	
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$socio->nombre.' '.$socio->apellidos.' '.(DEBUG ? $t->getMessage():"duplicado?")
							);
				}
				
			}
		}
				return $response;
	}
	/**
	 *  Metodo para respoder a las peticiones PUT (cRud)
	 *
	 *  @return JsonResponse
	 */
	public function put():JsonResponse{
		
		//recupera los datos que llega en JSON en el body de la Request
		$socios = request()->fromJson('Socio');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Actualización correcta.");
		
		//para cada socio recuperado desde el cuerpo de la petción en JSON..
		foreach ($socios as $socio){
			
			$socio->saneate(); //Sanea las entradas
			
			//comprueba los errores de validación
			if ($errores = $socio->validate(true)){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$socio->nombre.' '.$socio->apellidos tiene errores de validación: "
						.arraToString($errores,false,false)
						);
			} else {  // si no hay errores de validación...
				
				try {
					$socio->update();
					$response->addData("nombre.' '.$socio->apellidos actualizado correctamente.");
					
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$socio->titulo.' '.(DEBUG ? $t->getMessage():"duplicado?")
							);
				}
				
			}
		}
		return  $response;
	}
	
	/**
	 *  Metodo para respoder a las peticiones PATCH (cRud)
	 *
	 *  @return JsonResponse
	 */
	public function patch():JsonResponse{
		return $this->put(); //Redirigimos al put
	}
		
}


