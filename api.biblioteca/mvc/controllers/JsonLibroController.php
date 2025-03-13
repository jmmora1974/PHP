<?php

/** JsonLibroController
 *
 * Clase que nos provee del ENDPOINT para trabajar con Libros en JSON
 *
 * Última revisión: 16/03/2025
 *
 * @author Jose M Mora Perez<jmmora1974@gmail.com>
 */

class JsonLibroController extends Controller{
	
	/**
	 * Metodo para respoder a las peticiones GET (cRud)
	 * 
	 * @param1 mixed $param1 primer parámetro, en /json/libro/titulo/css es 'titulo'
	 * @param2 mixed $param1 segundo parámetro, en /json/libro/titulo/css es 'css'
	 *
	 * @return JsonResponse
	 */
	public function get(
			mixed $param1 = NULL, //primer parámetro, en /json/libro/titulo/css es 'titulo'
			mixed $param2= NULL //segundo parámetro, en /json/libro/titulo/css es 'css'
			):JsonResponse{
			//	Auth::guest();   // solo para usuarios no identificados
			
				//si no se reciben parámetros, recupera todos loss libros
				if(!$param1&&!$param2)
					$libros = Libro::all();
				
				//si  recibimos dos parametros se trata de un a busqueda filtrada
				if($param1&&$param2)
					$libros = Libro::getFiltered($param1,$param2);
					
				//si recibimos un parametroo es una busqueda por id
				if($param1 && !$param2)
					$libros =[
							Libro::findOrFail(intval($param1),"No se encontró el libro")
							];
				//preparar la respuesta y retornar el resultado pasado a JSON
				return new JsonResponse(
						$libros, // data
						"Se han recuperado ".sizeof($libros)." resultados. "  //Mensaje
						);
			}
			
	/** 
	 *  Metodo para respoder a las peticiones DELETE (cRud)
	 *  
	 *  @id int|string identidifador del libro a borrar
	 *  
	 *  @return JsonResponse
	 */
			public function delete(mixed $id=0):JsonResponse{
				
				$libro = Libro::findOrFail(intval($id), "No se encontró el libro. ");
				
				if($libro->hasMany('Ejemplar'))  //si el libro tiene ejemplares
					throw new ApiException('No se puede eliminar un libro con ejemplares');
				
					$libro->deleteObject(); //intenta borrar el libro
					
					//si tiene portada, hay que eliminarla
					//Require configurar las constantes del config
					if($libro->portada)
						File::remove(BOOK_IMAGE_FOLDER."/".$libro->portada);
					
					//prepara la respuesta y retornar el resultado pasado a JSON
					return new JsonResponse (
							[$libro],   //data
							"Borrado del libro $libro->titulo correcto.", //mensaje
						);
			}
			
	/**
	 *  Metodo para respoder a las peticiones POST (cRud)
	 *
	 *  @return JsonResponse
	 */
	public function post():JsonResponse{
		
		//recupera los datos que llega en JSON en el body de la Request
		$libros = request()->fromJSON('Libro');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Guardado correcto.",  201, "CREATED");
		
		//para cada libro recuperado desde el cuerpo de la petción en JSON..
		foreach ($libros as $libro){
			
			$libro->saneate();
			
			//comprueba los errores de validación
			if ($errores = $libro->validate()){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$libro->titulo tiene errores de validación: "
						.arraToString($errores,false,false)
				);
			} else {  // si no hay errores de validación...
				
				try {
					$libro->save();
					$response->addData("$libro->titulo guardado correctamente.");
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");	
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$libro->titulo.' '.(DEBUG ? $t->getMessage():"duplicado?")
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
		$libros = request()->fromJson('Libro');
		
		//prepara una JsonResponse (que modificaremos despues)
		$response = new JsonResponse([],"Actualización correcta.");
		
		//para cada libro recuperado desde el cuerpo de la petción en JSON..
		foreach ($libros as $libro){
			
			$libro->saneate(); //Sanea las entradas
			
			//comprueba los errores de validación
			if ($errores = $libro->validate(true)){
				$response->setMessage("Se han producido errores.");
				$response->setStatus("WITH ERRORS");
				$response->addData(
						"$libro->titulo tiene errores de validación: "
						.arraToString($errores,false,false)
						);
			} else {  // si no hay errores de validación...
				
				try {
					$libro->update();
					$response->addData("$libro->titulo actualizado correctamente.");
					
				} catch (Thorwable $t){  //si hay errores al guardar..
					$response->setMessage("Se han producido errores");
					$response->setStatus("WITH ERRORS");
					$response->addData(
							$libro->titulo.' '.(DEBUG ? $t->getMessage():"duplicado?")
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


