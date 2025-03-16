<?php

/** JsonAnuncioController
 *
 * Clase que nos provee del ENDPOINT para trabajar con Anuncios en JSON
 *
 * Última revisión: 15/03/2025
 *
 * @author Jose M Mora Perez<jmmora1974@gmail.com>
 */

class JsonAnuncioController extends Controller{
	
	/**
	 * Metodo para respoder a las peticiones GET (cRud)
	 * 
	 * @param1 mixed $param1 primer parámetro, en /json/anuncio/titulo/css es 'titulo'
	 * @param2 mixed $param1 segundo parámetro, en /json/anuncio/titulo/css es 'css'
	 *
	 * @return JsonResponse
	 */
	public function get(
			mixed $param1 = NULL, //primer parámetro, en /json/anuncio/titulo/coche es 'titulo'
			mixed $param2= NULL //segundo parámetro, en /json/anuncio/titulo/coche es 'css'
			):JsonResponse{
			//	Auth::guest();   // solo para usuarios no identificados
			
				//si no se reciben parámetros, recupera todos loss anuncios
				if(!$param1&&!$param2)
					$anuncios = Anuncio::all();
				
				//si  recibimos dos parametros se trata de un a busqueda filtrada
				if($param1&&$param2)
					$anuncios = Anuncio::getFiltered($param1,$param2);
					
				//si recibimos un parametroo es una busqueda por id
				if($param1 && !$param2)
					$anuncios =[
							Anuncio::findOrFail(intval($param1),"No se encontró el anuncio")
							];
				//preparar la respuesta y retornar el resultado pasado a JSON
				return new JsonResponse(
						$anuncios, // data
						"Se han recuperado ".sizeof($anuncios)." resultados. "  //Mensaje
						);
			}
			
	/** 
	 *  Metodo para respoder a las peticiones DELETE (cRud)
	 *  
	 *  @id int|string identidifador del anuncio a borrar
	 *  
	 *  @return JsonResponse
	 */
			public function delete(int|string $id=0):JsonResponse{
				
				$anuncio = Anuncio::findOrFail(intval($id), "No se encontró el anuncio. ");
				
					$anuncio->deleteObject(); //intenta borrar el anuncio
					
					//si tiene portada, hay que eliminarla
					//Require configurar las constantes del config
					if($anuncio->portada)
						File::remove(BOOK_IMAGE_FOLDER."/".$anuncio->portada);
					
					//prepara la respuesta y retornar el resultado pasado a JSON
					return new JsonResponse (
							[$anuncio],   //data
							"Borrado del anuncio $anuncio->titulo correcto.", //mensaje
						);
			}
			
	/**
	 *  Metodo para respoder a las peticiones POST (cRud)
	 *
	 *  @return JsonResponse
	 */
	public function post():JsonResponse{
		
		//recupera los datos que llega en JSON en el body de la Request
		$anuncios = request()->fromJSON('Anuncio');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Guardado correcto.",  201, "CREATED");
		
		//para cada anuncio recuperado desde el cuerpo de la petción en JSON..
		foreach ($anuncios as $anuncio){
			
			$anuncio->saneate();
			$user=User::findOrFail($anuncio->iduser,"No se encontró el usuario.");
			//comprueba los errores de validación
			if ($errores = $anuncio->validate()){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$anuncio->titulo tiene errores de validación: "
						.arraToString($errores,false,false)
				);
			} else {  // si no hay errores de validación...
				
				try {
					$anuncio->save();
					$response->addData("$anuncio->titulo guardado correctamente.");
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");	
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$anuncio->titulo.' '.(DEBUG ? $t->getMessage():"duplicado?")
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
		$anuncios = request()->fromJson('Anuncio');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Actualización correcta.");
		
		//para cada anuncio recuperado desde el cuerpo de la petción en JSON..
		foreach ($anuncios as $anuncio){
			$anunciook=Anuncio::findOrFail($anuncio->id,"No se encontró el anuncio $anuncio->titulo.");
			$anuncio->saneate(); //Sanea las entradas
			
			//comprueba los errores de validación
			if ($errores = $anuncio->validate(true)){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$anuncio->titulo tiene errores de validación: "
						.arraToString($errores,false,false)
						);
			} else {  // si no hay errores de validación...
				
				try {
					$anuncio->update();
					$response->addData("$anuncio->titulo actualizado correctamente.");
					
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$anuncio->titulo.' '.(DEBUG ? $t->getMessage():"duplicado?")
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


