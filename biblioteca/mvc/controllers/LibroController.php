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
	public function list(){
		$libros = Libro::orderBy();  //sale ordenado
	
		//	carga la vista que los muestra
		return view('libro/list',['libros'=>$libros]);
	}
	
	/**
	 * Muestra los detalles del un libro
	 * @param int $id identificador del libro a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
	
		$libro = Libro::findOrFail($id, 'No se enontró el libro indicado'); //tb comprueba si no le ha llegado el ID
		
		// carga la vista y le pasa el libro recuperado
		return view ('libro/show',['libro'=>$libro]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo libro
	 * @return ViewResponse
	 */
	public function create(){
		return view('libro/create');
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		//Comprueba que la petición venga del formulario
		if(!request()->has('guardar'))
			throw new FormException('No se recibió el formulario');
		$libro=new Libro(); //crea el nuevo libro
		
	//OPCION AUTOMATICA
			try{
				//guarda el libro en la base de datos a partir de los datosPOST
				$libro = Libro::create(request()->posts()); //mo es necesario en la  1.8.0
				
				
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
		
		// busca el libro con ese ID
		$libro = Libro::findOrFail($id,'No se encontró el libro.');
		
		//retorna una ViewResponse con la vista con el formulario de edición
		return view('libro/edit',['libro'=>$libro]);
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		
		if(!request()->has('actualizar')) //si no llega el formulario ...
			throw new FormException ('No se recibieron datos');
		
		$id = intval(request()->post('$id')); // recuperar el id via POST
		
		
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
			$libro= Libro::create(request()->posts() ,$id);
			
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
		}
	}
	
	
}	
	 
