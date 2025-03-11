<?php
/**
* LibroController
* 
* Operaciones con los libros
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class LibroController extends Controller{
	
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
	 * Listado de libros
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
	  	
		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('libros');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de libros que cumplen los criterios del filtro
			$total = V_libro::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Libro/list', $page, $limit, $total,'es');
			
			//recupera los libros que cumplen los criteros del filtro
			$libros= V_libro::filter($filtro, $limit, $paginator->getOffset());
			// recupera los libros junto la información extra (ejemplares)
		} else {
			$total =V_libro::total(); //total del libro
			
			//crea el objeto paginador
			$paginator = new Paginator('/Libro/list', $page, $limit, $total,'es');
			
			
			$libros= V_libro::orderBy('titulo', 'ASC', $limit, $paginator->getOffset()); // recupera los libros junto la información extra (ejemplares)
			
			
		}
		
		
	 		//	carga la vista que los muestra
		return view('libro/list',['libros'=>$libros,'paginator'=>$paginator,'filtro' => $filtro]);
	}
	
	/**
	 * Muestra los detalles del un libro
	 * @param int $id identificador del libro a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
	
		// Recupera el libro
		$libro = Libro::findOrFail($id, 'No se encontró el libro indicado'); //tb comprueba si no le ha llegado el ID
		
		//recupera los ejemplares del libro
		$ejemplares= $libro->hasMany('Ejemplar');	
		
		//recuperamos los temas del libro
		$temas = $libro->getTemas();
		//$temas = $libro->belongsToMany('Tema','temas_libros'); //si no tenemos el getTemas
		
		// carga la vista y le pasa el libro recuperado
		return view ('libro/show',[
				'libro'=>$libro,
				'ejemplares'=>$ejemplares,
				'temas'=>$temas
				]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo libro
	 * @return ViewResponse
	 */
	public function create(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			return view('libro/create',['listaTemas'=>Tema::orderBy('tema')]);
		}
		return redirect('/libro');
		// si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
		
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');
			
			//recupera el idtema del desplegable
			$idtema = intval(request()->post('idtema'));
		//OPCION AUTOMATICA
				try{
					//cargamos la libreria de filtrado
					//require '../app/libraries/filtrado.php';
					
					$librotemp=new Libro(); //crea el nuevo libro temporal para crear y validar
					
			
					//guarda el libro en la base de datos a partir de los datosPOST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Libro
						$librotemp ->$campo=$valor;
					
					//antes sanearemos las entradas
					//$librotemp=request()->posts(); 
					
					//Validaremos que los datos sean correctos
					if($errores = $librotemp->validate())
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>")
						);
						
				//	foreach($librotemp as $campo=>$valor)  //SE FILTRA EN LA MODEL
					//		$campo = filtrado($valor);
					
							
					//$libro->saneate(); //sanea las entradas.
						$libro = Libro::create((array)$librotemp); //no es necesario en la  1.8.0
					$libro->addTema($idtema); // Le pone el tema principal
				
					
					//recupera la portada como objeto UploadedFile (o null si no llega)
					$file = request()->file(
							'portada', 	// nombre del input
							8000000, 	//tamaño maximo del fichero
							['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
					);
					
					//si hay fichero, lo guardamos y actualizamos el campo "portada"
					if($file){
						$libro->portada=$file->store('../public/'.BOOK_IMAGE_FOLDER, 'book_');
						$libro->update(); //actualiza el libro para añadir la portada
					}
					//flashea un mensaje de exito en sesion
					Session::success("Guardado del libro $libro->titulo correcto.");
					
					//redirecciona a los detalles del nuevo libro
					return redirect("/Libro/show/$libro->id");
				}  catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el libro $libro->titulo.";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un libro con ese <b>ISBN</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de libro
					return redirect("/Libro/create");
					
					//si falla el guardado de la portada
				} catch (UploadException $e) {
					//preparamos un mensaje de advertencia
					//no de errom puesto que el libro se guardó correctamente,
					Session::warning("El libro se guardó correctamente, pero no se pudo subir el fichero de imagen.");
					
					if(DEBUG)
						throw new UploadException($e->getMessage());
					
					//redirigimos a la edición del libro
					//por si quiere volver a intentar subir la image
					redirect("/Libro/edit/$libro->id");
						
					
				}
					// si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
			} else{
					return redirect('/libro');
			}
		
		
			
	

	// OPCION TRADICIONAL	
	/* 		$libro = new Libro(); //Crea un libro
			
			//toma los datos que llegan por POST 
			$libro->isbn	 	= request()->post('isbn');
			$libro->titulo	 	= request()->post('titulo');
			$libro->editorial 	= request()->post('editorial');
			$libro->autor		= request()->post('autor');
			$libro->idioma	 	= request()->post('idioma');
			$libro->edicion 	= request()->post('edicion');
			$libro->anyo	 	= request()->post('anyo');
			$libro->edadrecomendada 	= request()->post('edadrecomendada');
			$libro->paginas	 	= request()->post('paginas');
			$libro->caracteristicas 	= request()->post('caracteristicas');
			$libro->sinopsis	 	= request()->post('sinopsis');
			
			// Como en la configuración hemos indicado EMPTY_STRINGS_TO_NULL a true
			//los datos en blanco serán tomado como NULL.
			//En la BDD deberíamos permitir valores nulos en esos campos.
			
			//Si queremos poner lvalores por defecto podemos hacer:
			// $libro->paginas = request-> post('paginas')??-1;
			
			// intenta guardar el libro en caso de la insercion falle vamos a evitar ir a la pagina de error y volver alformulario "nuevo libro"
			try{
				//guarda el libro en la base de datos
				$libro->save();
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del libro $libro->titulo correcto.");
				
				//redirecciona a los detalles del nuevo libro
				return redirect("/Libro/show/$libro->id");
				
			//si falla el guardado del libro..
			} catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el libro $libro->titulo.";
				//flashe un mensaje de error en session
				Session::error($mensaje);
						
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				//if(DEBUG) 
					//throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de libro
				return redirect("/Libro/create");
			}
	}		
			
	*/		
}
	
	/** 
	 * Muestra el formulario de edición del libro
	 * 
	 * @param int $id el ID único del libro a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			// busca el libro con ese ID
			$libro = Libro::findOrFail($id,'No se encontró el libro.');
			
			//recupera los ejemplares del libro
			$ejemplares= $libro->hasMany('Ejemplar');
			
			//recuperamos los temas del libro
			$temas = $libro->getTemas();
			
			//Lista de temas ordenados alfabeticamente
			$listaTemas= array_diff(Tema::orderBy('tema'),$temas);
					
			//retorna una ViewResponse con la vista con el formulario de edición
			return view('libro/edit',['libro'=>$libro, 'ejemplares'=>$ejemplares, 
					'temas'=>$temas, 'listaTemas'=>$listaTemas]);
			
		// si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
	}
	
	
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
			
			$id = intval(request()->post('id')); // recuperar el id via POST
		
			
		//Con la actualización a 1.8.0 ya se puede recuperar el formulario y tratarlo directamente
		/*
			$libro = Libro::findOrFail($id,"No se ha encontrado el libro.");
			
			//recuperar el resto de campos 
			$libro->isbn	= request()->post('isbn');
			$libro->titulo	= request()->post('isbn');
			$libro->editorial	= request()->post('isbn');
			$libro->autor	= request()->post('isbn');
			$libro->idioma	= request()->post('isbn');
			$libro->edicion	= request()->post('isbn');
			$libro->anyo	= request()->post('isbn');
			$libro->edadrecomendada	= request()->post('isbn');
			$libro->paginas	= request()->post('isbn');
			$libro->caracteristicas = request()->post('isbn');
			$libro->sinopsis	= request()->post('isbn');
			*/
			
			//intenta actualizar el libro
			try{
				//$libro->update(); No es necesario en la 1.8.0 
				// ya el metodo create ya actualiza si manda el 2ºparametro
				//$libro->saneate(); //sanea las entradas.
				$libro= Libro::create(request()->posts() ,$id);
				//libro->update(); //actualiza solo los datos sin imagen de portada
				
				//recupera la portada como objeto UploadedFile (o null si no llega)
				$file = request()->file(
						'portada', 	// nombre del input
						8000000, 	//tamaño maximo del fichero
						['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
						);
				
				//si hay fichero, lo guardamos y actualizamos el campo "portada"
				if($file){
					if($libro->portada) //elimina el fichero anterior (si lo hay)
						File::remove('../public/'.BOOK_IMAGE_FOLDER.'/'.$libro->portada);
					//coloca el nuevo fichero y actualiza la propiedad
					$libro->portada=$file->store('../public/'.BOOK_IMAGE_FOLDER, 'book_');
					$libro->update(); //actualiza el libro para añadir la portada
				}
				//flashea un mensaje de exito en sesion
				Session::success("Actualización del libro $libro->titulo correcta.");
				return redirect("/Libro/edit/$id");
				
			// Si se produce un error al guardar el libro..
			}catch (SQLException $e){
				// prepara el mensaje de error
				$mensaje = "No se pudo actualizar el libro";
				
			if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un libro con ese <b>ISBN</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
				
					return redirect("/Libro/edit/$id");
			}catch (UploadException $e){
					$mensaje.="Cambios guardados, pero no se modificó la portada.";
					Session::error($mensaje);
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Libro/edit/$id");
			}
			// si no  tiene acceso, no informa del error, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
	
	}
	
	/**
	 * Elimina la imagen de portada
	 * 
	 * @return RedirectResponse
	 */
	public function dropcover(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			//Comprueba que la petición venga del formulario
			if(!request()->has('borrar'))
				throw new FormException('No se recibió el formulario');
				//$libro=new Libro(); //crea el nuevo libro
				
				//recupera el idtema del desplegable
				$id = intval(request()->post('id'));
				$libro = Libro::findOrFail($id, "no se ha encontrado el libro.");
				
				$tmp = $libro->portada; //recordatemos el nombre para poder borrarlo luego
				$libro->portada = NULL; //marca la portada a NULL
				
				try{
					//preimero guardamos en la bb y luego eliminamos el fichero
					$libro->update();
					File::remove('../public/'.BOOK_IMAGE_FOLDER.'/'.$tmp, true);
					
					Session::success("Borrado de la portada del libro $libro->titulo realizada.");
					return redirect("/Libro/edit/$libro->id");
	
				}  catch(SQLException $e){
					Session::error("No se pudo eliminar la portada.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Libro/edit/$id");
				} catch(FileException $e){
					Session::warning ("No se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Libro/edit/$id");
				}
				// si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
		
	}
	/**
	 *  Añade un tema a un libro
	 *
	 *  @return RedirectResponse
	 *  
	 */
	public function addTema(){
	
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
		
			if(!request()->has('add')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
				
			//recupera los identificadores necesarios (idlibro  e idtema)
			$idlibro = intval(request()->post('idlibro'));
			$idtema = intval(request()->post('idtema'));
			
			//recupera el libro
			$libro= Libro::findOrFail($idlibro,'No se encontró el libro');
			
			//recuperar el tema es opcional, si fallara la operación porque el tema
			//ya no existe, el mensade de error seria mñas claro para el usuario
			$tema = Tema::findOrFail($idtema,'No se encontó el tema');
			
			//intenta vicular el tema al libro
			try{
				$libro->addTema($idtema);
				Session::success("Se ha añadido el tema '$tema->tema' para el libro '$libro->titulo' correctamente.");
				return redirect("/Libro/edit/$idlibro");
			}catch (SQLException $e){
				Session::error("No se pudo añadir el tema $tema->tema del libro $libro->titulo.");
				if (DEBUG) 
						throw new SQLException($e->getMessage());
				return redirect("/Libro/edit/$idlibro");
			}
				
	
		 return redirect('/libro/edit/'.$temalibro->idlibro);
		 
		 // si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
	
		
	}
	/**
	 *  Añade un tema a un libro
	 *
	 *  @param int $idtema identificador del tema a añadir
	 * 
	 */
	public function removetema(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			if(!request()->has('remove')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
				
				//recupera los identificadores necesarios (idlibro  e idtema)
				$idlibro = intval(request()->post('idlibro'));
				$idtema = intval(request()->post('idtema'));
				
				//recupera el libro
				$libro= Libro::findOrFail($idlibro,'No se encontró el libro');
				
				//recuperar el tema es opcional, si fallara la operación porque el tema
				//ya no existe, el mensade de error seria mñas claro para el usuario
				$tema = Tema::findOrFail($idtema,'No se encontó el tema');
				
				//intenta vicular el tema al libro
				try{
					$libro->removeTema($idtema);
					Session::success("Se ha eliminado el tema '$tema->tema' para el libro '$libro->titulo' correctamente.");
					return redirect("/Libro/edit/$idlibro");
				
				//Si se produce un error
				}catch (SQLException $e){
					Session::error("No se pudo eliminar el tema $tema->tema del libro $libro->titulo.");
					if (DEBUG)
						throw new SQLException($e->getMessage());
						return redirect("/Libro/edit/$idlibro");
				}
				
				
				return redirect('/libro/edit/'.$temalibro->idlibro);
				// si no  tiene acceso, no informa del error, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
	}
	
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del libro a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
			$libro = Libro::findOrFail($id, "No existe el libro.");
			
			return view('libro/delete',['libro'=> $libro]);
			// si no  tiene acceso, no informa del error, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}
	
	}
	
	/** Elimina el libro de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios)
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$libro	=Libro::findOrFail($id);
			
			//si el libro tiene ejemplares, no permitiremos su borrado
			//mas adelante ocultaeremos el boton de "borrar" en estos casos 
			// para que no el usuario no llegue al formulario de confirmación
			if($libro->hasAny('Ejemplar'))
				throw new Exception("No se puede borrar el libro mientras tenga ejemplares.");
			
				//intenta borrar el libro
				try{
					$libro->deleteObject();
					
					//si hay imagen de la portada, hay que borrarla
					if($libro->portada)
						File::remove('../public/'.BOOK_IMAGE_FOLDER.'/'.$libro->portada,true);
					
					Session::success("Se ha borrado el libro $libro->titulo.");
					return redirect("/Libro/list");
				//si se produce un error en la operació con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el libro $libro->titulo.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Libro/delete/$id");
				}catch(FileException $e){
					Session::warning ("Se eliminó el libro pero no se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						//No podemos redirigir al libro porque ya no existe
						//volvemos al listado de libros
						return redirect("/Libro");
				}
				
			// si no  tiene acceso, no informa delerror, simplemente  redirige al listado de libros
		} else{
			return redirect('/libro');
		}

	}	
	 
}