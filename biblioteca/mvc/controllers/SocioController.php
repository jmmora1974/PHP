<?php
/**
* SocioController
* 
* Operaciones con los socios
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class SocioController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método list() de este mismo controlado.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
		 // autorización(solo bibliotecarios
			if( Login::role('ROLE_LIBRARIAN')) { 
				return $this->list();
			}
			//En caso de no se bibliotecariom, redirige al inicio
			return redirect('/');
	}
	
	/** 
	 * Listado de socios
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
		
    // autorización(solo bibliotecarios
	if( Login::role('ROLE_LIBRARIAN')) { 
		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('socios');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de socios que cumplen los criterios del filtro
			$total = Socio::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Socio/list', $page, $limit, $total,'es');
			
			//recupera los socios que cumplen los criteros del filtro
			$socios= Socio::filter($filtro, $limit, $paginator->getOffset());
			// recupera los socios junto la información extra (prestamos)
		} else {
			
			$total = Socio::total(); //total del socio
			
			//crea el objeto paginador
			$paginator = new Paginator('/Socio/list', $page, $limit, $total,'es');
			
			
			$socios= Socio::orderBy('nombre', 'ASC', $limit, $paginator->getOffset()); // recupera los socios junto la información extra (prestamos)
			
			
		}
		//	carga la vista que los muestra
		return view('socio/list',['socios'=>$socios,'paginator'=>$paginator,'filtro' => $filtro]);
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/**
	 * Muestra los detalles del un socio
	 * @param int $id identificador del socio a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
		
			$socio = V_socio::findOrFail($id, 'No se enontró el socio indicado'); //tb comprueba si no le ha llegado el ID
			
			//recupera los prestamos del socio
			$prestamos= $socio->hasMany('V_prestamo','idsocio','id'); //OK
			rsort( $prestamos);
			
			// carga la vista y le pasa el socio recuperado
			return view ('socio/show',['socio'=>$socio, 'prestamos'=>$prestamos]);
		}//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/**
	 * Muestra el formulario de nuevo socio
	 * @return ViewResponse
	 */
	public function create(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			return view('socio/create');
		}//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');
			$socio=new Socio(); //crea el nuevo socio
			
		//OPCION AUTOMATICA
				try{
					
					//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
					$sociotemp=new Socio(); //crea el nuevo libro temporal para crear y validar
					
					//guarda el socio en la base de datos a partir de los datos POST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Socio
						$sociotemp ->$campo=$valor;
						
						//Validaremos que los datos sean correctos
						if($errores = $sociotemp->validate())
							throw new ValidationException(
									"<br>".arrayToString($errores, false, false,".<br>")
									);
							
					//guarda el socio en la base de datos a partir de los datosPOST
					//$socio->saneate(); //sanea las entradas.
							$socio = Socio::create((array)$sociotemp); //mo es necesario en la  1.8.0
					
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto de perfil como objeto UploadedFile (o null si no llega)
					if($file = request()->file(
							'foto', 	// nombre del input
							8000000, 	//tamaño maximo del fichero
							['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
								$socio->foto=$file->store('../public/'.PROFILE_IMAGE_FOLDER, 'profile_');
								
					}
					//$socio->saneate(); //sanea las entradas.
					$socio->update();
					
					//flashea un mensaje de exito en sesion
					Session::success("Guardado del socio $socio->nombre $socio->apellidos correcto.");
					
					//redirecciona a los detalles del nuevo socio
					return redirect("/Socio/show/$socio->id");
				}  catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el socio $socio->nombre $socio->apellidos.";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un socio con ese <b>DNI</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de socio
					return redirect("/Socio/create");
				}
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** 
	 * Muestra el formulario de edición del socio
	 * 
	 * @param int $id el ID único del socio a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			// busca el socio con ese ID
			$socio = Socio::findOrFail($id,'No se encontró el socio.');
			
			//recupera los prestamos del socio
			$prestamos= $socio->hasMany('Prestamo');
			
			//retorna una ViewResponse con la vista con el formulario de edición
			return view('socio/edit',['socio'=>$socio,'prestamos'=>$prestamos]);
	
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
			
			$id = intval(request()->post('id')); // recuperar el id via POST
		
		
			//intenta actualizar el socio
			try{
				
				//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
				$sociotemp=new Socio(); //crea el nuevo libro temporal para crear y validar
				
				//guarda el socio en la base de datos a partir de los datos POST
				foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Socio
					$sociotemp ->$campo=$valor;
					
					//Validaremos que los datos sean correctos
					if($errores = $sociotemp->validate(true))
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>")
								);
						
				//$socio->update(); No es necesario en la 1.8.0 
				// ya el metodo create ya actualiza si manda el 2ºparametro
				//$socio->saneate(); //sanea las entradas.
				$socio= Socio::create((array)$sociotemp,$id);
				
				Session::success("Actualización del socio $socio->nombre  $socio->apellidos correcta.");
				return redirect("/Socio/edit/$id");
				
			// Si se produce un error al guardar el socio..
			}catch (SQLException $e){
				// prepara el mensaje de error
				$mensaje = "No se pudo actualizar el socio";
				
			if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un socio con ese <b>DNI</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
				
					return redirect("/Socio/edit/$id");
			}
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del socio a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			$socio = Socio::findOrFail($id, "No existe el socio.");
			
			return view('socio/delete',['socio'=> $socio]);
		}
		//En caso de no se bibliotecariom, redirige al inicio
		return redirect('/');
	}
	
	/** Elimina el socio de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$socio	=Socio::findOrFail($id);
			
			//si el socio tiene prestamos, no permitiremos su borrado
			//mas adelante ocultaeremos el boton de "borrar" en estos casos 
			// para que no el usuario no llegue al formulario de confirmación
			if($socio->hasAny('Prestamo'))
				throw new Exception("No se puede borrar el socio mientras tenga prestamos.");
			
				//intenta borrar el socio
				try{
					$socio->deleteObject();
					//si hay imagen de la perfil, hay que borrarla
					if($socio->foto){
						File::remove('../public/'.PROFILE_IMAGE_FOLDER.'/'.$socio->foto,true);
					
					}
						
					Session::success("Se ha borrado el socio $socio->nombre  $socio->apellidos.");
					return redirect("/Socio/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el socio $socio->nombre  $socio->apellidos.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Socio/delete/$id");
				}catch(FileException $e){
					Session::warning ("Se eliminó el socio $socio->nombre  $socio->apellidos pero no se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						//No podemos redirigir al socio porque ya no existe
						//volvemos al listado de socios
						return redirect("/Socio");
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
		if( Login::role('ROLE_LIBRARIAN')) { 
			//Comprueba que la petición venga del formulario
			if((!request()->has('borrar')) 
					&& (!request()->has('cambiar')))
				throw new FormException('No se recibió el formulario');
			
				//recupera el idtema del desplegable
				$id = intval(request()->post('id'));
				$socio = Socio::findOrFail($id, "no se ha encontrado el socio.");
				
				$tmp = $socio->foto; //recordatemos el nombre para poder borrarlo luego
				
				//en el caso de que se haya pulsado Eliminar
				if(request()->has('borrar'))
					$socio->foto = NULL; //marca la foto perfil a NULL
				
				try{
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto de perfil como objeto UploadedFile (o null si no llega)
					if($file = request()->file(
								'foto', 	// nombre del input
								8000000, 	//tamaño maximo del fichero
								['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
						$socio->foto=$file->store('../public/'.PROFILE_IMAGE_FOLDER, 'profile_');
						
					} else {
						if(request()->has('cambiar')){
							 Session::warning("Debes seleccionar la foto que deseas subir.");
						return redirect("/Socio/edit/$socio->id");
					 }
					}
					//$socio->saneate(); //sanea las entradas.
					$socio->update();
					Session::success("Se ha sustituido o eliminado la foto de perfil de $socio->nombre $socio->apellidos correctamente.");
					
					//si ya existia la foto, tratara de eliminarla primero
					if($tmp)
						File::remove('../public/'.PROFILE_IMAGE_FOLDER.'/'.$tmp, true);
						
					return redirect("/Socio/edit/$socio->id");
					
				}  catch(SQLException $e){
					Session::error("No se pudo eliminar la foto de perfil.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Socio/edit/$id");
				} catch(FileException $e){
					Session::warning ("No se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Socio/edit/$id");
				}catch (UploadException $e){
					$mensaje.="Cambios guardados, pero no se modificó la foto de perfil.";
					Session::error($mensaje);
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Socio/edit/$socio->id");
				}
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
	}
	
}	
	 
