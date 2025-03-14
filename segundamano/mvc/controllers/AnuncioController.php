<?php
/**
* AnuncioController
* 
* Operaciones con los anuncios
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class AnuncioController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método list() de este mismo controlado.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
		
				return $this->list();
	}
	
	/** 
	 * Listado de anuncios
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
		
   
		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('anuncios');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de anuncios que cumplen los criterios del filtro
			$total = Anuncio::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Anuncio/list', $page, $limit, $total,'es');
			
			//recupera los anuncios que cumplen los criteros del filtro
			$anuncios= Anuncio::filter($filtro, $limit, $paginator->getOffset());
			// recupera los anuncios junto la información extra (prestamos)
		} else {
			
			$total = Anuncio::total(); //total del anuncio
			
			//crea el objeto paginador
			$paginator = new Paginator('/Anuncio/list', $page, $limit, $total,'es');
			
			
			$anuncios= Anuncio::orderBy('titulo', 'ASC', $limit, $paginator->getOffset()); // recupera los anuncios junto la información extra (prestamos)
			
			
		}
		//	carga la vista que los muestra
		return view('anuncio/list',['anuncios'=>$anuncios,'paginator'=>$paginator,'filtro' => $filtro]);
		
	}
	
	/**
	 * Muestra los detalles del un anuncio
	 * @param int $id identificador del anuncio a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
			
			$anuncio = Anuncio::findOrFail($id, 'No se enontró el anuncio indicado'); //tb comprueba si no le ha llegado el ID
			
			
			// carga la vista y le pasa el anuncio recuperado
			return view ('anuncio/show',['anuncio'=>$anuncio, 'prestamos'=>$prestamos]);
	}
	
	/**
	 * Muestra el formulario de nuevo anuncio
	 * @return ViewResponse
	 */
	public function create(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_USER')) { 
			return view('anuncio/create');
		}//En caso de no se bibliotecariom, redirige al inicio
		Session::warning("Para crear anuncios has de estar registrado.");
		return redirect('/login');
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_PUBLISHER')) { 
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');

		$anuncio=new Anuncio(); //crea el nuevo anuncio
			
		//OPCION AUTOMATICA
				try{
					
					//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
					$anunciotemp=new Anuncio(); //crea el nuevo libro temporal para crear y validar
					
					//guarda el anuncio en la base de datos a partir de los datos POST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Anuncio
						$anunciotemp ->$campo=$valor;
						
						//Validaremos que los datos sean correctos
						if($errores = $anunciotemp->validate())
							throw new ValidationException(
									"<br>".arrayToString($errores, false, false,".<br>")
									);
							
					//guarda el anuncio en la base de datos a partir de los datosPOST
					//$anuncio->saneate(); //sanea las entradas.
							$anuncio = Anuncio::create((array)$anunciotemp); //mo es necesario en la  1.8.0
					
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto de perfil como objeto UploadedFile (o null si no llega)
					if($file = request()->file(
							'imagen', 	// nombre del input
							8000000, 	//tamaño maximo del fichero
							['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
								$anuncio->foto=$file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'anuncio_');
								
					}
					//$anuncio->saneate(); //sanea las entradas.
					$anuncio->update();
					
					//flashea un mensaje de exito en sesion
					Session::success("Guardado del anuncio $anuncio->nombre $anuncio->apellidos correcto.");
					
					//redirecciona a los detalles del nuevo anuncio
					return redirect("/Anuncio/show/$anuncio->id");
				}  catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el anuncio $anuncio->nombre $anuncio->apellidos.";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un anuncio con ese <b>DNI</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de anuncio
					return redirect("/Anuncio/create");
				}
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** 
	 * Muestra el formulario de edición del anuncio
	 * 
	 * @param int $id el ID único del anuncio a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_PUBLISHER')) { 
			// busca el anuncio con ese ID
			$anuncio = Anuncio::findOrFail($id,'No se encontró el anuncio.');
			
			
			
			//retorna una ViewResponse con la vista con el formulario de edición
			return view('anuncio/edit',['anuncio'=>$anuncio,'prestamos'=>$prestamos]);
	
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_PUBLISHER')) { 
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
			
			$id = intval(request()->post('id')); // recuperar el id via POST
		
		
			//intenta actualizar el anuncio
			try{
				
				//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
				$anunciotemp=new Anuncio(); //crea el nuevo libro temporal para crear y validar
				
				//guarda el anuncio en la base de datos a partir de los datos POST
				foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Anuncio
					$anunciotemp ->$campo=$valor;
					
					//Validaremos que los datos sean correctos
					if($errores = $anunciotemp->validate(true))
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>")
								);
						
				//$anuncio->update(); No es necesario en la 1.8.0 
				// ya el metodo create ya actualiza si manda el 2ºparametro
				//$anuncio->saneate(); //sanea las entradas.
				$anuncio= Anuncio::create((array)$anunciotemp,$id);
				
				Session::success("Actualización del anuncio $anuncio->titulo correcta.");
				return redirect("/Anuncio/edit/$id");
				
			// Si se produce un error al guardar el anuncio..
			}catch (SQLException $e){
				// prepara el mensaje de error
				$mensaje = "No se pudo actualizar el anuncio";
				
			if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un anuncio con ese <b>DNI</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
				
					return redirect("/Anuncio/edit/$id");
			}
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del anuncio a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_PUBLISHER')) { 
			$anuncio = Anuncio::findOrFail($id, "No existe el anuncio.");
			
			return view('anuncio/delete',['anuncio'=> $anuncio]);
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** Elimina el anuncio de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_PUBLISHER')) { 
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$anuncio	=Anuncio::findOrFail($id);
			
					//intenta borrar el anuncio
				try{
					$anuncio->deleteObject();
					//si hay imagen de la perfil, hay que borrarla
					if($anuncio->foto){
						File::remove('../public/'.ANUNCIO_IMAGE_FOLDER.'/'.$anuncio->foto,true);
					
					}
						
					Session::success("Se ha borrado el anuncio $anuncio->nombre  $anuncio->apellidos.");
					return redirect("/Anuncio/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el anuncio $anuncio->nombre  $anuncio->apellidos.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/delete/$id");
				}catch(FileException $e){
					Session::warning ("Se eliminó el anuncio $anuncio->nombre  $anuncio->apellidos pero no se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						//No podemos redirigir al anuncio porque ya no existe
						//volvemos al listado de anuncios
						return redirect("/Anuncio");
				}
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/**
	 * Elimina la imagen de perfil
	 *
	 * @return RedirectResponse
	 */
	public function changefotoprofile(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_USER')) { 
			//Comprueba que la petición venga del formulario
			if((!request()->has('borrar')) 
					&& (!request()->has('cambiar')))
				throw new FormException('No se recibió el formulario');
			
				//recupera el idtema del desplegable
				$id = intval(request()->post('id'));
				$anuncio = Anuncio::findOrFail($id, "no se ha encontrado el anuncio.");
				
				$tmp = $anuncio->foto; //recordatemos el nombre para poder borrarlo luego
				
				//en el caso de que se haya pulsado Eliminar
				if(request()->has('borrar'))
					$anuncio->foto = NULL; //marca la foto perfil a NULL
				
				try{
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto de perfil como objeto UploadedFile (o null si no llega)
					if($file = request()->file(
								'foto', 	// nombre del input
								8000000, 	//tamaño maximo del fichero
								['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
						$anuncio->foto=$file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'profile_');
						
					} else {
						if(request()->has('cambiar')){
							 Session::warning("Debes seleccionar la foto que deseas subir.");
						return redirect("/Anuncio/edit/$anuncio->id");
					 }
					}
					//$anuncio->saneate(); //sanea las entradas.
					$anuncio->update();
					Session::success("Se ha sustituido o eliminado la foto de perfil de $anuncio->nombre $anuncio->apellidos correctamente.");
					
					//si ya existia la foto, tratara de eliminarla primero
					if($tmp)
						File::remove('../public/'.ANUNCIO_IMAGE_FOLDER.'/'.$tmp, true);
						
					return redirect("/Anuncio/edit/$anuncio->id");
					
				}  catch(SQLException $e){
					Session::error("No se pudo eliminar la foto de perfil.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$id");
				} catch(FileException $e){
					Session::warning ("No se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$id");
				}catch (UploadException $e){
					$mensaje.="Cambios guardados, pero no se modificó la foto de perfil.";
					Session::error($mensaje);
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$anuncio->id");
				}
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
	}
	
}	
	 
